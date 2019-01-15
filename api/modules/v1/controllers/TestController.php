<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

class TestController extends Controller{

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index' => ['POST']
            ]
        ];
        return $behaviors;
    }

    public function actionIndex(){
        return 'hello';
    }
}