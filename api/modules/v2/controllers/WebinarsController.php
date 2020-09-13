<?php

namespace api\modules\v2\controllers;

use common\models\Speakers;
use common\models\UserOtherDetails;
use common\models\Users;
use common\models\WebinarConversationMessages;
use common\models\WebinarConversations;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\WebinarSessions;
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
        $webSpeaker = Speakers::find()
            ->distinct()
            ->alias('a')
            ->select(['a.speaker_enc_id',
                'a.unclaimed_org_id',
                'a.designation_enc_id',
                'b.designation',
                'CONCAT(f.first_name, " ", f.last_name) fullname',
                'f.email', 'f.phone',
                'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) END image',
                'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", c.logo_location, "/", c.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", c.name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END logo',
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
            ->joinWith(['userEnc f'], false)
            ->orderBy(['a.created_on' => SORT_DESC])
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

            $webinar = Webinars::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.webinar_enc_id',
                    'a.session_enc_id',
                    'a.title',
                    'a.start_datetime',
                    'a.duration',
                    'a.availability',
                    'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) END image',
                    'a.description',
                ])
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
                ->joinWith(['sessionEnc e'])
                ->where([
                    'b.organization_enc_id' => $college_id['organization_enc_id'],
                    'a.is_deleted' => 0,
                    'a.status' => [0, 1]
                ])
                ->andWhere(['not', ['a.session_for' => 1]])
                ->asArray()
                ->all();


//            $j = 0;
//            $data = [];
//            foreach ($webinar as $w) {
//                $newtimestamp = strtotime($w['start_datetime'] . ' + ' . $w['duration'] . ' minute');
//                $end_time = date('Y-m-d H:i:s', $newtimestamp);
//                if ($end_time > $date_now) {
//                    array_push($data, $webinar[$j]);
//                }
//                $j++;
//            }
//
//            $webinar = $data;

            if (!empty($webinar)) {
                $i = 0;
                foreach ($webinar as $w) {
                    $registered_count = WebinarRegistrations::find()
                        ->where(['is_deleted' => 0, 'status' => 1, 'webinar_enc_id' => $w['webinar_enc_id']])
                        ->count();
                    $webinar[$i]['count'] = $registered_count;
                    $user_registered = $this->userRegistered($w['webinar_enc_id'], $user_id);
                    $webinar[$i]['is_registered'] = $user_registered;
                    $date = new \DateTime($w['start_datetime']);
                    $seconds = $this->timeDifference($date->format('H:i:s'), $date->format('Y-m-d'));
                    $webinar[$i]['seconds'] = $seconds;
                    $webinar[$i]['is_started'] = ($seconds < 0 ? true : false);
                    $i++;
                }
            }

            if ($webinar) {
                return $this->response(200, ['status' => 200, 'data' => $webinar]);
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
                'f.email', 'f.phone',
                'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) END image',
                'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", c.logo_location, "/", c.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", c.name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END logo',
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
            $webinar = Webinars::findOne(['session_enc_id' => $data['session_enc_id']]);
            $conversation_id = WebinarConversations::find()
                ->where(['webinar_enc_id' => $webinar->webinar_enc_id])
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
                    $conversation->webinar_enc_id = $webinar->webinar_enc_id;
                    $conversation->created_by = Yii::$app->user->identity->user_enc_id;
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
                    $comment->created_by = Yii::$app->user->identity->user_enc_id;
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

            $webinar = Webinars::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.webinar_enc_id',
                    'a.title',
                ])
                ->joinWith(['webinarSpeakers c' => function ($bb) {
                    $bb->select([
                        'c.webinar_enc_id',
                        'c.speaker_enc_id',
                        'CONCAT(cc1.first_name," ",cc1.last_name) full_name',
                    ]);
                    $bb->joinWith(['speakerEnc c1' => function ($c1) {
                        $c1->select(['c1.speaker_enc_id']);
                        $c1->joinWith(['userEnc cc1'], false);
                        $c1->joinWith(['designationEnc c2' => function ($c2) {
                            $c2->onCondition(['c2.is_deleted' => 0, 'c2.status' => 'Publish']);
                        }], false);
                        $c1->onCondition(['c1.is_deleted' => 0]);
                    }]);
                    $bb->onCondition(['c.is_deleted' => 0]);
                }])
                ->where([
                    'a.is_deleted' => 0,
                    'a.session_enc_id' => $session_enc_id
                ])
                ->asArray()
                ->one();

            $register_user = WebinarRegistrations::find()
                ->where(['webinar_enc_id' => $webinar['webinar_enc_id'], 'created_by' => $user->user_enc_id])
                ->one();

            if ($register_user) {
                $register_user->status = 1;
                $register_user->last_updated_on = date('Y-m-d H:i:s');
                $register_user->last_updated_by = $user->user_enc_id;
                $register_user->update();
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
            }

            if ($validate_s_id->session_id) {
                return $this->response(200, ['status' => 200, 'data' => $webinar]);
            } else {
                return $this->response(404, ['status' => 404, 'data' => $webinar]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionDetail()
    {
        if ($user = $this->isAuthorized()) {

            $user_id = $user->user_enc_id;

            $college_id = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $param = Yii::$app->request->post();

            if (isset($param['webinar_id']) && !empty($param['webinar_id'])) {
                $webinar_id = $param['webinar_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $webinar = Webinars::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.webinar_enc_id',
                    'a.title',
                    'a.session_enc_id',
                    'a.start_datetime',
                    'a.availability',
                    'a.duration',
                    'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) END image',
                    'a.description',
                    'a.seats',
                    'a.status'
                ])
                ->joinWith(['assignedWebinarTos b'], false)
                ->joinWith(['webinarOutcomes b1' => function ($b1) {
                    $b1->select([
                        'b1.webinar_enc_id',
                        'b1.outcome_enc_id',
                        'b2.name',
                        'b2.bg_colour',
                        'CASE WHEN b2.icon IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->outcomes->image, 'https') . '", b2.icon_location, "/", b2.icon) END icon',
                    ]);
                    $b1->joinWith(['outcomePoolEnc b2'], false);
                    $b1->andWhere(['b1.is_deleted' => 0]);
                }])
                ->joinWith(['webinarSpeakers c' => function ($bb) {
                    $bb->select([
                        'c.webinar_enc_id',
                        'c.speaker_enc_id',
                        'CONCAT(cc1.first_name," ",cc1.last_name) full_name',
                        'CASE WHEN cc1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", cc1.image_location, "/", cc1.image) END image',
                        'cc1.email',
                        'cc1.phone',
                        'cc1.facebook',
                        'cc1.twitter',
                        'cc1.linkedin',
                        'cc1.instagram',
                        'c2.designation',
                    ]);
                    $bb->joinWith(['speakerEnc c1' => function ($c1) {
                        $c1->select(['c1.speaker_enc_id']);
                        $c1->joinWith(['userEnc cc1'], false);
//                        $c1->joinWith(['speakerExpertises ccc1' => function ($ccc1) {
//                            $ccc1->select(['ccc1.expertise_enc_id', 'ccc1.speaker_enc_id', 'ccc1.skill_enc_id', 'g1.skill']);
//                            $ccc1->joinWith(['skillEnc g1' => function ($g1) {
//                                $g1->onCondition(['g1.is_deleted' => 0]);
//                            }], false);
//                            $ccc1->onCondition(['ccc1.is_deleted' => 0]);
//                        }]);
                        $c1->joinWith(['designationEnc c2' => function ($c2) {
                            $c2->onCondition(['c2.is_deleted' => 0, 'c2.status' => 'Publish']);
                        }], false);
                        $c1->onCondition(['c1.is_deleted' => 0]);
                    }]);
                    $bb->onCondition(['c.is_deleted' => 0]);
                }])
                ->joinWith(['webinarRegistrations d' => function ($d) {
                    $d->select([
                        'd.webinar_enc_id',
                        'd.register_enc_id',
                        'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
                    ]);
                    $d->joinWith(['createdBy d1'], false);
                    $d->onCondition(['d.status' => 1, 'd.is_deleted' => 0]);
                }])
                ->where([
                    'b.organization_enc_id' => $college_id['organization_enc_id'],
                    'a.is_deleted' => 0,
                    'a.webinar_enc_id' => $webinar_id
                ])
                ->asArray()
                ->one();

            if (!empty($webinar)) {
                $user_registered = $this->userRegistered($webinar['webinar_enc_id'], $user_id);
                $webinar['is_registered'] = $user_registered;
                $webinar['interest_status'] = $this->interested($webinar['webinar_enc_id'], $user_id);
                $date = new \DateTime($webinar['start_datetime']);
                $seconds = $this->timeDifference($date->format('H:i:s'), $date->format('Y-m-d'));
                $webinar['seconds'] = $seconds;
                $webinar['is_started'] = ($seconds < 0 ? true : false);
            }


            if ($webinar) {
                return $this->response(200, ['status' => 200, 'data' => $webinar]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function interested($webinar_id, $user_id)
    {
        $interest = WebinarRegistrations::find()
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
            ->where(['created_by' => $user_id, 'webinar_enc_id' => $webinar_id, 'status' => 1])
            ->exists();
    }
}