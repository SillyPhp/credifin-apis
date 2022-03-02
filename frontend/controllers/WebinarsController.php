<?php

namespace frontend\controllers;

use common\models\Speakers;
use common\models\User;
use common\models\Users;
use common\models\UserWebinarInterest;
use common\models\Webinar;
use common\models\WebinarEvents;
use common\models\WebinarOutcomes;
use common\models\WebinarPayments;
use common\models\WebinarRegistrations;
use common\models\WebinarRewards;
use common\models\Webinars;
use common\models\WebinarSessions;
use common\models\WebinarSpeakers;
use common\models\WebinarWidgetTemplates;
use frontend\models\webinars\webinarFunctions;
use frontend\models\webinars\WebinarRequestForm;
use yii\db\Expression;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\httpclient\Client;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;
use common\models\Utilities;
use yii\web\HttpException;

class WebinarsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['live'],
                'rules' => [
                    [
                        'actions' => ['live'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionLive($slug)
    {
        $user_id = Yii::$app->user->identity->user_enc_id;
        $webinarDetail = self::getWebianrDetail($slug, true);
//        $webinars = self::getWebianrs($id);
        $speakerUserIds = ArrayHelper::getColumn($webinarDetail['webinarSpeakers'], 'user_enc_id');
        if (in_array($user_id, $speakerUserIds)) {
            $type = 'multi-host';
        } else {
            $type = 'audience';
        }
        return $this->render('live', [
            'type' => $type,
//            'webinars' => $webinars,
            'webinarDetail' => $webinarDetail
        ]);
    }

    public function actionDetail($slug, $referral = null)
    {
        if (!empty($referral)) {
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'ref_csrf-webinar',
                'value' => $referral,
            ]));
        }
        $user_id = Yii::$app->user->identity->user_enc_id;
        $model = new webinarFunctions();
        $webinar = self::getWebianrDetail($slug, true);
        $is_expired = false;
        if (empty($webinar)) {
            $webinar = self::getWebianrDetail($slug, false);
            $is_expired = true;
            if (empty($webinar)) {
                throw new HttpException(404, Yii::t('frontend', 'Page not found'));
            }
        }
        $nextEvent = $webinar['webinarEvents'][0];
        if (empty($nextEvent)) {
//                webinar finished
            return $this->render('/mentors/non-authorized', [
                'type' => 1
            ]);
        }
        $speakers = $webinar['webinarEvents'][0]['webinarSpeakers'];
        $speakerUserIds = ArrayHelper::getColumn($speakers, 'user_enc_id');
        if (in_array($user_id, $speakerUserIds)) {
            $share_link = 'live';
        } else {
            $share_link = 'view';
        }

        $webinarEvents = self::getWebianrDetail($slug, false);
        $dateEvents = ArrayHelper::index($webinar['webinarEvents'], null, 'event_date');
        $event_ids = ArrayHelper::getColumn($webinar['webinarEvents'], 'event_enc_id');

        if ($webinar['session_for'] != 2) {
            $assignSpeaker = WebinarSpeakers::find()
                ->alias('z')
                ->distinct()
                ->select([
                    'z.webinar_event_enc_id',
                    'z.speaker_enc_id',
                    'a.unclaimed_org_id',
                    'a.designation_enc_id',
                    'b.designation',
                    'CONCAT(f.first_name, " ", f.last_name) fullname',
                    'f.image', 'f.image_location',
                    'f.description',
                    'f.facebook', 'f.twitter', 'f.instagram', 'f.linkedin',
                    'c.logo org_logo', 'c.logo_location org_logo_location',
                    'c.name org_name'
                ])
                ->joinWith(['speakerEnc a' => function ($a) {
                    $a->andWhere(['a.is_deleted' => 0]);
                    $a->joinWith(['designationEnc b'], false);
                    $a->joinWith(['unclaimedOrg c'], false);
                    $a->joinWith(['speakerExpertises d' => function ($d) {
                        $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'e.skill']);
                        $d->joinWith(['skillEnc e'], false);
                    }]);
                    $a->joinWith(['userEnc f'], false);
                }])
                ->andWhere(['in', 'z.webinar_event_enc_id', $event_ids])
                ->andWhere(['z.is_deleted' => 0])
                ->groupBy('d.speaker_enc_id')
                ->asArray()
                ->all();
            if ($assignSpeaker) {
                array_walk($assignSpeaker, function (&$item) {
                    if ($item['image']) {
                        $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                    }
                    $item['speaker_image'] = $image;
                    $item['speaker_image_fake'] = Url::to('@eyAssets/images/pages/webinar/default-user.png');
                    if ($item['org_logo']) {
                        $item['org_image'] = Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo . $item['org_logo_location'] . '/' . $item['org_logo']);
                    }
                    unset($item['image']);
                    unset($item['image_location']);
                    unset($item['org_logo']);
                    unset($item['org_logo_location']);
                });
            }
            $outComes = WebinarOutcomes::find()
                ->alias('z')
                ->select(['z.webinar_enc_id', 'z.outcome_pool_enc_id', 'oe.name', 'oe.icon_location', 'oe.icon', 'oe.bg_colour'])
                ->joinWith(['outcomePoolEnc oe'], false)
                ->where(['z.is_deleted' => 0, 'z.webinar_enc_id' => $webinar['webinar_enc_id']])
                ->asArray()
                ->all();
            $register = $model->getRegisteration($webinar['webinar_enc_id']);
            $webinarRegistrations = $model->getWebinarRegisteration($webinar['webinar_enc_id']);
            $webResig = WebinarRegistrations::find()
                ->where([
                    'is_deleted' => 0,
                    'webinar_enc_id' => $webinar['webinar_enc_id'],
                    'created_by' => Yii::$app->user->identity->user_enc_id,
                    'status' => 1,
                ])
                ->one();
            $interestCount = UserWebinarInterest::find()
                ->where(['webinar_enc_id' => $webinar['webinar_enc_id'], 'interest_status' => 1])
                ->count();

            $userInterest = UserWebinarInterest::findOne(['webinar_enc_id' => $webinar['webinar_enc_id'], 'created_by' => $user_id]);
            $webinar['start_datetime'] = "";

            $user_link = '';

            if ($webinar['webinar_conduct_on'] == 1) {
                $user_link = WebinarRegistrations::findOne(['webinar_enc_id' => $webinar['webinar_enc_id'], 'created_by' => $user_id])->unique_access_link;
            }

            $webinarRewards = WebinarRewards::find()
                ->alias('a')
                ->select(['a.webinar_reward_enc_id', 'a.webinar_enc_id', 'a.position_enc_id', 'b.name position_name', 'a.price', 'a.amount'])
                ->joinWith(['positionEnc b'], false)
                ->joinWith(['webinarRewardCertificates c' => function ($c) {
                    $c->select(['c.reward_certificate_enc_id', 'c.webinar_reward_enc_id', 'c.name']);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['a.is_deleted' => 0, 'a.webinar_enc_id' => $webinar['webinar_enc_id']])
                ->orderBy('a.sequence')
                ->groupBy(['a.webinar_reward_enc_id'])
                ->asArray()
                ->all();

            return $this->render('webinar-details', [
                'webinar' => $webinar,
                'interestCount' => $interestCount,
                'assignSpeaker' => $assignSpeaker,
                'is_expired' => $is_expired,
                'outComes' => $outComes,
                'register' => $register,
                'webinarRegistrations' => $webinarRegistrations,
                'webResig' => $webResig,
                'share_link' => $share_link,
                'user_id' => $user_id,
                'userInterest' => $userInterest,
                'dateEvents' => $dateEvents,
                'nextEvent' => $nextEvent,
                'webinar_link' => $user_link,
                'webinarRewards' => $webinarRewards,
                'upcoming' => self::showWebinar($status = 'upcoming', $webinar_id = $webinar['webinar_enc_id'])
            ]);
        } else {
            return $this->redirect('/');
        }
    }

    public function actionRecordInterest()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $uid = Yii::$app->user->identity->user_enc_id;
            $wid = Yii::$app->request->post('wid');
            $value = Yii::$app->request->post('value');
            $model = UserWebinarInterest::findOne(['webinar_enc_id' => $wid, 'created_by' => $uid]);
            if (!empty($model)) {
                $model->interest_status = $value;
                $model->is_deleted = 0;
                $model->last_updated_by = $uid;
                $model->last_updated_on = date('Y-m-d H:i:s');
            } else {
                $model = new UserWebinarInterest();
                $utilitiesModel = new  \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->webinar_interest_enc_id = $utilitiesModel->encrypt();
                $model->webinar_enc_id = $wid;
                $model->interest_status = $value;
                $model->created_by = $uid;
                $model->created_on = date('Y-m-d H:i:s');
            }
            if ($model->save()) {
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Updated Successfully',
                ];
            } else {
                return [
                    'status' => 201,
                    'title' => 'error',
                    'message' => 'something went wrong'
                ];
            }
        }
    }

    public function actionRegistration()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $uid = Yii::$app->user->identity->user_enc_id;
            $wid = Yii::$app->request->post('wid');
            $refcode = Yii::$app->request->post('refcode');
            $model = WebinarRegistrations::findOne(['webinar_enc_id' => $wid, 'created_by' => $uid]);
            if ($model->status == 1) {
                return [
                    'status' => 203,
                    'title' => 'Message',
                    'message' => 'You already registered..'
                ];
            } else {
                if (!empty($model)) {
                    $model->is_deleted = 0;
                    $model->last_updated_by = $uid;
                    $model->last_updated_on = date('Y-m-d H:i:s');
                } else {
                    $model = new WebinarRegistrations();
                    $utilitiesModel = new  \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $model->register_enc_id = $utilitiesModel->encrypt();
                    $model->webinar_enc_id = $wid;
                    $model->created_by = $uid;
                    $model->created_on = date('Y-m-d H:i:s');
                }
                if (!empty($refcode)) {
                    $refId = \common\models\Referral::findOne(['code' => $refcode])->referral_enc_id;
                    if ($refId) {
                        $model->referral_enc_id = $refId;
                    }
                }
                $model->status = 1;
                if ($model->save()) {
                    $get = Users::findOne(['user_enc_id' => $uid]);
                    $data = Webinar::findOne(['webinar_enc_id' => $wid]);
                    $params = [];
                    $params['email'] = $get->email;
                    $params['name'] = $get->first_name . ' ' . $get->last_name;
                    $params['webinar_id'] = $wid;
                    $params['from'] = Yii::$app->params->from_email;
                    $params['site_name'] = Yii::$app->params->site_name;
                    $params['first_name'] = $get->first_name;
                    $params['last_name'] = $get->last_name;
                    $params["user_id"] = $uid;
                    $interestedUser = UserWebinarInterest::findOne(['webinar_enc_id' => $wid, 'created_by' => $uid]);
                    if ($interestedUser) {
                        $interestedUser->interest_status = 1;
                        $interestedUser->is_deleted = 0;
                        $interestedUser->last_updated_on = date('Y-m-d H:i:s');
                    } else {
                        $interestedUser = new UserWebinarInterest();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $interestedUser->webinar_interest_enc_id = $utilitiesModel->encrypt();
                        $interestedUser->interest_status = 1;
                        $interestedUser->webinar_enc_id = $wid;
                        $interestedUser->created_by = $uid;
                        $interestedUser->created_on = date('Y-m-d H:i:s');
                    }
                    $interestedUser->save();
                    Yii::$app->notificationEmails->webinarRegistrationEmail($params);
                    if ($data->webinar_conduct_on == 1) {
                        $params["webinar_zoom_id"] = $data->platform_webinar_id;
                        Yii::$app->notificationEmails->zoomRegisterAccess($params);
                    }

                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Registered Successfully',
                    ];
                } else {
                    return [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'something went wrong, Please try after sometime..'
                    ];
                }
            }
        }
    }

    public function actionMultiHost($id)
    {
        $data = WebinarSessions::findOne(['session_enc_id' => $id]);
        if (!$data->session_id) {
            $data = $data->webinars;
            foreach ($data as $d) {
                foreach ($d->webinarSpeakers as $speaker) {
                    $user_id = $speaker->speakerEnc->userEnc->user_enc_id;
                    break;
                }
                break;
            }
            return $this->renderAjax('generate-session', ['user_id' => $user_id, 'id' => $id]);
        }
        $this->layout = 'blank-layout';
        $session = Yii::$app->session;
        if (empty($session->get('uid'))) {
            $session->set('uid', Yii::$app->user->identity->id);
        }
        if ($id) {
            return $this->render('multi-host', ['tokenId' => $id, 'uid' => $session->get('uid')]);
        }
    }

    public function actionAudience($id)
    {
        $user_id = Yii::$app->user->identity->user_enc_id;
        $webinar_id = Webinars::findOne(['session_enc_id' => $id])['webinar_enc_id'];
        $chkRegistration = WebinarRegistrations::findOne(['created_by' => $user_id]);
        if (empty($chkRegistration)) {
            self::webinarRegistration($user_id, $webinar_id);
        }
        $this->layout = 'blank-layout';
        if ($id) {
            return $this->render('multi-view', ['tokenId' => $id]);
        }
    }

    private function webinarRegistration($user_id, $webinar_id)
    {
        $model = new WebinarRegistrations();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->register_enc_id = $utilitiesModel->encrypt();
        $model->webinar_enc_id = $webinar_id;
        $model->status = 1;
        $model->created_by = $user_id;
        $model->created_on = date('Y-m-d h:i:s');
        if ($model->save()) {
            return true;
        }
    }

    private function getWebianrDetail($slug, $recent)
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $date_now = $dt->format('Y-m-d H:i:s');
        $webinar = Webinar::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.webinar_enc_id',
                'a.price',
                'a.session_for',
                'a.slug',
                'a.title',
                'a.description',
                'a.other_details',
                'a.seats',
                'a.webinar_conduct_on',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->webinars->banner->image, 'https') . '", a.image_location, "/", a.image) END image',
            ])
            ->joinWith(['webinarEvents a1' => function ($a1) use ($date_now, $recent, $status) {
                $a1->select([
                    'a1.event_enc_id',
                    'a1.webinar_enc_id',
                    'a1.session_enc_id',
                    'a1.title',
                    'a1.duration',
                    "DATE_FORMAT(a1.start_datetime, '%d-%m-%Y') event_date",
                    "DATE_FORMAT(a1.start_datetime, '%H:%i') event_time",
                    "ADDTIME(DATE_FORMAT(a1.start_datetime, '%H:%i'), SEC_TO_TIME(a1.duration*60)) endtime",
                    'a1.start_datetime',
                    'a1.description',
                    "ADDDATE(a1.start_datetime, INTERVAL a1.duration MINUTE) as end_datetime",
                    'a1.status',
                ]);
                $a1->joinWith(['sessionEnc e'], false);
                $a1->joinWith(['webinarSpeakers a2' => function ($d) {
                    $d->select([
                        'a2.webinar_event_enc_id',
                        'a2.speaker_enc_id',
                        'a3.user_enc_id',
                        'CONCAT(a4.first_name, " ", a4.last_name) as fullname',
                        'a4.image',
                        'a4.image_location',
                        'a5.designation',
                    ]);
                    $d->joinWith(['speakerEnc a3' => function ($d1) {
                        $d1->joinWith(['userEnc a4']);
                        $d1->joinWith(['designationEnc a5']);
                    }], false);
                    $d->andWhere(['a2.is_deleted' => 0]);
                }]);
                $a1->andWhere(['a1.is_deleted' => 0]);
                if ($recent) {
                    $a1->andWhere(['in', 'a1.status', [0, 1]]);
                    $a1->andWhere(['>', "ADDDATE(a1.start_datetime, INTERVAL a1.duration MINUTE)", $date_now]);
                }
                $a1->orderBy(['a1.start_datetime' => SORT_ASC]);
                $a1->groupBy('a1.event_enc_id');
            }])
            ->joinWith(['assignedWebinarTos b'], false)
            ->joinWith(['webinarRegistrations d' => function ($d) {
                $d->select([
                    'd.webinar_enc_id',
                    'd.register_enc_id',
                    'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
                ]);
                $d->joinWith(['createdBy d1'], false);
                $d->limit(6);
                $d->onCondition(['d.status' => 1, 'd.is_deleted' => 0]);
            }])
            ->where(['a.slug' => $slug, 'a.is_deleted' => 0])
            ->asArray()
            ->one();
        return $webinar;
    }

    public function actionAllWebinars()
    {
        $webinars = self::getWebinars();
        return $this->render('all-webinars', [
            'webinars' => $webinars,
        ]);
    }

    private function getWebinars()
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $date_now = $dt->format('Y-m-d H:i:s');

        $webinars = Webinar::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.webinar_enc_id',
                'a.slug',
                'a.title',
                'a.availability',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->webinars->banner->image, 'https') . '", a.image_location, "/", a.image) END image',
                'a.description',
                'a.price',
            ])
            ->joinWith(['webinarEvents a1' => function ($a1) use ($date_now) {
                $a1->select([
                    'a1.event_enc_id',
                    'a1.webinar_enc_id',
                    'a1.session_enc_id',
                    'a1.title',
                    'a1.start_datetime',
                    'a1.duration',
                    "ADDDATE(a1.start_datetime, INTERVAL a1.duration MINUTE) as end_datetime",
                    'a1.created_on',
                    'CONCAT(us.first_name, " ", us.last_name) speakers'
                ]);
                $a1->joinWith(['webinarSpeakers ws' => function ($ws) {
                    $ws->joinWith(['speakerEnc sp' => function ($sp) {
                        $sp->joinWith(['userEnc us'], false);
                    }], false);
                }], false);
                $a1->joinWith(['sessionEnc e'], false);
                $a1->andWhere(['a1.is_deleted' => 0]);
                $a1->andWhere(['in', 'a1.status', [0, 1]]);
                $a1->andWhere(['>', "ADDDATE(a1.start_datetime, INTERVAL a1.duration MINUTE)", $date_now]);
                $a1->orderBy(['a1.start_datetime' => SORT_ASC]);
            }])
            ->joinWith(['assignedWebinarTos b'], false)
            ->joinWith(['webinarRegistrations d' => function ($d) {
                $d->select([
                    'd.webinar_enc_id',
                    'd.register_enc_id',
                    'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
                ]);
                $d->joinWith(['createdBy d1'], false);
                $d->limit(3);
                $d->onCondition(['d.status' => 1, 'd.is_deleted' => 0]);
            }])
            ->andWhere(['a.is_deleted' => 0])
            ->andWhere(['not', ['a.session_for' => 2]])
//            ->orderBy(['a.created_on' => SORT_DESC])
            ->groupBy('a.webinar_enc_id')
            ->asArray()
            ->all();
        return $webinars;
    }

    public function actionIndex()
    {
        $upcomingWebinar = self::showWebinar($status = 'upcoming', '', true, '', $limit = 9);
        $pastWebinar = self::showWebinar($status = 'past', '', false);
        if (Yii::$app->user->identity->type->user_type == 'Individual') {
            $userIdd = Yii::$app->user->identity->user_enc_id;
            $optedWebinar = self::showWebinar($status = 'opted', $userIdd);
        }
        $model = new WebinarRequestForm();
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $speaker_id = Yii::$app->request->post('speaker_id');
            $model->load(Yii::$app->request->post());
            return $model->save($speaker_id);
        }

        return $this->render('webinars-landing', [
            'upcomingWebinar' => $upcomingWebinar,
            'pastWebinar' => $pastWebinar,
            'optedWebinar' => $optedWebinar,
            'model' => $model
        ]);
    }

    private function showWebinar($status, $userIdd = null, $sortAsc = true, $webinar_id = null, $limit = 6, $page = 1, $price = null)
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $currentTime = $dt->format('Y-m-d H:i:s');
        $webinars = Webinar::find()
            ->alias('a')
            ->select(['a.name', 'a.description', 'a.price', 'a.webinar_enc_id', 'a.gst', 'a.slug',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->webinars->banner->image, 'https') . '", a.image_location, "/", a.image) END image',
                'GROUP_CONCAT(DISTINCT(CONCAT(f.first_name, " " ,f.last_name)) SEPARATOR ",") speakers'])
            ->joinWith(['webinarEvents b' => function ($b) use ($status, $currentTime) {
                $b->distinct();
                $b->select(['b.start_datetime', 'b.webinar_enc_id', 'b.status', 'b.event_enc_id']);
                if ($status != 'all') {
                    if ($status == 'upcoming' || $status == 'opted') {
                        $b->andWhere(['>', 'ADDDATE(b.start_datetime, INTERVAL b.duration MINUTE)', $currentTime]);
                    } else {
                        $b->andWhere(['<', 'b.start_datetime', $currentTime]);
                    }
                }
                $b->groupBy(['b.webinar_enc_id']);
                $b->joinWith(['webinarSpeakers d' => function ($d) {
                    $d->select(['d.speaker_enc_id', 'd.webinar_event_enc_id']);
                    $d->joinWith(['speakerEnc e' => function ($e) {
                        $e->select(['e.speaker_enc_id', 'e.user_enc_id']);
                        $e->joinWith(['userEnc f' => function ($f) {
                            $f->select(['f.user_enc_id', 'f.first_name', 'f.last_name']);
                        }]);
                    }]);
                }], false);
            }])
            ->joinWith(['webinarRegistrations c' => function ($c) use ($status, $userIdd) {
                $c->select(['c.webinar_enc_id', 'c.register_enc_id', 'c.status', 'c.created_by', 'c.created_on']);
                $c->joinWith(['createdBy cc' => function ($cc) {
                    $cc->select(['cc.user_enc_id',
//                        'CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", cc.image_location, "/", image)',
                        'CASE WHEN cc.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", cc.image_location, "/", image)  ELSE NULL END image'
                    ]);
                }]);
                $c->onCondition(['c.status' => 1, 'c.is_deleted' => 0]);
                $c->orderBy(['c.created_on' => SORT_DESC]);
                if (!empty($userIdd)) {
                    $c->where(['c.created_by' => $userIdd]);
                }
            }])
            ->andWhere(['a.is_deleted' => 0]);

        // price filter
        if ($price != null) {
            if ($price == 'paid') {
                $webinars->andWhere(['!=', 'a.price', null]);
            } elseif ($price == 'free') {
                $webinars->andWhere(['a.price' => null]);
            }
        }

        if ($webinar_id != null) {
            $webinars->andWhere(['not', ['a.webinar_enc_id' => $webinar_id]]);
        }

        $webinars->groupBy(['a.webinar_enc_id'])
            ->orderBy(['b.start_datetime' => $sortAsc ? SORT_ASC : SORT_DESC])
            ->limit($limit)
            ->offset(($page - 1) * $limit);
        $webinars = $webinars->asArray()
            ->all();
        return $webinars;
    }

    public function actionSearchSpeakers($q = null)
    {
        if (!is_null($q)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Speakers::find()
                ->alias('z')
                ->select(['CONCAT(a.first_name, " " ,a.last_name) as value',
                    'z.speaker_enc_id id',
                    'z.user_enc_id',
                    'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) END image',])
                ->joinWith(['userEnc a'], false)
                ->andFilterWhere(['like', 'CONCAT(a.first_name, " " ,a.last_name)', $q])
                ->andWhere(['z.is_deleted' => 0])
                ->limit(20)
                ->asArray()
                ->all();
            return $data;
        }
    }

    public function actionWebinarExpired()
    {
        $webinars = self::getWebinars();
        return $this->render('webinar-expired', [
            'webinars' => $webinars,
        ]);
    }

    public function actionWebinarWidgetTemplate($id)
    {
        $template_name = $id;
        $this->layout = 'widget-layout';
        return $this->render('template-preview', [
            'template_name' => $template_name
        ]);

    }

    public function actionList()
    {
        return $this->render('list');
    }

    public function actionGetWebinars($status = 'upcoming', $price = null, $limit = 8, $page = 1)
    {
        $webinars = self::showWebinar($status, '', false, '', $limit, $page, $price);
        if ($webinars) {

            foreach ($webinars as $key => $val) {
                $webinars[$key]['isRegistered'] = $this->isRegistered($val['webinar_enc_id']);
                $webinars[$key]['webinarEvents'][0]['start_datetime'] = date('d-M', strtotime($val['webinarEvents'][0]['start_datetime']));
                $webinars[$key]['price'] = $this->getWebinarPrice($val['price'], $val['gst']);
                $webinars[$key]['registeredImages'] = $this->getRegisteredUserImages($val['webinarRegistrations']);
            }

            return json_encode(['status' => 200, 'data' => $webinars]);
        } else {
            return json_encode(['status' => 404, 'message' => 'No Data Found']);
        }
    }

    private function isRegistered($webinar_id)
    {
        return WebinarRegistrations::find()
            ->where(['webinar_enc_id' => $webinar_id, 'status' => 1, 'created_by' => Yii::$app->user->identity->user_enc_id])
            ->exists();
    }

    private function getWebinarPrice($price, $gstAmount)
    {
        if ($price) {
            $gstPercent = $gstAmount;
            if ($price > 0) {
                $gstAmount = round($gstPercent * ($price / 100), 2);
            }
        }
        $finalPrice = $price + $gstAmount;
        return ($finalPrice == 0 ? 'Free' : '₹' . $finalPrice);
    }

    private function getRegisteredUserImages($webinarRegistrations)
    {
        $i = 1;
        $images = [];
        foreach ($webinarRegistrations as $val) {
            if ($i == 4) {
                break;
            }
            if ($val['createdBy']['image']) {
                array_push($images, $val['createdBy']['image']);
                $i++;
            }
        }
        return $images;
    }

    public function actionTemplateView($id)
    {
        $this->layout = 'widget-layout';
        $webinarWidget = WebinarWidgetTemplates::find()
            ->select(['widget_enc_id', 'template_name', 'template_path'])
            ->where(['webinar_enc_id' => $id, 'is_deleted' => 0])
            ->asArray()
            ->one();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = Webinar::find()
                ->alias('z')->distinct()
                ->select(['z.webinar_enc_id', 'z.name', 'z.description', 'z.slug',
                    'CASE WHEN z.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->webinars->banner->image, 'https') . '", z.image_location, "/", z.image) END image',
                    'GROUP_CONCAT(DISTINCT DATE_FORMAT(a.start_datetime, "%d-%M-%y")) date', 'GROUP_CONCAT(DISTINCT DATE_FORMAT(a.start_datetime, "%H:%i %p")) time'
                ])
                ->joinWith(['webinarEvents a' => function ($a) {
                    $a->addSelect(['a.webinar_enc_id', 'a.event_enc_id']);
                    $a->joinWith(['webinarSpeakers c' => function ($b) {
                        $b->addSelect(['c.webinar_event_enc_id', 'c.speaker_enc_id', 'CONCAT(e.first_name, " ",e.last_name) speaker_name',
                            'CASE WHEN e.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", e.image_location, "/", e.image) END speaker_image',
                            'd1.designation'
                        ]);
                        $b->joinWith(['speakerEnc d' => function ($b) {
                            $b->joinWith(['designationEnc d1' => function ($d1) {
                                $d1->onCondition(['d1.is_deleted' => 0]);
                            }]);
                            $b->joinWith(['userEnc e' => function ($e) {
                            }], false);
                        }], false);
                        $b->onCondition(['c.is_deleted' => 0]);
                    }]);
                    $a->onCondition(['a.is_deleted' => 0]);
                    $a->groupBy(['a.webinar_enc_id']);
                }])
                ->andWhere(['z.webinar_enc_id' => $id, 'z.is_deleted' => 0])
                ->asArray()
                ->one();
            return [
                'status' => 200,
                'cards' => $model
            ];
        }
        return $this->render('template-view', [
            'id' => $id,
            'webinarWidget' => $webinarWidget,
            'tempName' => $webinarWidget['template_name']
        ]);
    }

    public function actionUpcomingWebinarBox(){
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $currentTime = $dt->format('Y-m-d H:i:s');
        $upcomingWebinar = Webinar::find()
            ->alias('a')
            ->select(['a.title', 'a.slug', 'a.webinar_enc_id'])
            ->joinWith(['webinarEvents b' => function($b) use($currentTime){
                $b->andWhere(['>', 'b.start_datetime', $currentTime]);
            }])
            ->where(['a.is_deleted' => 0])
            ->orderBy(['b.start_datetime' => SORT_ASC])
            ->asArray()
            ->one();

        return $this->renderAjax('/widgets/webinar-detail-popup', [
            'upcomingWebinar' => $upcomingWebinar
        ]);
    }
}