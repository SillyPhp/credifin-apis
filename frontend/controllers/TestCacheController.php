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


    public function actionEmailTest($get=null,$start=null,$end=null){
            $csv = [];
            $i = 0;
            if (($handle = fopen(Url::to('@rootDirectory/files/temp/dav.csv'), "r")) !== false) {
                $columns = fgetcsv($handle, 1000, ",");
                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    $csv[$i] = array_combine($columns, $row);
                    $i++;
                }
                fclose($handle);
            }
            $start = $start;
            $end = $end;
            $data = [];
        $data['slug'] = 'marketing-executive-marketing-executive-52101628924998';
        $data['cat_name'] = 'Marketing Executive';
        $data['organization_logo'] = 'https://eycdn.ams3.digitaloceanspaces.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/Knsww6dU-GqWw97vqQGrox62CaBfwYze/XGpD9mA68oPv0g01X6rOQBVl4kwJne.png';
        $data['organization_name'] = 'Empower Youth';
        $data['org_name'] = 'Empower Youth';
        $data['application_type'] = 'Job';
        $data['name'] = 'Marketing';
        $data['industry'] = 'Same Industry';
        $data['designation'] = 'Marketing Executive';
        $data['amount'] = '180000 p.a';
        $data['profile_icon'] = 'marketing.png';
        $data['preferred_gender'] = 0;
        $data['experience'] = null;
        $data['applicationEmployeeBenefits']=null;
        $data['working_days'] = [1,2,3,4,5,6];
            for ($i=$start;$i<=$end;$i++){
                if (!empty($csv[$i]['Email'])){
                    Yii::$app->mailer->htmlLayout = 'layouts/email';
                    $mail = Yii::$app->mailer->compose(
                        ['html' => 'job-detail-email-myecampus-demo.php'],['data'=>$data]
                    )
                        ->setFrom(['no-reply@myecampus.in'=>'MyECampus'])
                        ->setTo([$csv[$i]['Email'] => $csv[$i]['Name']])
                        ->setSubject('Empower Youth has shortlisted you for Marketing Executive');
                    if ($mail->send()) {
                        echo $i.'<br>';
                    }
                }
            }
        }

    public function actionReminderEmail(){
        $i = 0;
        $data = WebinarRegistrations::find()
            ->alias('a')
            ->select(['CONCAT(c.first_name," ",c.last_name) name','c.email'])
            ->joinWith(['createdBy c'],false,'INNER JOIN')
            ->where(['a.status'=>1])
            ->andWhere(['a.webinar_enc_id'=>'E9n1pJ74KRzvWNxkap8xRgxm0e5ND6'])
            ->asArray()->all();
        foreach ($data as $param){
            $subject = "Reminder- Your Webinar Session Is Going To Live";
            Yii::$app->mailer->htmlLayout = 'layouts/email';
            $mail = Yii::$app->mailer->compose(
                ['html' => 'webinar-registration-mail.php'],['data'=>$param]
            )
                ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                ->setTo([$param['email'] => $param['name']])
                ->setSubject($subject);
            if (!$mail->send()) {
                return true;
            }else{
                $i++;
            }
        }
        echo $i;
    }
}
