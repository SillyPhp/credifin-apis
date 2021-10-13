<?php

namespace frontend\controllers;

use common\models\Speakers;
use common\models\Webinar;
use common\models\WebinarConversationMessages;
use common\models\WebinarConversations;
use common\models\WebinarEvents;
use common\models\WebinarOutcomes;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\WebinarSessions;
use common\models\WebinarSpeakers;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class MentorsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['webinar-live', 'webinar-view'],
                'rules' => [
                    [
                        'actions' => ['webinar-live', 'webinar-view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $route = ltrim(Yii::$app->request->url, '/');
        if ($route === "") {
            $route = "/";
        }
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute($route, $this);
        return parent::beforeAction($action);
    }

    public function actionMentorshipIndex()
    {
        $model = new \frontend\models\mentorship\MentorshipEnquiryForm();

        return $this->render('mentorship-index', [
            'model' => $model,
        ]);
    }

    public function actionMentorProfile()
    {
        return $this->render('mentor-profile');
    }

    public function actionAllMentors()
    {
        $webinars = self::getWebianrs($id);
        return $this->render('all-mentors', [
            'webinars' => $webinars,
        ]);
    }

    public function actionScoolMentorship()
    {
        return $this->render('scool-mentorship');
    }

    private function timeDifference($start_time, $date)
    {
        $datetime = new \DateTime();
        $timezone = new \DateTimeZone('Asia/Kolkata');
        $datetime->setTimezone($timezone);
        $time1 = $datetime->format('y-m-d H:i:s');
        $seconds = strtotime($date . $start_time) - strtotime($time1);
        return $seconds;
    }

    public function actionWebinarDetails($id)
    {
        if (!Yii::$app->user->isGuest) {
            $webinar = Webinars::find()
                ->select(['webinar_enc_id', 'session_enc_id', 'status', 'title', 'start_datetime', 'description', 'seats'])
                ->where(['webinar_enc_id' => $id])
                ->asArray()
                ->one();
            $assignSpeaker = WebinarSpeakers::find()
                ->alias('z')
                ->distinct()
                ->select([
                    'z.webinar_enc_id',
                    'z.speaker_enc_id',
                    'a.unclaimed_org_id',
                    'a.designation_enc_id',
                    'b.designation',
                    'CONCAT(f.first_name, " ", f.last_name) fullname',
                    'f.email', 'f.phone',
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
                ->andWhere(['z.is_deleted' => 0, 'z.webinar_enc_id' => $id])
                ->asArray()
                ->all();
            if ($assignSpeaker) {
                array_walk($assignSpeaker, function (&$item) {
                    if ($item['image']) {
//                        $image_path = Yii::$app->params->upload_directories->users->image_path . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
//                        if (file_exists($image_path)) {
//                            $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
//                        }
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
                ->where(['z.is_deleted' => 0, 'z.webinar_enc_id' => $id])
                ->asArray()
                ->all();
            $register = WebinarRegistrations::find()
                ->alias('z')
                ->select(['z.webinar_enc_id', 'z.register_enc_id', 'z.interest_status', 'z.created_by', 'c.image', 'c.image_location'])
                ->joinWith(['createdBy c'], false)
                ->where(['z.webinar_enc_id' => $id, 'z.is_deleted' => 0, 'c.is_deleted' => 0])
                ->andWhere(['not', ['c.image' => null]])
                ->andWhere(['not', ['c.image' => '']])
                ->limit(6)
                ->asArray()
                ->all();
            $webinarRegistrations = WebinarRegistrations::find()
                ->alias('z')
                ->select(['z.webinar_enc_id', 'z.register_enc_id', 'z.interest_status', 'z.created_by', 'c.image', 'c.image_location'])
                ->joinWith(['createdBy c'], false)
                ->where(['z.webinar_enc_id' => $id, 'z.is_deleted' => 0, 'c.is_deleted' => 0])
                ->asArray()
                ->all();
            $webResig = WebinarRegistrations::find()
                ->where(['is_deleted' => 0, 'webinar_enc_id' => $id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->one();
        } else {
            return $this->redirect('/login');
        }
        return $this->render('webinar-details', [
            'webinar' => $webinar,
            'assignSpeaker' => $assignSpeaker,
            'outComes' => $outComes,
            'register' => $register,
            'webinarRegistrations' => $webinarRegistrations,
            'webResig' => $webResig,
        ]);
    }

    public function actionWebinarRegistation()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $uid = Yii::$app->user->identity->user_enc_id;
            $wid = Yii::$app->request->post('wid');
            $value = Yii::$app->request->post('value');
            $model = WebinarRegistrations::findOne(['webinar_enc_id' => $wid, 'created_by' => $uid]);
            if (!empty($model)) {
                switch ($value) {
                    case 'interested':
                        $model->interest_status = 1;
                        break;
                    case 'not interested':
                        $model->interest_status = 2;
                        break;
                    case 'attending':
                        $model->interest_status = 3;
                }
                $model->is_deleted = 0;
                $model->last_updated_by = $uid;
                $model->last_updated_on = date('Y-m-d H:i:s');
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
            } else {
                $register = new WebinarRegistrations();
                $utilitiesModel = new  \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $register->register_enc_id = $utilitiesModel->encrypt();
                $register->webinar_enc_id = $wid;
                switch ($value) {
                    case 'interested':
                        $register->interest_status = 1;
                        break;
                    case 'not interested':
                        $register->interest_status = 2;
                        break;
                    case 'attending':
                        $register->interest_status = 3;
                }
                $register->status = 0;
                $register->created_by = $uid;
                $register->created_on = date('Y-m-d H:i:s');
                if ($register->save()) {
                    return [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'Status added successfully'
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
    }

    public function actionWebinarSpeakers()
    {
        return $this->render('speakers');
    }

    public function actionWebinarView($id)
    {
        $type = 'audience';
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $user_id = Yii::$app->user->identity->user_enc_id;
        $webinarDetail = self::getWebianrDetails($id, true);
        $nextEvent = $webinarDetail['webinarEvents'][0];
        $upcomingEvent = $webinarDetail['webinarEvents'][1];
        $upcomingEventTime = date('Y-m-d', strtotime($upcomingEvent['start_datetime']));
        $currentDate = $dt->format('Y-m-d');
        $speakers = $webinarDetail['webinarEvents'][0]['webinarSpeakers'];
        $speakerUserIds = ArrayHelper::getColumn($speakers, 'user_enc_id');
        $upcomingDateTime = "";
        if (!in_array($user_id, $speakerUserIds) && $upcomingEventTime == $currentDate) {
            $upcomingDateTime = $upcomingEvent['start_datetime'];
        }
        $dateEvents = ArrayHelper::index($webinarDetail['webinarEvents'], null, 'event_date');
        if (empty($nextEvent)) {
//            webinar finished
            return $this->render('/mentors/non-authorized', [
                'type' => 1
            ]);
        }
        if ($nextEvent['session_enc_id'] != $id) {
            throw new HttpException(404, Yii::t('frontend', 'Page not found'));
        }
        $statustype = "";
        switch ($nextEvent['status']) {
            case 0:
//                yet to start
                $statustype = 2;
                break;
            case 2:
//                ended
                $statustype = 3;
                break;
            case 3:
//                technical issues
                $statustype = 4;
                break;
            case 4:
//                cancelled
                $statustype = 5;
                break;
        }
        if ($statustype) {
            return $this->render('/mentors/non-authorized', [
                'type' => $statustype,
                'nextEvent' => $nextEvent,
            ]);
        }
        $webinars = self::getWebianrs($id);
        return $this->render('webinar-view', [
            'type' => $type,
            'webinars' => $webinars,
            'webinarDetail' => $webinarDetail,
            'dateEvents' => $dateEvents,
            'upcomingEvent' => $upcomingEvent,
            'upcomingDateTime' => $upcomingDateTime,
        ]);
    }

    public function actionWebinarLive($id)
    {
        $type = 'multi-stream';
        $user_id = Yii::$app->user->identity->user_enc_id;
        $webinarDetail = self::getWebianrDetails($id, true);
        $webinars = self::getWebianrs($id);
        $speakers = $webinarDetail['webinarEvents'][0]['webinarSpeakers'];
        $speakerUserIds = ArrayHelper::getColumn($speakers, 'user_enc_id');
        $nextEvent = $webinarDetail['webinarEvents'][0];
        if (!in_array($user_id, $speakerUserIds) && $nextEvent['session_enc_id'] != $id) {
            throw new HttpException(404, Yii::t('frontend', 'Page not found'));
        }
        if (in_array(Yii::$app->user->identity->user_enc_id, $speakerUserIds)) {
            return $this->render('webinar-view', [
                'type' => $type,
                'webinars' => $webinars,
                'webinarDetail' => $webinarDetail
            ]);
        } else {
            return $this->render('non-authorized');
        }
    }

    public function actionRegisterWebinar()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $key = Yii::$app->request->post('key');
            $chk = WebinarRegistrations::findOne(['webinar_enc_id' => $key, 'created_by' => Yii::$app->user->identity->user_enc_id]);
            if (!$chk) {
                $model = new WebinarRegistrations();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->register_enc_id = $utilitiesModel->encrypt();
                $model->webinar_enc_id = $key;
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                $model->status = 1;
                $model->interest_status = 1;
                if ($model->save()) {
                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Registered Successfully...',
                    ];
                } else {
                    return [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'Something went wrong...',
                    ];
                }
            }
        }
    }

    private function getWebianrDetails($id, $recent)
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $date_now = $dt->format('Y-m-d H:i:s');
        $event = WebinarEvents::findOne(['session_enc_id' => $id]);
        $webinar_id = $event->webinarEnc->webinar_enc_id;

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
            ->joinWith(['webinarEvents a1' => function ($a1) use ($date_now, $recent) {
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
            ->where(['a.is_deleted' => 0, 'a.webinar_enc_id' => $webinar_id])
            ->asArray()
            ->one();
        return $webinar;
    }

    private function getWebianrs($id = null)
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $date_now = $dt->format('Y-m-d H:i:s');
        $webinar_id = WebinarEvents::findOne(['session_enc_id' => $id])['webinar_enc_id'];
        $webinars = Webinar::find()
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
                'a.availability',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) END image',
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
                    'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
                ]);
                $d->joinWith(['createdBy d1'], false);
                $d->limit(6);
                $d->onCondition(['d.status' => 1, 'd.is_deleted' => 0]);
            }])
            ->andWhere(['not', ['a.webinar_enc_id' => $webinar_id]])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->limit(3)
            ->all();
        return $webinars;
    }

    public function actionGetWebinarSpeakers()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $limit = Yii::$app->request->post('limit');
            $offset = Yii::$app->request->post('offset');
            $webSpeaker = Speakers::find()
                ->alias('a')
                ->select(['a.speaker_enc_id',
                    'a.unclaimed_org_id',
                    'a.designation_enc_id',
                    'b.designation',
                    'CONCAT(f.first_name, " ", f.last_name) fullname',
                    'f.email', 'f.phone',
                    'f.image', 'f.image_location',
                    'f.description',
                    'f.facebook', 'f.twitter', 'f.instagram', 'f.linkedin',
                    'c.logo org_logo', 'c.logo_location org_logo_location',
                    'c.name org_name'
                ])
                ->where(['a.is_deleted' => 0, 'is_star' =>1])
                ->joinWith(['designationEnc b'], false)
                ->joinWith(['unclaimedOrg c'], false)
                ->joinWith(['speakerExpertises d' => function ($d) {
                    $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'e.skill']);
                    $d->joinWith(['skillEnc e'], false);
                }])
                ->joinWith(['userEnc f'], false)
                ->asArray()
                ->distinct()
                ->orderBy(['a.created_on' => SORT_DESC]);
            $totalSpeakerCount = $webSpeaker->count();
            $dataDetail = $webSpeaker->limit($limit)
                ->offset($offset)
                ->all();
            if ($dataDetail) {
                array_walk($dataDetail, function (&$item) {
                    if ($item['image']) {
//                        $image_path = Yii::$app->params->upload_directories->users->image_path . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
//                        if (file_exists($image_path)) {
//                            $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
//                        }
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
            return [
                'status' => 200,
                'cards' => $dataDetail,
                'total' => $totalSpeakerCount,
                'count' => sizeof($dataDetail)
            ];
        }
    }

    public function actionSaveConversation()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $webinar = WebinarEvents::findOne(['session_enc_id' => $data['webinar_enc_id']]);
            $conversation_id = WebinarConversations::find()
                ->where(['webinar_event_enc_id' => $webinar->event_enc_id])
                ->one();

            if ($conversation_id) {
                $comment = new WebinarConversationMessages();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $comment->message_enc_id = $utilitiesModel->encrypt();
                $comment->conversation_enc_id = $conversation_id->conversation_enc_id;
                $comment->message = $data['message'];
                if (isset($data['reply_to']) && !empty($data['reply_to'])) {
                    $comment->parent_enc_id = $data['reply_to'];
                }
                $comment->created_on = date('Y-m-d H:i:s');
                $comment->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$comment->save()) {
                    return $response = [
                        'status' => 500,
                        'title' => 'Error',
                        'message' => 'an error occurred',
                    ];
                } else {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Successfully Added',
                    ];
                }
            } else {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $conversation = new WebinarConversations();
                    $conversation->conversation_enc_id = $utilitiesModel->encrypt();
                    $conversation->conversation_type = 2;
                    $conversation->webinar_event_enc_id = $webinar->event_enc_id;
                    $conversation->created_by = Yii::$app->user->identity->user_enc_id;
                    $conversation->created_on = date('Y-m-d H:i:s');
                    if (!$conversation->save()) {
                        $transaction->rollBack();
                        return $response = [
                            'status' => 500,
                            'title' => 'Error',
                            'message' => 'an error occurred',
                        ];
                    }

                    $comment = new WebinarConversationMessages();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $comment->message_enc_id = $utilitiesModel->encrypt();
                    $comment->conversation_enc_id = $conversation->conversation_enc_id;
                    $comment->message = $data['message'];
                    if (isset($data['reply_to']) && !empty($data['reply_to'])) {
                        $comment->parent_enc_id = $data['reply_to'];
                    }
                    $comment->created_on = date('Y-m-d H:i:s');
                    $comment->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$comment->save()) {
                        $transaction->rollBack();
                        return $response = [
                            'status' => 500,
                            'title' => 'Error',
                            'message' => 'an error occurred',
                        ];
                    }

                    $transaction->commit();
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Successfully Added',
                    ];

                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    return false;
                }
            }

        }
    }
}