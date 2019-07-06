<?php

namespace frontend\controllers;

use common\models\Referral;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\Utilities;
use Yii;

class JoinUsController extends Controller
{
    public function actionIndex($ref)
    {
        $cookies_response = Yii::$app->response->cookies;
        $cookies_response->add(new \yii\web\Cookie([
            'name' => 'ref_csrf-tc',
            'value' => $ref,
        ]));
        return $this->redirect('/');
    }

    private function getReferralCode($n = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function actionAdd()
    {
        $model = new Referral();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->referral_enc_id = $utilitiesModel->encrypt();
        $model->code = $this->getReferralCode();
        $model->referral_link = 'sneh.eygb.me/join-us?ref=' . $model->code;
        $model->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $model->created_by = Yii::$app->user->identity->user_enc_id;
        if ($model->save()) {
            return $model->referral_link;
        } else {
            print_r($model->getErrors());
        }
    }
}