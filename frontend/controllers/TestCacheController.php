<?php

namespace frontend\controllers;

use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Auth;
use common\models\EmployerApplications;
use common\models\InterviewProcessFields;
use common\models\User;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\UserOtherDetails;
use common\models\UserResume;
use common\models\Users;
use common\models\Utilities;
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

    public function actionResume($page, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $resumes = UserResume::find()
            ->select(['resume_enc_id', 'resume', 'resume_location'])
            ->where([
                'or',
                ['!=', 'resume', null],
                ['!=', 'resume', '']
            ])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();

        if ($resumes) {
            foreach ($resumes as $v) {
                $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $cv = $my_space->signedURL(Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->resume->file . $v['resume_location'] . DIRECTORY_SEPARATOR . $v['resume'], "15 minutes");
                $remoteFile = $cv;

                $handle = @fopen($remoteFile, 'r');

                if (!$handle) {
//                    $res = UserResume::find()
//                        ->where(['resume_enc_id' => $v['resume_enc_id']])
//                        ->one();
//                    $res->resume = null;
//                    $res->resume_location = null;
//                    if (!$res->update()) {
//                        print_r($res->getErrors());
//                        die();
//                    }
                    $rows = AppliedApplications::updateAll(['resume_enc_id' => null], 'resume_enc_id = "'.$v['resume_enc_id'].'"');

//                    $applied_resume = AppliedApplications::find()
//                        ->where(['resume_enc_id' => $v['resume_enc_id']])
//                        ->one();
//                    $applied_resume->resume_enc_id = null;
//                    if (!$applied_resume->update()) {
//                        print_r($applied_resume->getErrors());
//                        die();
//                    }
                }
            }
        } else {
            print_r('done');
            die();
        }
        print_r('updated');
    }

    public function actionMakeStudent(){
        $students = UserAccessTokens::find()
            ->alias('a')
            ->distinct()
            ->select(['b.user_enc_id','b.username'])
            ->innerJoin(Users::tableName().'as b','b.user_enc_id = a.user_enc_id')
            ->innerJoin(UserOtherDetails::tableName().'as c','c.user_enc_id = b.user_enc_id')
            ->orderBy('b.id desc')
            ->asArray()
            ->all();

         foreach ($students as $student){
             $model = Users::findOne(['user_enc_id'=>$student['user_enc_id']]);
             $model->signed_up_through = 'ECAMPUS';
             $model->update();
         }
    }

    public function actionMakeAppUser(){
        $user = UserAccessTokens::find()
            ->alias('a')
            ->distinct()
            ->select(['b.user_enc_id','b.username','b.signed_up_through'])
            ->innerJoin(Users::tableName().'as b','b.user_enc_id = a.user_enc_id')
            ->where(['!=','b.signed_up_through','ECAMPUS'])
            ->orderBy('b.id desc')
            ->asArray()
            ->all();

       foreach ($user as $u){
           $model = Users::findOne(['user_enc_id'=>$u['user_enc_id']]);
           $model->signed_up_through = 'EYAPP';
           $model->update();

           $userAssign = Usernames::findOne(['username'=>$u['username']]);
           if (empty($userAssign)){
               $modelName = new Usernames();
               $modelName->assigned_to = 1;
               $modelName->username = $u['username'];
               if (!$modelName->save()){
                   print_r($modelName->getErrors());
               }
           }else{
               $userAssign->assigned_to = 1;
               $userAssign->update();
           }
       }

    }
}
