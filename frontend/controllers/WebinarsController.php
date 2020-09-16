<?php

namespace frontend\controllers;

use common\models\UserWebinarInterest;
use common\models\Webinar;
use common\models\WebinarEvents;
use common\models\WebinarOutcomes;
use common\models\WebinarPayments;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\WebinarSessions;
use common\models\WebinarSpeakers;
use frontend\models\webinars\webinarFunctions;
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
        $webinarDetail = self::getWebianrDetail($slug);
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

    public function actionWebinarDetails($slug)
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $date_now = $dt->format('Y-m-d H:i:s');
        $user_id = Yii::$app->user->identity->user_enc_id;
        $model = new webinarFunctions();
        $webinar = self::getWebianrDetail($slug);
        $speakers = $webinar['webinarEvents'][0]['webinarSpeakers'];
        $speakerUserIds = ArrayHelper::getColumn($speakers, 'user_enc_id');
        if (in_array($user_id, $speakerUserIds)) {
            $share_link = 'live';
        } else {
            $share_link = 'view';
        }

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
                        $image_path = Yii::$app->params->upload_directories->users->image_path . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                        if (file_exists($image_path)) {
                            $image = Yii::$app->params->upload_directories->users->image . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                        }
                    }
                    $item['speaker_image'] = $image;
                    $item['speaker_image_fake'] = Url::to('@eyAssets/images/pages/webinar/default-user.png');
                    if ($item['org_logo']) {
                        $item['org_image'] = Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo . $item['org_logo_location'] . '/' . $item['org_logo']);
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
            $userInterest = UserWebinarInterest::findOne(['webinar_enc_id' => $webinar['webinar_enc_id'], 'created_by' => $user_id]);
            $webinar['start_datetime'] = "";

            return $this->render('webinar-details', [
                'webinar' => $webinar,
                'assignSpeaker' => $assignSpeaker,
                'outComes' => $outComes,
                'register' => $register,
                'webinarRegistrations' => $webinarRegistrations,
                'webResig' => $webResig,
                'share_link' => $share_link,
                'user_id' => $user_id,
                'userInterest' => $userInterest,
                'dateEvents' => $dateEvents,
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
                $model->status = 1;
                if ($model->save()) {
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

    private function getWebianrDetail($slug)
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
                'a.seats',
            ])
            ->joinWith(['webinarEvents a1' => function ($a1) use ($date_now) {
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
                $a1->andWhere(['in', 'a1.status', [0, 1]]);
                $a1->andWhere(['>', "ADDDATE(a1.start_datetime, INTERVAL a1.duration MINUTE)", $date_now]);
                $a1->orderBy(['a1.start_datetime' => SORT_ASC]);
                $a1->groupBy('a1.event_enc_id');
            }])
            ->joinWith(['assignedWebinarTos b'], false)
            ->joinWith(['webinarRegistrations d' => function ($d) {
                $d->select([
                    'd.webinar_enc_id',
                    'd.register_enc_id',
                    'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
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

    public function actionIndex()
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
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) END image',
                'a.description',
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
                ]);
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
                    'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
                ]);
                $d->joinWith(['createdBy d1'], false);
                $d->limit(6);
                $d->onCondition(['d.status' => 1, 'd.is_deleted' => 0]);
            }])
            ->andWhere(['a.is_deleted' => 0])
            ->andWhere(['not', ['a.session_for' => 2]])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->groupBy('a.webinar_enc_id')
            ->asArray()
            ->all();
        return $webinars;
    }
}