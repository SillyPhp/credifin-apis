<?php

namespace frontend\controllers;

use common\models\AppliedApplications;
use common\models\Auth;
use common\models\Posts;
use common\models\SkillsUpPostAssignedBlogs;
use common\models\Users;
use common\models\RandomColors;
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

    public function actionSkill(){
        $data = SkillsUpPostAssignedBlogs::find()
            ->alias('a')
            ->select(['b.is_visible','b.post_enc_id'])
            ->joinWith(['blogPostEnc b'],false,'INNER JOIN')
            ->asArray()->all();
        $k = 0;
        foreach ($data as $d){
            $update = Posts::findOne(['post_enc_id'=>$d['post_enc_id']]);
            $update->is_visible = 0;
            $update->update();
            $k++;
        }
        return $k;
    }

    public function actionEmailBulk($get=null,$start=null,$end=null){
        $file1 = Url::to('@rootDirectory/files/temp/EdTech-Loan-Proposal.pdf');
        $file2 = Url::to('@rootDirectory/files/temp/College-Proposal.pdf');
           $csv = [];
           $i = 0;
           if (($handle = fopen(Url::to('@rootDirectory/files/temp/list.csv'), "r")) !== false) {
               $columns = fgetcsv($handle, 1000, ",");
               while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                   $csv[$i] = array_combine($columns, $row);
                   $i++;
               }
               fclose($handle);
           }
           $start = $start;
           $end = $end;
           for ($i=$start;$i<=$end;$i++){
               if (!empty($csv[$i]['Email'])){
                   Yii::$app->mailer->htmlLayout = 'layouts/email';
                   $mail = Yii::$app->mailer->compose(
                       ['html' => 'Partnership'],['data'=>'']
                   )
                       ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                       ->setTo([$csv[$i]['Email'] => $csv[$i]['Name']])
                       ->setSubject('EmpowerYouth Partnership Proposal')
                       ->setReplyTo('sumit@empoweryouth.com')
                       ->attach($file1)
                       ->attach($file2);
                   if ($mail->send()) {
                       echo $i.'<br>';
                   }
               }
           }
       }

    public function actionEmailTest($get=null,$start=null,$end=null){
        $file1 = Url::to('@rootDirectory/files/temp/EdTech-Loan-Proposal.pdf');
        $file2 = Url::to('@rootDirectory/files/temp/College-Proposal.pdf');
            $csv = [];
            $i = 0;
            if (($handle = fopen(Url::to('@rootDirectory/files/temp/list1.csv'), "r")) !== false) {
                $columns = fgetcsv($handle, 1000, ",");
                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    $csv[$i] = array_combine($columns, $row);
                    $i++;
                }
                fclose($handle);
            }
            $start = $start;
            $end = $end;
            for ($i=$start;$i<=$end;$i++){
                if (!empty($csv[$i]['Email'])){
                    Yii::$app->mailer->htmlLayout = 'layouts/email';
                    $mail = Yii::$app->mailer->compose(
                        ['html' => 'Partnership'],['data'=>'']
                    )
                        ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                        ->setTo([$csv[$i]['Email'] => $csv[$i]['Name']])
                        ->setSubject('EmpowerYouth Partnership Proposal')
                        ->setReplyTo('sumit@empoweryouth.com')
                        ->attach($file1)
                        ->attach($file2);
                    if ($mail->send()) {
                        echo $i.'<br>';
                    }
                }
            }
        }
}
