<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\Notifications;
use common\models\NotificationTokens;
use common\models\PushNotifications;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use yii\helpers\Url;
use common\models\Utilities;

// this controller is used for push notifications
class NotificationsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'save-token' => ['POST', 'OPTIONS'],
                'update-token' => ['POST', 'OPTIONS'],
                'get-notifications-list' => ['POST', 'OPTIONS'],
                'set-notification-open' => ['POST', 'OPTIONS']
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionSaveToken()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            $notification_token = new NotificationTokens();
            $notification_token->token_enc_id = Yii::$app->getSecurity()->generateRandomString();
            $notification_token->token = $params['token'];
            $notification_token->created_on = date('Y-m-d H:i:s');
            $notification_token->user_enc_id = $user->user_enc_id;
            if (!$notification_token->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $notification_token->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'user_id' => $user->user_enc_id]);
        }
    }

    public function actionUpdateToken()
    {
        $params = Yii::$app->request->post();

        if (empty($params['token'])) {
            return $this->response(422, ['status' => 422, 'message' => '"token" in missing']);
        }
        $notification_token = NotificationTokens::findOne(['token' => $params['token'], 'is_deleted' => 0]);
        if ($notification_token) {
            $notification_token->is_deleted = 1;
            $notification_token->token_expired_on = date('Y-m-d H:i:s');
            if (!$notification_token->update()) {
                return $this->response(500, 'an error occurred');
            }
        }

        return $this->response(200, ['status' => 200, 'message' => 'Token Expired Successfully']);
    }

    public function actionGetNotificationsList()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();
            $limit = !empty($params['limit']) ? $params['limit'] : 15;
            $page = !empty($params['page']) ? $params['page'] : 1;

            $notifications = Notifications::find()
                ->alias('a')
                ->select(['a.title', 'a.description', 'a.link', 'a.notification_enc_id', 'a.user_enc_id', 'a.is_open', 'a.created_on',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", concat(b.first_name," ",b.last_name), "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'
                ])
                ->joinWith(['createdBy b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id, 'a.is_deleted' => 0]);
            $count = $notifications->count();
            $notifications = $notifications
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            if ($notifications) {
                return $this->response(200, ['status' => 200, 'notification' => $notifications, 'count' => (int)$count]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSetNotificationOpen(){
        if($user = $this->isAuthorized()){
            $params = Yii::$app->request->post();

            if(empty($params['notification_enc_id'])){
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "notification_enc_id"']);
            }
            $notification = Notifications::findOne(['notification_enc_id' => $params['notification_enc_id']]);
            if($notification){
                $notification->is_open = 1;
                $notification->opened_on = date('Y-m-d H:i:s');
                if(!$notification->update()){
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error'=> $notification->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'Notification Updated Successfully']);
            }
        }else{
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionPushNotification()
    {
        $params = Yii::$app->request->post();

        if (empty($params['userIds']) || empty($params['title'])) {
            return $this->response(500, ['status' => 500, 'message' => 'Missing information "userIds" or "title"']);
        }

        $notification = new UserUtilities();
        $sendNotify = $notification->sendPushNotification($params['userIds'], $params['title'], $params['body']);


        return $this->response(200, ['status' => 200, 'data' => $sendNotify]);
    }
}