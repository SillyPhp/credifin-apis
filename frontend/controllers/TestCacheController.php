<?php

namespace frontend\controllers;

use common\models\AssignedCollegeCourses;
use common\models\CollegeCourses;
use common\models\CollegeCoursesPool;
use common\models\LoanApplications;
use common\models\PathToClaimOrgLoanApplication;
use Yii;
use yii\web\Controller;
use common\models\Utilities;

class TestCacheController extends Controller
{
    public function actionUpdatesPool()
    {
        $data = CollegeCourses::find()
            ->distinct('course_name')
            ->select(['course_name'])
            ->asArray()->all();
        if (!empty($data)) {
            $i = 1;
            foreach ($data as $d) {
                $coursePool = new CollegeCoursesPool();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $coursePool->course_enc_id = $utilitiesModel->encrypt();
                $coursePool->course_name = $d['course_name'];
                $coursePool->created_by = Yii::$app->user->identity->user_enc_id;
                $coursePool->created_on = date('Y-m-d H:i:s');
                if (!$coursePool->save()) {
                    print_r($coursePool->getErrors());
                    die();
                } else {
                    $i++;
                }
            }
            echo $i . ' entries saved';
        } else {
            return 'Some Kind of Error';
        }
    }

    public function actionUpdateAssigned()
    {
        $data = CollegeCourses::find()->asArray()->all();
        $i = 1;
        if (!empty($data)) {
            foreach ($data as $d) {
                $courseId = CollegeCoursesPool::findOne(['course_name' => $d['course_name']])->course_enc_id;
                $assignedcoursePool = new AssignedCollegeCourses();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $assignedcoursePool->assigned_college_enc_id = $utilitiesModel->encrypt();
                $assignedcoursePool->organization_enc_id = $d['organization_enc_id'];
                $assignedcoursePool->course_enc_id = $courseId;
                $assignedcoursePool->course_duration = $d['course_duration'];
                $assignedcoursePool->years = $d['years'];
                $assignedcoursePool->semesters = $d['semesters'];
                $assignedcoursePool->type = $d['type'];
                $assignedcoursePool->is_deleted = $d['is_deleted'];
                $assignedcoursePool->created_by = Yii::$app->user->identity->user_enc_id;;
                $assignedcoursePool->created_on = date('Y-m-d H:i:s');
                if (!$assignedcoursePool->save()) {
                    print_r($assignedcoursePool->getErrors());
                    die();
                } else {
                    $i++;
                }
            }
            echo $i . ' entries saved';
        } else {
            return 'Some Kind of Error';
        }
    }

    public function actionUpdateLoanData()
    {
        $data = LoanApplications::find()
//            ->select(['loan_app_enc_id', 'college_enc_id', 'college_course_enc_id'])
            ->andWhere(['not', ['college_enc_id' => NULL]])
            ->asArray()
            ->all();

        if ($data) {
            foreach ($data as $d) {
                $courses = CollegeCourses::find()
                    ->where(['college_course_enc_id' => $d['college_course_enc_id']])
                    ->asArray()
                    ->one();

                if ($courses) {
                    $pool = CollegeCoursesPool::find()
                        ->where(['course_name' => $courses['course_name']])
                        ->asArray()
                        ->one();

                    if ($pool) {
                        $assigned_courses = AssignedCollegeCourses::find()
                            ->where(['organization_enc_id' => $d['college_enc_id'], 'course_enc_id' => $pool['course_enc_id']])
                            ->asArray()
                            ->one();

                        if ($assigned_courses) {
                            $path = new PathToClaimOrgLoanApplication();
                            $utilitiesModel = new \common\models\Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $path->bridge_enc_id = $utilitiesModel->encrypt();
                            $path->loan_app_enc_id = $d['loan_app_enc_id'];
                            $path->assigned_course_enc_id = $assigned_courses['assigned_college_enc_id'];
                            $path->created_by = $d['created_by'];
                            if (!$path->save()) {
                                print_r($path->getErrors());
                                die();
                            }
                        }
                    }
                }
            }
            print_r('done');
            die();
        }
    }
}