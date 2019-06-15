<?php

namespace account\controllers;

use common\models\EmailSettings;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SettingsController extends Controller
{
    public function actionIndex(){
        if(Yii::$app->user->identity->organization->organization_enc_id){
            return $this->render('organization-settings');
        }
        return $this->render('individual-settings');
    }

    public function actionEmailSettings(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->user->identity->organization_enc_id) {
                $frequency_email = Yii::$app->request->post("frequency_email");
                $j_application = Yii::$app->request->post("j_application");
                $i_application = Yii::$app->request->post("i_application");
                $applied = Yii::$app->request->post("applied");
                $resume = Yii::$app->request->post("resume");
                $reviews = Yii::$app->request->post("reviews");

                $settings = EmailSettings::find()
                    ->select(['email_settings_enc_id'])
                    ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id,'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
                    ->asArray()
                    ->one();

                if (empty($settings)) {
                    $emailSettings = new EmailSettings();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $emailSettings->email_settings_enc_id = $utilitiesModel->encrypt();
                    $emailSettings->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
                    $emailSettings->user_enc_id = Yii::$app->user->identity->user_enc_id;
                    $emailSettings->frequency = $frequency_email;
                }
            }
        }
    }
}