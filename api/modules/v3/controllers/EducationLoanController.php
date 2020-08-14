<?php
namespace api\modules\v3\controllers;
use common\models\CollegeCourses;
use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class EducationLoanController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-course-list' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetCourseList()
    {
        $params= Yii::$app->request->post();
        if ($params['id'])
        {
            $courses = CollegeCourses::find()
                ->alias('a')
                ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }], false)
                ->where(['a.organization_enc_id' => $params['id'], 'a.is_deleted' => 0])
                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();
            if ($courses) {
                return $this->response(200, ['status' => 200, 'courses' => $courses]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        }else{
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }
}