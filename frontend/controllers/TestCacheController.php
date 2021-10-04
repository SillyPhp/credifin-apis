<?php

namespace frontend\controllers;

use common\models\AppliedApplications;
use common\models\Auth;
use common\models\Posts;
use common\models\SkillsUpPostAssignedBlogs;
use common\models\Users;
use common\models\RandomColors;
use common\models\Utilities;
use common\models\WebinarRegistrations;
use yii\helpers\Url;
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

    public function actionEmail(){
        $params = AppliedApplications::find()
         ->alias('a')
         ->select(['CONCAT(b.first_name," ",b.last_name) name','b.email','a.applied_application_enc_id applied_id'])
         ->where(['application_enc_id'=>'2DeBxPEjOGdjkjgnV3beQpqANyVYw9'])
         ->innerJoin(Users::tableName().'as b','b.user_enc_id = a.created_by')
         ->asArray()
         ->one();
         $params['subject'] = 'Your Application has been selected';
         Yii::$app->notificationEmails->candidateProcessNotification($params);
    }

   public function actionJava(){
        $this->layout = 'widget-layout';
        return $this->render('pdf');
   }

}
