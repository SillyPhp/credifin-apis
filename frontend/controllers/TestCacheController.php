<?php

namespace frontend\controllers;
use common\models\Auth;
use common\models\Utilities;
use yii\web\Controller;
use common\models\RandomColors;
use Yii;

class TestCacheController extends Controller
{
    public function actionTest()
    {
        try {
            $model = new Auth();
            $model->user_id = 12;
            if (!$model->save()) //model errors
            {
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
            }

            //some kind of err
        } catch (\Exception $exception) {
            return $exception->getMessage(); //final messege for user
        }
    }

//    public function actionSms(){
//        return Yii::$app->sms->send('7814871632','EYOUTH','hello');
//    }

     public function actionImages(){
         $canvas = null;
         $profile = 'others.png';
         $company_logo = null;
         $application_enc_id = 'test';
         $job_title = 'Shift Supervisor Management Trainee';
         $company_name = 'CVS Health';
         $locations = 'Ludhiana, Jalandhar';
         $content = [
             'job_title' => $job_title,
             'company_name' => $company_name,
             'canvas' => (($canvas) ? false : true),
             'bg_icon' => $profile,
             'logo' => (($company_logo) ? $company_logo : null),
             'initial_color' => RandomColors::one(),
             'location' => $locations,
             'app_id' => $application_enc_id,
             'permissionKey' => Yii::$app->params->EmpowerYouth->permissionKey
         ];
         $Instaimage = \frontend\models\script\StoriesImageScript::widget(['content' => $content]);
         echo $Instaimage;
     }
}
