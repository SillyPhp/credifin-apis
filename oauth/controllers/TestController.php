<?php

namespace oauth\controllers;

use oauth\models\Candidates;
use common\models\UserAccessTokens;
use Yii;
use yii\filters\auth\HttpBearerAuth;

class TestController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        try {
            Yii::$app->user->login($user, 3600 * 24 * 30);
        } catch (\Exception $e) {

        }
        exit();
    }

}