<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\PushNotifications;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
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

    public function actionSaveToken(){
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            $push_notifications = new PushNotifications();
            $push_notifications->push_notification_enc_id = Yii::$app->getSecurity()->generateRandomString();
            $push_notifications->token = $params['token'];
            $push_notifications->created_on = date('Y-m-d H:i:s');
            $push_notifications->user_enc_id = $user->user_enc_id;
            if (!$push_notifications->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'user_id' => $user->user_enc_id ]);
        }
    }

    public function actionUpdateToken(){
        $params = Yii::$app->request->post();

        if(empty($params['token'])){
            return $this->response(404, ['status' => 404, 'message' => '"token" in missing']);
        }
        $push_notification = PushNotifications::findOne(['token' => $params['token'], 'is_deleted' => 0]);
        if($push_notification){
            $push_notification->is_deleted = 1;
            $push_notification->token_expired_on = date('Y-m-d H:i:s');
            if(!$push_notification->update()){
                return $this->response(500, 'an error occurred');
            }
        }

        return $this->response(200, ['status' => 200, 'message' => 'Token Expired Successfully']);
    }

    public function actionPushNotification(){
        $params = Yii::$app->request->post();

        if(empty($params['userIds']) || empty($params['title'])){
            return $this->response(500, ['status' => 500, 'message' => 'Missing information "userIds" or "title"']);
        }

        $notification = new UserUtilities();
        $sendNotify = $notification->sendPushNotification($params['userIds'], $params['title'], $params['body']);


        return $this->response(200, ['status' => 200, 'data' => $sendNotify]);
    }
}