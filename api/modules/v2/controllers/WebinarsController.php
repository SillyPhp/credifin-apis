<?php

namespace api\modules\v2\controllers;

use common\models\Speakers;
use common\models\UserOtherDetails;
use common\models\Users;
use common\models\UserWebinarInterest;
use common\models\Webinar;
use common\models\WebinarConversationMessages;
use common\models\WebinarConversations;
use common\models\WebinarEvents;
use common\models\WebinarPayments;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\WebinarSessions;
use common\models\Utilities;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class WebinarsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'speakers' => ['POST', 'OPTIONS'],
                'speaker-detail' => ['POST', 'OPTIONS'],
                'validate-session' => ['POST', 'OPTIONS'],
                'save-conversation' => ['POST', 'OPTIONS'],
                'join-webinar' => ['POST', 'OPTIONS'],
                'update-status' => ['POST', 'OPTIONS']
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionSpeakers()
    {
        $params = Yii::$app->request->post();

        $webSpeaker = Speakers::find()
            ->distinct()
            ->alias('a')
            ->select(['a.speaker_enc_id',
                'a.unclaimed_org_id',
                'a.designation_enc_id',
                'b.designation',
                'CONCAT(f.first_name, " ", f.last_name) fullname',
                'f.email', 'f.phone',
                'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) END image',
                'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", c.logo_location, "/", c.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", c.name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END logo',
                'f.description',
                'f.facebook', 'f.twitter', 'f.instagram', 'f.linkedin',
                'REPLACE(c.name, "&amp;", "&") as org_name',
            ])
            ->where(['a.is_deleted' => 0])
            ->joinWith(['designationEnc b'], false)
            ->joinWith(['unclaimedOrg c'], false)
            ->joinWith(['speakerExpertises d' => function ($d) {
                $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'e.skill']);
                $d->joinWith(['skillEnc e'], false);
            }])
            ->joinWith(['userEnc f'], false);
        if (isset($params['limit']) && !empty($params['limit'])) {
            $webSpeaker->limit($params['limit']);
        }
        $webSpeaker = $webSpeaker->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($webSpeaker) {
            return $this->response(200, ['status' => 200, 'data' => $webSpeaker]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'No detail found']);
    }

    public function actionList()
    {
        if ($user = $this->isAuthorized()) {

            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $date_now = $dt->format('Y-m-d H:i:s');

            $user_id = $user->user_enc_id;

            $college_id = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $webinar = new \common\models\extended\Webinar();
            $webinar = $webinar->webinarsList($college_id['organization_enc_id']);

            $webinars = [];
            if (!empty($webinar)) {
                $i = 0;
                foreach ($webinar as $w) {
                    $registered_count = WebinarRegistrations::find()
                        ->where(['is_deleted' => 0, 'status' => 1, 'webinar_enc_id' => $w['webinar_enc_id']])
                        ->count();
                    $webinar[$i]['count'] = $registered_count;
                    $user_registered = $this->userRegistered($w['webinar_enc_id'], $user_id);
                    $webinar[$i]['is_registered'] = $user_registered;
                    $webinar[$i]['is_paid'] = $w['price'] ? true : false;
                    if ($w['webinarEvents']) {
                        array_push($webinars, $webinar[$i]);
                    }
                    $i++;
                }
            }

            if ($webinars) {
                return $this->response(200, ['status' => 200, 'data' => $webinars]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSpeakerDetail()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['speaker_enc_id']) && empty($params['speaker_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $speaker = Speakers::find()
            ->alias('a')
            ->select(['a.speaker_enc_id',
                'a.unclaimed_org_id',
                'a.designation_enc_id',
                'b.designation',
                'CONCAT(f.first_name, " ", f.last_name) fullname',
                'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) END image',
                'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo, 'https') . '", c.logo_location, "/", c.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", c.name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END logo',
                'f.description',
                'f.facebook', 'f.twitter', 'f.instagram', 'f.linkedin',
                'REPLACE(c.name, "&amp;", "&") as org_name',
            ])
            ->where(['a.is_deleted' => 0, 'a.speaker_enc_id' => $params['speaker_enc_id']])
            ->joinWith(['designationEnc b'], false)
            ->joinWith(['unclaimedOrg c'], false)
            ->joinWith(['speakerExpertises d' => function ($d) {
                $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'e.skill']);
                $d->joinWith(['skillEnc e'], false);
            }])
            ->joinWith(['userEnc f'], false)
            ->asArray()
            ->one();

        if ($speaker) {
            return $this->response(200, ['status' => 200, 'data' => $speaker]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionSaveConversation()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post();
            $webinar = WebinarEvents::findOne(['session_enc_id' => $data['session_enc_id']]);
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
                $comment->created_by = $user->user_enc_id;
                if (!$comment->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                } else {
                    return $this->response(200, ['status' => 200, 'message' => 'Successfully Added']);
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
                    $conversation->created_by = $user->user_enc_id;
                    $conversation->created_on = date('Y-m-d H:i:s');
                    if (!$conversation->save()) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
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
                    $comment->created_by = $user->user_enc_id;
                    if (!$comment->save()) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }

                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'Successfully Added']);

                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    return false;
                }
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionValidateSession()
    {
        if ($user = $this->isAuthorized()) {
            $session_enc_id = Yii::$app->request->post('session_enc_id');
            $validate_s_id = WebinarSessions::find()
                ->where(['session_enc_id' => $session_enc_id])
                ->one();

            $webinar = WebinarEvents::find()
                ->alias('a')
                ->select(['a.event_enc_id', 'a.webinar_enc_id', 'a.start_datetime', 'a.title', 'a.description'])
                ->joinWith(['webinarSpeakers b' => function ($b) {
                    $b->select(['b.webinar_event_enc_id',
                        'b.speaker_enc_id',
                        'CONCAT(d.first_name," ",d.last_name) full_name',
                        'e.designation',
                        'CASE WHEN d.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", d.image_location, "/", d.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(d.first_name, " ", d.last_name), "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END image',
                        'e.designation',
                        'd.facebook',
                        'd.twitter',
                        'd.linkedin',
                        'd.instagram',
                        'REPLACE(f.name, "&amp;", "&") as org_name',
                        'd.description',
                        'CASE WHEN f.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo, 'https') . '", f.logo_location, "/", f.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", f.name, "&size=200&rounded=false&background=", REPLACE(f.initials_color, "#", ""), "&color=ffffff") END logo',
                    ]);
                    $b->joinWith(['speakerEnc c' => function ($c) {
                        $c->joinWith(['userEnc d']);
                        $c->joinWith(['designationEnc e']);
                        $c->joinWith(['unclaimedOrg f']);
                    }], false);
                }])
                ->where(['a.is_deleted' => 0, 'a.session_enc_id' => $session_enc_id])
                ->asArray()
                ->one();

            if ($webinar) {
                $next_event = new \common\models\extended\Webinar();
                $date = date('Y-m-d', strtotime($webinar['start_datetime']));
                $webinar['next_event'] = $next_event->nextEvent($webinar['webinar_enc_id'], $date);
                $register_user = WebinarRegistrations::find()
                    ->where(['webinar_enc_id' => $webinar['webinar_enc_id'],
                        'created_by' => $user->user_enc_id,
                        'status' => 1,
                        'is_deleted' => 0])
                    ->one();

                $price = Webinar::find()
                    ->select(['price'])
                    ->where(['webinar_enc_id' => $webinar['webinar_enc_id']])
                    ->asArray()
                    ->one();

                if ($register_user) {
                    if ($validate_s_id->session_id) {
                        return $this->response(200, ['status' => 200, 'data' => $webinar]);
                    } else {
                        return $this->response(404, ['status' => 404, 'data' => $webinar]);
                    }
                } else {
                    if ($price['price']) {
                        return $this->response(409, ['status' => 409, 'data' => $webinar]);
                    } else {
                        $model = new WebinarRegistrations();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $model->register_enc_id = $utilitiesModel->encrypt();
                        $model->webinar_enc_id = $webinar['webinar_enc_id'];
                        $model->status = 1;
                        $model->created_by = $user->user_enc_id;
                        $model->created_on = date('Y-m-d h:i:s');
                        $model->save();
                        if ($validate_s_id->session_id) {
                            return $this->response(200, ['status' => 200, 'data' => $webinar]);
                        } else {
                            return $this->response(404, ['status' => 404, 'data' => $webinar]);
                        }
                    }
                }

            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionDetail()
    {
        $param = Yii::$app->request->post();

        if (isset($param['webinar_id']) && !empty($param['webinar_id'])) {
            $webinar_id = $param['webinar_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if ($user = $this->isAuthorized()) {

            $user_id = $user->user_enc_id;

            $college_id = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $webinar = new \common\models\extended\Webinar();
            $webinar = $webinar->webinarDetail($college_id['organization_enc_id'], $webinar_id);
        } else {
            $webinar = new \common\models\extended\Webinar();
            $webinar = $webinar->webinarDetail(null, $webinar_id);
        }


        if (!empty($webinar)) {
            if ($user = $this->isAuthorized()) {

                $user_id = $user->user_enc_id;
                $user_registered = $this->userRegistered($webinar['webinar_enc_id'], $user_id);
                $webinar['interest_status'] = $this->interested($webinar['webinar_enc_id'], $user_id);
            } else {
                $user_registered = 0;
                $webinar['interest_status'] = null;
            }
            $registered_count = WebinarRegistrations::find()
                ->where(['is_deleted' => 0, 'status' => 1, 'webinar_enc_id' => $webinar['webinar_enc_id']])
                ->count();
            $webinar['registered_count'] = $registered_count;

            $webinar['is_registered'] = $user_registered;

            $date = new \DateTime($webinar['event']['start_datetime']);
            $seconds = $this->timeDifference($date->format('H:i:s'), $date->format('Y-m-d'));
            $webinar['seconds'] = $seconds;
            $webinar['is_started'] = ($seconds < 0 ? true : false);
            foreach ($webinar['events'] as $k => $a) {
                $j = 0;
                foreach ($a as $t) {
                    $date = new \DateTime($t['start_datetime']);
                    $seconds = $this->timeDifference($date->format('H:i:s'), $date->format('Y-m-d'));
                    $is_started = ($seconds < 0 ? true : false);
                    $webinar['events'][$k][$j]['seconds'] = $seconds;
                    $webinar['events'][$k][$j]['is_started'] = $is_started;
                    $j++;
                }
            }
        }

        if ($webinar) {
            return $this->response(200, ['status' => 200, 'data' => $webinar]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    private function interested($webinar_id, $user_id)
    {
        $interest = UserWebinarInterest::find()
            ->select(['interest_status'])
            ->where(['created_by' => $user_id, 'webinar_enc_id' => $webinar_id])
            ->asArray()
            ->one();

        return $interest['interest_status'];
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

    private function userRegistered($webinar_id, $user_id)
    {
        return WebinarRegistrations::find()
            ->where(['created_by' => $user_id, 'webinar_enc_id' => $webinar_id, 'status' => 1, 'is_deleted' => 0])
            ->exists();
    }

    public function actionJoinWebinar()
    {
        if ($user = $this->isAuthorized()) {
            $param = Yii::$app->request->post();
            if (isset($param['webinar_id']) && !empty($param['webinar_id'])) {
                $webinar_id = $param['webinar_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $webinar = Webinar::find()->where(['webinar_enc_id' => $webinar_id])->one();

            if ($webinar) {
                if ($webinar['price']) {
                    $webinar_payments = WebinarPayments::find()
                        ->where(['webinar_enc_id' => $webinar_id, 'created_by' => $user->user_enc_id])->andWhere(['payment_status' => 'captured'])
                        ->one();
                    if (!empty($webinar_payments)) {
                        return $this->response(422, ['status' => 422, 'message' => 'User Already Paid The Amount']);
                    } else {
                        $payment = new \common\models\extended\WebinarPayments();
                        $args = ['created_by' => $user->user_enc_id, 'webinar_enc_id' => $webinar_id];
                        if ($payment->load($args, '')) {
                            if ($data = $payment->checkout()) {
                                return $this->response(200, ['status' => 200, 'callback' => $data]);
                            } else {
                                return $this->response(500, ['status' => 500, 'message' => 'Something Went Wrong On Server Side..']);
                            }
                        }
                    }
                } else {
                    $model = new WebinarRegistrations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $model->register_enc_id = $utilitiesModel->encrypt();
                    $model->webinar_enc_id = $webinar_id;
                    $model->status = 1;
                    $model->created_by = $user->user_enc_id;
                    $model->created_on = date('Y-m-d h:i:s');
                    if ($model->save()) {
                        $user = Users::findOne(['user_enc_id' => $user->user_enc_id]);
                        $params = [];
                        $params['webinar_id'] = $webinar_id;
                        $params['email'] = $user->email;
                        $params['name'] = $user->first_name . ' ' . $user->last_name;
                        $params['from'] = 'no-reply@myecampus.in';
                        $params['site_name'] = 'My E-Campus';
                        $params['is_my_campus'] = 1;
                        Yii::$app->notificationEmails->webinarRegistrationEmail($params);

                        if ($webinar['webinar_conduct_on'] == 1) {
                            $params['first_name'] = $user->first_name;
                            $params['last_name'] = $user->last_name;
                            $params["webinar_zoom_id"] = $webinar->platform_webinar_id;
                            $params["user_id"] = $user->user_enc_id;
                            Yii::$app->notificationEmails->zoomRegisterAccess($params);
                        }
                        return $this->response(201, ['status' => 201, 'message' => 'Successfully Registered']);
                    }
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateStatus()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!isset($params['payment_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information1']);
            }
            $args = [
                'payment_enc_id' => $params['payment_enc_id'],
                'payment_status' => $params['payment_status'],
                'registration_enc_id' => $params['registration_enc_id'],
                'payment_id' => $params['payment_id']
            ];
            $payment = new \common\models\extended\WebinarPayments();
            if ($payment->load($args, '')) {
                $payment->registration_enc_id = $args['registration_enc_id'];
                if ($payment->updateStatus()) {
                    return $this->response(200, ['status' => 200, 'message' => 'success']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'Something Went Wrong On Server Side..']);
                }
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionCollegeAllWebinars()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();
            $webinar = new \common\models\extended\Webinar();
            $data['college_id'] = $college_id['organization_enc_id'];
            $data['type'] = 'past';
            $past = $webinar->allWebinars($data);
            $data['type'] = 'upcoming';
            $upcoming = $webinar->allWebinars($data);

            $all_data['past_webinars'] = $past;
            $all_data['upcoming_webinars'] = $upcoming;
            return $this->response(200, ['status' => 200, 'data' => $all_data]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}