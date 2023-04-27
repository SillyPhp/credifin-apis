<?php

namespace api\modules\v4\controllers;

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

        $params = Yii::$app->request->post();

        $push_notifications = new PushNotifications();
        $push_notifications->push_notification_enc_id = Yii::$app->getSecurity()->generateRandomString();
        $push_notifications->token = $params['token'];
        $push_notifications->created_on = date('Y-m-d H:i:s');
        if (!$push_notifications->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

    }
}