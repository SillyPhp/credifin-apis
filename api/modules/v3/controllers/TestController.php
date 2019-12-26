<?php

namespace api\modules\v3\controllers;

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
                'test' => ['GET'],
            ]
        ];
        return $behaviors;
    }

    public function actionDemo()
    {
        if($user = $this->isAuthorized()){
            return $this->response(200,$user->user_enc_id);
        }else{
            return $this->response(401, 2);
        }
    }

    public function actionTest()
    {
        return 121;
    }
}