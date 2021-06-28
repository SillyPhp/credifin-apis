<?php

namespace frontend\controllers;

use common\models\AppliedApplications;
use common\models\Auth;
use common\models\Users;
use common\models\RandomColors;
use common\models\Utilities;
use yii\web\Controller;
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

    public function actionImages()
    {
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
        $story= \frontend\models\script\StoriesImageScript::widget(['content' => $content]);
        echo $story;
    }
    public function actionEmail(){
        $params = AppliedApplications::find()
         ->alias('a')
         ->select(['CONCAT(b.first_name," ",b.last_name) name','b.email','a.applied_application_enc_id applied_id'])
         ->where(['application_enc_id'=>'2DeBxPEjOGdjkjgnV3beQpqANyVYw9','current_round'=>2])
         ->innerJoin(Users::tableName().'as b','b.user_enc_id = a.created_by')
         ->asArray()
         ->all();
        $k = 0;
        foreach ($params as $param){
            Yii::$app->mailer->htmlLayout = 'layouts/email';
            $mail = Yii::$app->mailer->compose(
                ['html' => 'job-process-status'],['data'=>$param]
            )
                ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                ->setTo([$param['email'] => $param['name']])
                ->setSubject('Your Job Application Has Been Accepted');
            if ($mail->send()) {
               $k++;
            }
        }
        echo $k;
    }
}
