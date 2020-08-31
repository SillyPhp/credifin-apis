<?php

namespace api\modules\v2\controllers;

use common\models\Speakers;
use common\models\WebinarConversationMessages;
use common\models\WebinarConversations;
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

            if ($validate_s_id->session_id) {
                return $this->response(200, ['status' => 200, 'data' => $webinar]);
            } else {
                return $this->response(404, ['status' => 404, 'data' => $webinar]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}