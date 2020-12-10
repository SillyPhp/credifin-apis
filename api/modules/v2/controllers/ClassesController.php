<?php


namespace api\modules\v2\controllers;

use api\modules\v2\models\ClassComments;
use api\modules\v2\models\ClassForm;
use api\modules\v2\models\UploadNotes;
use common\models\AssignedCollegeCourses;
use common\models\AssignedVideoSessions;
use common\models\ClassNotes;
use common\models\OnlineClassComments;
use common\models\OnlineClasses;
use common\models\Teachers;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use common\models\Utilities;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


class ClassesController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'create-class' => ['POST', 'OPTIONS'],
                'get-courses' => ['POST', 'OPTIONS'],
                'get-classes' => ['POST', 'OPTIONS'],
                'get-upcoming-classes' => ['POST', 'OPTIONS'],
                'save-session' => ['POST', 'OPTIONS'],
                'validate-session' => ['POST', 'OPTIONS'],
                'get-student-session' => ['POST', 'OPTIONS'],
                'save-live-class' => ['POST', 'OPTIONS'],
                'change-status' => ['POST', 'OPTIONS'],
                'save-comment' => ['POST', 'OPTIONS'],
                'get-parent-comments' => ['POST', 'OPTIONS'],
                'get-child-comments' => ['POST', 'OPTIONS'],
                'change-visibility' => ['POST', 'OPTIONS'],
                'get-student-comment' => ['POST', 'OPTIONS'],
                'upload-notes' => ['POST', 'OPTIONS'],
                'get-notes' => ['POST', 'OPTIONS'],
                'all-notes' => ['POST', 'OPTIONS'],
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
                                ->select(['a.class_enc_id', 'a.status', 'bb.course_name', 'c.section_name', 'a.subject_name', 'a.semester', 'a.start_time', 'a.end_time', 'a.class_date'])
                                ->joinWith(['assignedCollegeEnc b'=>function($d){
                                    $d->joinWith(['courseEnc bb']);
                                }], false)
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

            $courses = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['courseEnc c'], false)
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $college_id['college_id'], 'a.is_deleted' => 0])
//                ->groupBy(['a.course_name'])
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
                ->select(['a.class_enc_id', 'a.status', 'bb.course_name', 'c.section_name', 'a.subject_name', 'a.semester', 'a.start_time', 'a.end_time', 'a.class_type', 'a.class_date', 'CONCAT(a.class_date," ",a.end_time) date_time'])
                ->joinWith(['assignedCollegeEnc b'=>function($d){
                    $d->joinWith(['courseEnc bb']);
                }], false)
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
                ->select(['a.class_enc_id', 'a.status', 'bb.course_name', 'c.section_name', 'a.subject_name', 'a.semester', 'a.start_time', 'a.end_time', 'a.class_date', 'CONCAT(a.class_date," ",a.end_time) date_time'])
                ->joinWith(['assignedCollegeEnc b'=>function($d){
                    $d->joinWith(['courseEnc bb']);
                }], false)
                ->joinWith(['sectionEnc c'], false)
                ->where(['a.teacher_enc_id' => $teacher_id, 'a.status' => 'Active', 'a.is_deleted' => 0, 'a.class_type' => 'Scheduled'])
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
            $nextday = date("Y-m-d", strtotime($today . "+1 day"));

            $model = new AssignedVideoSessions();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->assigned_video_enc_id = $utilitiesModel->encrypt();
            $model->expire_date = $nextday;
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

    public function actionSaveLiveClass()
    {

        if ($this->isAuthorized()) {

            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $date_now = $dt->format('y-m-d');
            $time_now = $dt->format('H:i:s');
            $end_time = $dt->modify('+1 hours');
            $end_time = $end_time->format('H:i:s');

            $teacher_id = $this->getTeacherId();

            $data = Yii::$app->request->post('data');

            $model = new OnlineClasses();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->class_enc_id = $utilitiesModel->encrypt();
            $model->teacher_enc_id = $teacher_id;
            $model->semester = $data['semester'];
            $model->subject_name = $data['subject_name'];
            $model->assigned_college_enc_id = $data['course_id'];
            $model->section_enc_id = $data['section_id'];
            $model->start_time = $time_now;
            $model->end_time = $end_time;
            $model->class_type = 'Live';
            $model->class_date = $date_now;
            $model->created_on = date('Y-m-d H:i:s');

            if ($model->save()) {
                $data = [];
                $data['class_id'] = $model->class_enc_id;
                $data['class_date'] = $model->class_date;
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 500, 'message' => 'unauthorized']);
        }

    }

    public function actionChangeStatus()
    {
        $user_id = Yii::$app->request->post('uid');
        if ($this->isAuthorized() || $user_id) {
            $class_id = Yii::$app->request->post('class_id');

            $model = OnlineClasses::find()
                ->where(['class_enc_id' => $class_id])
                ->one();

            $session = AssignedVideoSessions::find()
                ->where(['class_enc_id' => $class_id])
                ->one();

            if ($session) {
                if ($session->status == 'Active') {
                    $session->status = 'Ended';
                    $session->video_session_end_time = date('y-m-d H:i:s');
                    $session->update();
                }
            }

            if ($model) {
                if ($model->status == 'Active') {
                    $model->status = "Ended";
                    if ($model->update()) {
                        return $this->response(200, ['status' => 200, 'message' => 'status changed']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                } else {
                    return $this->response(409, ['status' => 409, 'message' => 'conflict']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSaveComment()
    {
        if ($user = $this->isAuthorized()) {
            $model = new ClassComments();
            if ($model->load(Yii::$app->request->post(), '')) {
                if ($model->validate()) {
                    if ($model->saveComment($user->user_enc_id)) {
                        return $this->response(200, ['status' => 200, 'message' => 'saved']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                } else {
                    print_r($model->getErrors());
                }
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'data not loading']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetParentComments()
    {

        if ($this->isAuthorized()) {

            $class_id = Yii::$app->request->post('class_id');
            $limit = Yii::$app->request->post('limit');
            $page = Yii::$app->request->post('page');

            if (!$limit) {
                $limit = 4;
            }

            if (!$page) {
                $page = 1;
            }

            $comments = OnlineClassComments::find()
                ->alias('a')
                ->distinct()
                ->select(['a.comment_enc_id', 'a.comment', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END image'])
                ->joinWith(['userEnc b'], false)
                ->joinWith(['onlineClassComments c' => function ($c) {
                    $c->select(['c.reply_to', 'c.comment_enc_id', 'c.comment', 'bb.username', 'CONCAT(bb.first_name, " ", bb.last_name) name', 'bb.initials_color color', 'CASE WHEN bb.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", bb.image_location, "/", bb.image) ELSE NULL END image']);
                    $c->joinWith(['userEnc bb'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['a.reply_to' => NULL])
                ->andWhere(['a.class_enc_id' => $class_id])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['a.created_on' => SORT_ASC])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            $i = 0;
            foreach ($comments as $r) {
                $a = OnlineClassComments::find()
                    ->where(['reply_to' => $r['comment_enc_id']])
                    ->andWhere(['class_enc_id' => $class_id])
                    ->andWhere(['is_deleted' => 0])
                    ->exists();
                if ($a) {
                    $comments[$i]['hasChild'] = true;
                } else {
                    $comments[$i]['hasChild'] = false;
                }
                $i++;
            }

            if ($comments) {
                return $this->response(200, ['status' => 200, 'comments' => $comments]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetChildComments()
    {
        if ($this->isAuthorized()) {

            $parent = Yii::$app->request->post('comment_enc_id');

            if (!$parent) {
                return $this->response(422, ['status' => 422, 'message' => 'missing data']);
            }

            $limit = Yii::$app->request->post('limit');
            $page = Yii::$app->request->post('page');

            if (!$limit) {
                $limit = 4;
            }

            if (!$page) {
                $page = 1;
            }

            $child_comment = OnlineClassComments::find()
                ->alias('a')
                ->select(['a.comment_enc_id', 'a.comment', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END img'])
                ->joinWith(['userEnc b'], false)
                ->where(['a.reply_to' => $parent])
                ->andWhere(['a.is_deleted' => 0])
//                ->orderBy(['a.created_on' => SORT_DESC])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            if ($child_comment) {
                return $this->response(200, ['status' => 200, 'child_comment' => $child_comment]);
            } else {
                return $this->response(404, ['status' => 404, 'mesasge' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionChangeVisibility()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['comment_enc_id']) && !empty($params['comment_enc_id'])) {
                $comment_id = $params['comment_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['value'])) {
                if ($params['value'] == 1) {
                    $value = 1;
                } elseif ($params['value'] == 0) {
                    $value = 0;
                }
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $comment = OnlineClassComments::find()
                ->where(['comment_enc_id' => $comment_id, 'is_deleted' => 0, 'status' => 1])
                ->one();

            if ($comment) {
                $comment->is_visible = $value;
                $comment->updated_on = date('Y-m-d H:i:s');
                $comment->updated_by = $user->user_enc_id;

                if ($comment->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'updated']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetStudentComment()
    {
        if ($user = $this->isAuthorized()) {

            $class_id = Yii::$app->request->post('class_id');
            $limit = Yii::$app->request->post('limit');
            $page = Yii::$app->request->post('page');

            if (!$limit) {
                $limit = 4;
            }

            if (!$page) {
                $page = 1;
            }

            $comments = OnlineClassComments::find()
                ->alias('a')
                ->distinct()
                ->select(['a.comment_enc_id', 'a.comment', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END image'])
                ->joinWith(['userEnc b'], false)
                ->joinWith(['onlineClassComments c' => function ($c) {
                    $c->select(['c.reply_to', 'c.comment_enc_id', 'c.comment', 'bb.username', 'CONCAT(bb.first_name, " ", bb.last_name) name', 'bb.initials_color color', 'CASE WHEN bb.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", bb.image_location, "/", bb.image) ELSE NULL END image']);
                    $c->joinWith(['userEnc bb'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['a.reply_to' => NULL])
                ->andWhere(['a.class_enc_id' => $class_id])
                ->andWhere(['a.is_deleted' => 0])
                ->andWhere(['or',
                    ['a.user_enc_id' => $user->user_enc_id],
                    ['a.is_visible' => 1]
                ])
                ->orderBy(['a.created_on' => SORT_ASC])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            $i = 0;
            foreach ($comments as $r) {
                $a = OnlineClassComments::find()
                    ->where(['reply_to' => $r['comment_enc_id']])
                    ->andWhere(['class_enc_id' => $class_id])
                    ->andWhere(['is_deleted' => 0])
                    ->exists();
                if ($a) {
                    $comments[$i]['hasChild'] = true;
                } else {
                    $comments[$i]['hasChild'] = false;
                }
                $i++;
            }

            if ($comments) {
                return $this->response(200, ['status' => 200, 'comments' => $comments]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUploadNotes()
    {
        if ($user = $this->isAuthorized()) {

            $class_id = Yii::$app->request->post('class_id');
            $notesModel = new UploadNotes();
            $notesModel->notes = UploadedFile::getInstancesByName('files');
            if ($notesModel->notes && $notesModel->validate()) {
                if ($note_ids = $notesModel->upload($class_id, $user->user_enc_id)) {

                    $notes = ClassNotes::find()
                        ->select(['title', 'note'])
                        ->where(['class_enc_id' => $class_id, 'is_deleted' => 0, 'note_enc_id' => $note_ids])
                        ->asArray()
                        ->all();

                    $i = 0;
                    foreach ($notes as $n) {
                        $link = $this->getFile($n['note']);
                        $notes[$i]['link'] = $link;
                        $i++;
                    }

                    return $this->response(200, ['status' => 200, 'data' => $notes]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function getFile($file_name)
    {
        $bucketName = 'mec-uploads';
        $access_key = 'AKIATDLKTDI76APKFGXO';
        $secret_key = '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';
        $s3 = new S3Client([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => $access_key,
                'secret' => $secret_key,
            ]
        ]);

        $url = $s3->getObjectUrl($bucketName, 'online_class_notes/' . $file_name);
        return $url;

    }

    public function actionGetNotes()
    {
        if ($user = $this->isAuthorized()) {

            $class_id = Yii::$app->request->post('class_enc_id');
            $notes = ClassNotes::find()
                ->select(['title', 'note'])
                ->where(['class_enc_id' => $class_id, 'is_deleted' => 0])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($notes as $n) {
                $link = $this->getFile($n['note']);
                $notes[$i]['link'] = $link;
                $i++;
            }
            if ($notes) {
                return $this->response(200, ['status' => 200, 'data' => $notes]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionClassStatus()
    {
        if ($user = $this->isAuthorized()) {

            $class_id = Yii::$app->request->post('class_enc_id');
            $status = OnlineClasses::find()
                ->select(['status'])
                ->where(['is_deleted' => 0, 'class_id' => $class_id])
                ->asArray()
                ->one();

            if ($status) {
                return $this->response(200, ['status' => 200, 'data' => $status]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAllNotes()
    {
        if ($user = $this->isAuthorized()) {
            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $date_now = $dt->format('y-m-d');
            $time_now = $dt->format('H:i:s');
            $teacher_id = $this->getTeacherId();

            $classes = OnlineClasses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.class_enc_id', 'a.status', 'bb.course_name', 'a.subject_name', 'a.start_time', 'a.end_time', 'a.class_date'])
                ->joinWith(['assignedCollegeEnc b'=>function($d){
                    $d->joinWith(['courseEnc bb']);
                }], false)
                ->joinWith(['sectionEnc c'], false)
                ->innerJoinWith(['classNotes n' => function ($n) {
                    $n->select(['n.class_enc_id', 'n.note_enc_id', 'n.note', 'n.title']);
                    $n->onCondition(['n.is_deleted' => 0]);
                }])
                ->where(['a.teacher_enc_id' => $teacher_id, 'a.is_deleted' => 0])
                ->andWhere(['<', 'a.class_date', $date_now])
                ->andWhere(['<=', 'a.end_time', $time_now])
                ->orderBy(['a.class_date' => SORT_ASC, 'a.start_time' => SORT_ASC])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($classes as $c) {
                if ($c['classNotes']) {
                    $j = 0;
                    foreach ($c['classNotes'] as $n) {
                        $link = $this->getFile($n['note']);
                        $classes[$i]['classNotes'][$j]['link'] = $link;
                        $j++;
                    }
                }
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

}