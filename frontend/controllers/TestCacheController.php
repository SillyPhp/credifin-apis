<?php

namespace frontend\controllers;

use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Auth;
use common\models\CollegeCoursesPool;
use common\models\CollegeSettings;
use common\models\CollegeStreams;
use common\models\EmployerApplications;
use common\models\ErexxSettings;
use common\models\InterviewProcessFields;
use common\models\Organizations;
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
        $Instaimage = \frontend\models\script\StoriesImageScript::widget(['content' => $content]);
        echo $Instaimage;
    }

    public function actionSaveProcess()
    {
        $applied = AppliedApplications::find()
            ->asArray()
            ->all();

        $notCount = 0;
        foreach ($applied as $a) {
            $process = AppliedApplicationProcess::find()
                ->where(['applied_application_enc_id' => $a['applied_application_enc_id']])
                ->asArray()
                ->all();

            if (!$process) {
                $this->save_process($a['application_enc_id'], $a['applied_application_enc_id'], $a['created_by']);
                $notCount += 1;
            }
        }

        print_r($notCount);
        die();
    }

    private function save_process($id, $app_id, $user_enc_id)
    {
        $process_list = EmployerApplications::find()
            ->alias('a')
            ->select(['b.field_name', 'b.field_enc_id'])
            ->where(['a.application_enc_id' => $id])
            ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.interview_process_enc_id = a.interview_process_enc_id')
            ->asArray()
            ->all();
        foreach ($process_list as $process) {
            $processModel = new AppliedApplicationProcess;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $processModel->process_enc_id = $utilitiesModel->encrypt();
            $processModel->applied_application_enc_id = $app_id;
            $processModel->field_enc_id = $process['field_enc_id'];
            $processModel->created_on = date('Y-m-d h:i:s');
            $processModel->created_by = $user_enc_id;
            if (!$processModel->save()) {
                return false;
            }
        }
    }

}
