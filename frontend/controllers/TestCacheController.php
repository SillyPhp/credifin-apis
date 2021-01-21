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

    public function actionSetAutoApprove()
    {
        $colleges = Organizations::find()
            ->alias('a')
            ->innerJoinWith(['businessActivityEnc b'], false)
            ->where(['b.business_activity' => 'College', 'a.is_deleted' => 0, 'a.status' => 'Active', 'a.is_erexx_registered' => 1])
            ->asArray()
            ->all();

        foreach ($colleges as $key => $val) {
            $settings = CollegeSettings::find()
                ->where(['college_enc_id' => $val['organization_enc_id']])
                ->asArray()
                ->all();

            if (!$settings) {
                $erexx_settings = ErexxSettings::find()
                    ->where(['setting' => 'students_approve'])
                    ->one();

                $student_auto_approve = new CollegeSettings();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $student_auto_approve->college_settings_enc_id = $utilitesModel->encrypt();
                $student_auto_approve->college_enc_id = $val['organization_enc_id'];
                $student_auto_approve->setting_enc_id = $erexx_settings->setting_enc_id;
                $student_auto_approve->value = 2;
                $student_auto_approve->created_on = date('Y-m-d H:i:s');
                $student_auto_approve->created_by = $val['created_by'];
                if (!$student_auto_approve->save()) {
                    print_r($student_auto_approve->getErrors());
                    die();
                }
            }

        }

        print_r('done');
        die();

    }

    public function actionAddStreams()
    {
        $streams = CollegeStreams::find()
            ->asArray()
            ->all();

        if ($streams) {
            foreach ($streams as $v) {
                $college_courses = new CollegeCoursesPool();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $college_courses->course_enc_id = $utilitesModel->encrypt();
                $college_courses->type = 'Stream';
                $college_courses->course_name = $v['name'];
                $college_courses->created_by = $v['created_by'];
                $college_courses->created_on = date('Y-m-d H:i:s');
                if (!$college_courses->save()) {
                    print_r($college_courses->getErrors());
                    die();
                }
            }
        }

        print_r('done');
        die();
    }

}
