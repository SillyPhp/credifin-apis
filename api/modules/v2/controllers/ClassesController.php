<?php


namespace api\modules\v2\controllers;

use api\modules\v2\models\ClassForm;
use common\models\AssignedVideoSessions;
use common\models\CollegeCourses;
use common\models\OnlineClasses;
use common\models\Teachers;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use common\models\Utilities;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class ClassesController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'create-class' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    private function getTeacherId()
    {
        if ($user = $this->isAuthorized()) {
            $id = Users::find()
                ->alias('a')
                ->joinWith(['teachers b'])
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            return $id['teachers'][0]['teacher_enc_id'];
        }
    }

    public function actionCreateClass()
    {
        if ($user = $this->isAuthorized()) {
            $teacher_id = $this->getTeacherId();
            $model = new ClassForm();
            $model->teacher_id = $teacher_id;

            if ($model->load(Yii::$app->request->post('data'), '')) {
                if ($model->validate()) {

                    $class_data = OnlineClasses::find()
                        ->where([
                            'teacher_enc_id' => $teacher_id,
                            'class_date' => date('Y-m-d', strtotime($model->date))
                        ])
                        ->andWhere(['or', ['between', 'start_time', $model->start_time, $model->end_time], ['between', 'end_time', $model->start_time, $model->end_time]])
                        ->asArray()
                        ->all();

                    if (empty($class_data)) {
                        if ($model->SaveClass()) {
                            $data = OnlineClasses::find()
                                ->alias('a')
                                ->select(['a.class_enc_id', 'a.status', 'b.course_name', 'c.section_name', 'a.batch', 'a.start_time', 'a.end_time', 'a.class_date'])
                                ->joinWith(['courseEnc b'], false)
                                ->joinWith(['sectionEnc c'], false)
                                ->where(['a.teacher_enc_id' => $teacher_id, 'a.status' => 'Active', 'a.is_deleted' => 0])
                                ->asArray()
                                ->all();
                            return $this->response(200, ['status' => 200, 'data' => $data]);
                        } else {
                            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                        }
                    } else {
                        return $this->response(409, ['status' => 409, 'message' => 'course already on this time']);
                    }
                } else {
                    print_r($model->getErrors());
                }
            } else {
                return $this->response(500, ['status' => 500, 'data not loading']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetCourses()
    {
        if ($this->isAuthorized()) {
            $teacher_id = $this->getTeacherId();

            $college_id = Teachers::find()
                ->alias('a')
                ->select(['b.organization_enc_id college_id'])
                ->joinWith(['collegeEnc b'], false)
                ->where(['a.teacher_enc_id' => $teacher_id])
                ->asArray()
                ->one();

            $courses = CollegeCourses::find()
                ->alias('a')
                ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration'])
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $college_id['college_id']])
                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'courses' => $courses]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetClasses()
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $date_now = $dt->format('y-m-d');
        $time_now = $dt->format('H:i:s');


        if ($this->isAuthorized()) {
            $teacher_id = $this->getTeacherId();
            $classes = OnlineClasses::find()
                ->alias('a')
                ->select(['a.class_enc_id', 'a.status', 'b.course_name', 'c.section_name', 'a.batch', 'a.start_time', 'a.end_time', 'a.class_date', 'CONCAT(a.class_date," ",a.end_time) date_time'])
                ->joinWith(['courseEnc b'], false)
                ->joinWith(['sectionEnc c'], false)
                ->where(['a.teacher_enc_id' => $teacher_id, 'a.status' => 'Active', 'a.is_deleted' => 0])
                ->andWhere(['a.class_date' => $date_now])
                ->andWhere(['>=', 'a.end_time', $time_now])
                ->orderBy(['a.class_date' => SORT_ASC, 'a.start_time' => SORT_ASC])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($classes as $c) {
                $seconds = $this->timeDifference($c['start_time'], $c['class_date']);
                $classes[$i]['seconds'] = $seconds;
                $classes[$i]['is_started'] = ($seconds < 0 ? true : false);
                $i++;
            }

            if ($classes) {
                return $this->response(200, ['status' => 200, 'data' => $classes]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetUpcomingClasses()
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $date_now = $dt->format('y-m-d');


        if ($this->isAuthorized()) {
            $teacher_id = $this->getTeacherId();
            $classes = OnlineClasses::find()
                ->alias('a')
                ->select(['a.class_enc_id', 'a.status', 'b.course_name', 'c.section_name', 'a.batch', 'a.start_time', 'a.end_time', 'a.class_date', 'CONCAT(a.class_date," ",a.end_time) date_time'])
                ->joinWith(['courseEnc b'], false)
                ->joinWith(['sectionEnc c'], false)
                ->where(['a.teacher_enc_id' => $teacher_id, 'a.status' => 'Active', 'a.is_deleted' => 0])
                ->andWhere(['>', 'a.class_date', $date_now])
                ->orderBy(['a.class_date' => SORT_ASC, 'a.start_time' => SORT_ASC])
                ->asArray()
                ->all();

            if ($classes) {
                return $this->response(200, ['status' => 200, 'data' => $classes]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function timeDifference($start_time, $date)
    {
        $datetime = new \DateTime();
        $timezone = new \DateTimeZone('Asia/Kolkata');
        $datetime->setTimezone($timezone);
        $time1 = $datetime->format('y-m-d H:i:s');

        $seconds = strtotime($date . $start_time) - strtotime($time1);

        return $seconds;
    }

    public function actionSaveSession()
    {
        if ($this->isAuthorized()) {

            $teacher_id = $this->getTeacherId();
            $data = Yii::$app->request->post('data');

            $today = $data['expiry_date'];
            $today = str_replace('/', '-', $today);
            $today = date('Y-m-d', strtotime($today));
            $nextday = date("d/m/Y", strtotime($today . "+1 day"));

            $model = new AssignedVideoSessions();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->assigned_video_enc_id = $utilitiesModel->encrypt();
            $model->expire_date = date('Y-m-d', strtotime($nextday));
            $model->class_enc_id = $data['class_id'];
            $model->session_enc_id = $data['session_id'];
            $model->created_by = $teacher_id;
            $model->created_on = date('y-m-d H:i:s');
            if ($model->save()) {
                return $this->response(200, ['status' => 200, 'message' => 'saved']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionValidateSession()
    {
        if ($this->isAuthorized()) {
            $class_id = Yii::$app->request->post('class_id');
            $session = AssignedVideoSessions::find()
                ->where(['class_enc_id' => $class_id])
                ->asArray()
                ->one();

            if ($session) {
                return $this->response(200, ['status' => 200, 'session_id' => $session['session_enc_id']]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
            }
        }
    }

    public function actionGetStudentSession()
    {
        if ($this->isAuthorized()) {
            $class_id = Yii::$app->request->post('class_id');
            $class = AssignedVideoSessions::find()
                ->select(['session_enc_id session_id'])
                ->where(['class_enc_id' => $class_id])
                ->asArray()
                ->one();

            if ($class) {
                return $this->response(200, ['status' => 200, 'session_id' => $class['session_id']]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}