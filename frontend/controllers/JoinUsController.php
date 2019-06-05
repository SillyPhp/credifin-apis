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
    private function getReferralCode($n=10)
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
        $model  = new Referral();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->referral_enc_id = $utilitiesModel->encrypt();
        $model->code = $this->getReferralCode();
        $model->referral_link = 'sneh.eygb.me/join-us?ref='.$model->code;
        $model->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $model->created_by = Yii::$app->user->identity->user_enc_id;
            if($model->save())
            {
                return $model->referral_link;
            }
            else
            {
                print_r($model->getErrors());
            }
    }
    public function actionTest1()
    {
        $cookies_request = Yii::$app->request->cookies;
        return $cookies_request->get('ref_csrf-tc');
    }
    public function actionTest2()
    {
        $cookies_request = Yii::$app->request->cookies;
        return $cookies_request->get('code');
    }

    private function chk_referral()
    {
        $cookies_request = Yii::$app->request->cookies;
        $code = $cookies_request->get('ref_csrf-tc');
        if (!empty($code))
        {
            $ref = Referral::findOne(['code'=>$code]);
            $model = new ReferralSignUpTracking();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->tracking_signup_enc_id = $utilitiesModel->encrypt();
            $model->referral_enc_id = $ref->referral_enc_id;
            $model->sign_up_user_enc_id = $usersModel->user_enc_id;
            if ($model->save())
            {
                return true;
            }
        }
    }
}