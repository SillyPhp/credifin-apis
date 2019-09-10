<?php

namespace api\modules\v2\controllers;

use api\modules\v1\models\Candidates;
use common\models\UserAccessTokens;
use Yii;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

class TestController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'demo' => ['OPTIONS', 'POST'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['http://127.0.0.1:5500'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionDemo()
    {
        if($this->isAuthorized()){
            return $this->response(200,1);
        }else{
            return $this->response(201, 2);
        }
    }
}