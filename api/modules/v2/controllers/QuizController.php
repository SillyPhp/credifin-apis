<?php


namespace api\modules\v2\controllers;

use common\models\AssignedCollegeCourses;
use common\models\Categories;
use common\models\CollegeSections;
use common\models\extended\Quiz;
use common\models\MockAssignedQuizPool;
use common\models\MockLabelPool;
use common\models\MockLabels;
use common\models\MockLevels;
use common\models\MockQuizAnswersPool;
use common\models\MockQuizPool;
use common\models\MockQuizQuestionsPool;
use common\models\MockQuizzes;
use common\models\MockTakenQuizQuestions;
use common\models\MockTakenQuizzes;
use common\models\QuizPayments;
use common\models\QuizRegistration;
use common\models\UserOtherDetails;
use common\models\Users;
use yii\db\Expression;
use Yii;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class QuizController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'levels' => ['POST', 'OPTIONS'],
                'add-labels' => ['POST', 'OPTIONS'],
                'add-level' => ['POST', 'OPTIONS'],
                'add-question-pool' => ['POST', 'OPTIONS'],
                'remove-question' => ['POST', 'OPTIONS'],
                'get-pools' => ['POST', 'OPTIONS'],
                'detail' => ['POST', 'OPTIONS'],
                'list' => ['POST', 'OPTIONS'],
                'register' => ['POST', 'OPTIONS'],
                'update-payment-status' => ['POST', 'OPTIONS'],
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

    private function getOrgId()
    {
        if ($user = $this->isAuthorized()) {

            $user_type = Users::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            if ($user_type['organization_enc_id']) {
                $organizations = Users::find()
                    ->alias('a')
                    ->select(['b.name', 'b.phone', 'b.email', 'b.organization_enc_id college_id', 'c.code referral_code',
                        'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
                    ->joinWith(['organizationEnc b' => function ($b) {
                        $b->joinWith(['referrals c'], false);
                    }], false)
                    ->where(['a.user_enc_id' => $user->user_enc_id])
                    ->asArray()
                    ->one();

                return $organizations['college_id'];
            } else {
                $organizations = Users::find()
                    ->alias('a')
                    ->select(['b.name', 'b.phone', 'b.email', 'b.organization_enc_id college_id', 'c.code referral_code',
                        'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
                    ->joinWith(['teachers cc' => function ($cc) {
                        $cc->joinWith(['collegeEnc b' => function ($b) {
                            $b->joinWith(['referrals c'], false);
                        }], false);
                    }], false)
                    ->where(['a.user_enc_id' => $user->user_enc_id])
                    ->asArray()
                    ->one();

                return $organizations['college_id'];
            }
        }
    }

    private function getStudentOrgId()
    {
        if ($user = $this->isAuthorized()) {
            $org_id = UserOtherDetails::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            return $org_id;
        }
    }

    public function actionLevels()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['type']) && !empty($params['type'])) {
                $type = $params['type'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['sequence']) && !empty($params['sequence'])) {
                $sequence = $params['sequence'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['parent_enc_id']) && !empty($params['parent_enc_id'])) {
                $parent_id = $params['parent_enc_id'];
            } else {
                $parent_id = null;
            }

            $levels = MockLevels::find()
                ->select(['level_enc_id', 'name', 'sequence', 'assigned_to'])
                ->where(['assigned_to' => $type, 'sequence' => $sequence])
                ->asArray()
                ->one();

            if ($levels) {
                $label = MockLabels::find()
                    ->alias('a')
                    ->select(['a.label_enc_id', 'a.pool_enc_id', 'a.level_enc_id', 'a.parent_enc_id', 'b.name'])
                    ->joinWith(['poolEnc b'], false)
                    ->where(['a.parent_enc_id' => $parent_id, 'a.is_deleted' => 0, 'a.level_enc_id' => $levels['level_enc_id']])
                    ->asArray()
                    ->all();
                $levels['mockLabels'] = $label;
                $levels['parent_enc_id'] = $parent_id;
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            if ($levels) {
                return $this->response(200, ['status' => 200, 'data' => $levels]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddLabels()
    {
        if ($user = $this->isAuthorized()) {

            $param = Yii::$app->request->post();

            if (isset($param['level_enc_id']) && !empty($param['level_enc_id'])) {
                $level_enc_id = $param['level_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($param['label']) && !empty($param['label'])) {
                $label = $param['label'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $parent_id = $param['parent_enc_id'];

            $label_pool_data = MockLabelPool::find()
                ->where(['name' => $label])
                ->one();

            if ($label_pool_data) {
                $mock_labels = new MockLabels();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $mock_labels->label_enc_id = $utilitiesModel->encrypt();
                $mock_labels->pool_enc_id = $label_pool_data->pool_enc_id;
                if (!empty($parent_id)) {
                    $mock_labels->parent_enc_id = $parent_id;
                }
                $mock_labels->level_enc_id = $level_enc_id;
                $mock_labels->created_by = $user->user_enc_id;
                $mock_labels->created_on = date('Y-m-d H:i:s');
                if ($mock_labels->save()) {
                    $data = [];
                    $data['label'] = $label;
                    $data['label_enc_id'] = $mock_labels->label_enc_id;
                    return $this->response(200, ['status' => 200, 'data' => $data]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            } else {

                $label_pool = new MockLabelPool();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $label_pool->pool_enc_id = $utilitiesModel->encrypt();
                $label_pool->name = $label;
                $label_pool->created_on = date('Y-m-d H:i:s');
                $label_pool->created_by = $user->user_enc_id;
                if ($label_pool->save()) {
                    $mock_labels = new MockLabels();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $mock_labels->label_enc_id = $utilitiesModel->encrypt();
                    $mock_labels->pool_enc_id = $label_pool->pool_enc_id;
                    if (!empty($parent_id)) {
                        $mock_labels->parent_enc_id = $parent_id;
                    }
                    $mock_labels->level_enc_id = $level_enc_id;
                    $mock_labels->created_by = $user->user_enc_id;
                    $mock_labels->created_on = date('Y-m-d H:i:s');
                    if ($mock_labels->save()) {
                        $data = [];
                        $data['label'] = $label;
                        $data['label_enc_id'] = $mock_labels->label_enc_id;
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddLevel()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['name']) && !empty($params['name'])) {
                $name = $params['name'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['sequence']) && !empty($params['sequence'])) {
                $sequence = $params['sequence'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['type']) && !empty($params['type'])) {
                $type = $params['type'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $add_level = new MockLevels();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $add_level->level_enc_id = $utilitiesModel->encrypt();
            $add_level->name = $name;
            $add_level->sequence = $sequence;
            $add_level->assigned_to = $type;
            $add_level->created_by = $user->user_enc_id;
            $add_level->created_on = date('Y-m-d H:i:s');
            if ($add_level->save()) {
                $data = [];
                $data['level_enc_id'] = $add_level->level_enc_id;
                $data['name'] = $add_level->name;
                $data['sequence'] = $add_level->sequence;
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddQuestionPool()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['name']) && !empty($params['name'])) {
                $name = $params['name'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['organization_enc_id']) && !empty($params['organization_enc_id'])) {
                $organization_enc_id = $params['organization_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['label_enc_id']) && !empty($params['label_enc_id'])) {
                $label_enc_id = $params['label_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $quiz_pool_enc_id = $params['quiz_pool_enc_id'];
            $question = $params['question'];
            $answers = $params['answers'];
            $keywords = $params['keywords'];
            $description = $params['description'];

            if (empty($quiz_pool_enc_id)) {
                $quiz_pool = new MockQuizPool();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $quiz_pool->quiz_pool_enc_id = $utilitiesModel->encrypt();
                $quiz_pool->label_enc_id = $label_enc_id;
                $quiz_pool->name = $name;
                $quiz_pool->organization_enc_id = $organization_enc_id;
                $quiz_pool->keywords = $keywords;
                $quiz_pool->description = $description;
                $quiz_pool->created_on = date('Y-m-d H:i:s');
                $quiz_pool->created_by = $user->user_enc_id;
                if ($quiz_pool->save()) {
                    $question_pool = new MockQuizQuestionsPool();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $question_pool->quiz_question_pool_enc_id = $utilitiesModel->encrypt();
                    $question_pool->quiz_pool_enc_id = $quiz_pool->quiz_pool_enc_id;
                    $question_pool->question = $question;
                    $question_pool->created_by = $user->user_enc_id;
                    $question_pool->created_on = date('Y-m-d H:i:s');
                    if ($question_pool->save()) {
                        foreach ($answers as $a) {
                            $answers_pool = new MockQuizAnswersPool();
                            $utilitiesModel = new \common\models\Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $answers_pool->quiz_answer_pool_enc_id = $utilitiesModel->encrypt();;
                            $answers_pool->quiz_question_pool_enc_id = $question_pool->quiz_question_pool_enc_id;
                            $answers_pool->answer = $a['answer'];
                            $answers_pool->is_answer = $a['is_answer'];
                            $answers_pool->save();
                        }
                        $data = [];
                        $data['quiz_pool_enc_id'] = $quiz_pool->quiz_pool_enc_id;
                        $data['question_enc_id'] = $question_pool->quiz_question_pool_enc_id;
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            } else {
                $question_pool = new MockQuizQuestionsPool();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $question_pool->quiz_question_pool_enc_id = $utilitiesModel->encrypt();
                $question_pool->quiz_pool_enc_id = $quiz_pool_enc_id;
                $question_pool->question = $question;
                $question_pool->created_by = $user->user_enc_id;
                $question_pool->created_on = date('Y-m-d H:i:s');
                if ($question_pool->save()) {
                    foreach ($answers as $a) {
                        $answers_pool = new MockQuizAnswersPool();
                        $utilitiesModel = new \common\models\Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $answers_pool->quiz_answer_pool_enc_id = $utilitiesModel->encrypt();
                        $answers_pool->quiz_question_pool_enc_id = $question_pool->quiz_question_pool_enc_id;
                        $answers_pool->answer = $a['answer'];
                        $answers_pool->is_answer = $a['is_answer'];
                        $answers_pool->save();
                    }
                    $data = [];
                    $data['quiz_pool_enc_id'] = $quiz_pool_enc_id;
                    $data['question_enc_id'] = $question_pool->quiz_question_pool_enc_id;
                    return $this->response(200, ['status' => 200, 'data' => $data]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveQuestion()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['question_enc_id']) && $params['question_enc_id']) {
                $question_id = $params['question_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $question = MockQuizQuestionsPool::find()
                ->where(['quiz_question_pool_enc_id' => $question_id])
                ->one();
            if ($question) {
                $question->is_deleted = 1;
                $question->last_updated_on = date('Y-m-d H:i:s');
                $question->last_updated_by = $user->user_enc_id;
                if (!$question->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }
            return $this->response(200, ['status' => 200, 'message' => 'deleted']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetPools()
    {
        if ($user = $this->isAuthorized()) {
            $org_id = $this->getOrgId();
            $pools = MockQuizPool::find()
                ->alias('a')
                ->select([
                    'a.quiz_pool_enc_id',
                    'a.label_enc_id',
                    'a.organization_enc_id',
                    'a.name',
                    'a.keywords',
                    'a.description',
                ])
                ->andWhere(['or',
                    ['a.organization_enc_id' => $org_id],
                    ['a.organization_enc_id' => null]
                ])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($pools as $p) {
                $pool_questions_count = MockQuizQuestionsPool::find()
                    ->where(['quiz_pool_enc_id' => $p['quiz_pool_enc_id']])
                    ->count();
                $pools[$i]['question_count'] = $pool_questions_count;
                $i++;
            }

            if ($pools) {
                return $this->response(200, ['status' => 200, 'data' => $pools]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionCreateQuiz()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post();
            if (!empty($data) && !empty($data['pools'])) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $quizModel = new MockQuizzes();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $quizModel->quiz_enc_id = $utilitiesModel->encrypt();
                    $quizModel->name = $data['name'];
                    $quizModel->total_questions = $data['total_ques'];
                    if ($data['marks_type'] == 1) {
                        $quizModel->per_ques_marks = $data['marks'];
                        $quizModel->total_marks = $data['marks'] * $data['total_ques'];
                    } elseif ($data['marks_type'] == 0) {
                        $quizModel->total_marks = $data['marks'];
                    }
                    if ($data['duration_type'] == 0) {
                        $quizModel->total_time = $data['duration'];
                        $quizModel->per_ques_time = $data['duration'] * $data['total_ques'];
                    } else if ($data['duration_type'] == 1) {
                        $quizModel->per_ques_time = $data['duration'];
                    }
                    if ($data['is_nagetive_marking']) {
                        $quizModel->negative_marks = $data['nagetive_marks'];
                    }
                    $utilitiesModel->variables['name'] = $data['name'];
                    $utilitiesModel->variables['table_name'] = MockQuizzes::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $quizModel->slug = $utilitiesModel->create_slug();
                    $quizModel->for_sections = implode(",", $data['sections']);
                    $quizModel->assigned_college_enc_id = $data['class'];
//                    $quizModel->label_enc_id = $data->label_id;
                    $quizModel->created_by = $user->user_enc_id;
                    if (!$quizModel->validate() || !$quizModel->save()) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'Error Occurred...']);
                    }
                    foreach ($data['pools'] as $pool) {
                        $assignedPoolModel = new MockAssignedQuizPool();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $assignedPoolModel->assigned_quiz_pool_enc_id = $utilitiesModel->encrypt();
                        $assignedPoolModel->quiz_enc_id = $quizModel->quiz_enc_id;
                        $assignedPoolModel->quiz_pool_enc_id = $pool;
                        $assignedPoolModel->min = $data['min'];
                        $assignedPoolModel->max = $data['max'];
                        if (!$assignedPoolModel->save() || !$assignedPoolModel->validate()) {
                            $transaction->rollBack();
                            return $this->response(500, ['status' => 500, 'message' => 'Error Occured...']);
                        }
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'Saved Successfully..']);
                } catch (yii\db\Exception $exception) {
                    $transaction->rollBack();
                    return $this->response(500, ['status' => 500, 'message' => 'Database Exception']);
                }
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionCourses()
    {
        if ($this->isAuthorized()) {
            $college_id = $this->getOrgId();

            $courses = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['courseEnc c'], false)
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0])
//                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'courses' => $courses]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetQuizzes()
    {
        if ($user = $this->isAuthorized()) {
            $student_org_data = $this->getStudentOrgId();
            $class_id = $student_org_data['course_enc_id'];

            $section = CollegeSections::find()
                ->where(['section_enc_id' => $student_org_data['section_enc_id']])
                ->asArray()
                ->one();

            $quizzes = MockQuizzes::find()
                ->select([
                    'quiz_enc_id',
                    'name',
                    'slug',
                    'total_marks',
                    'per_ques_marks',
                    'per_ques_time',
                    'total_time',
                    'negative_marks',
                    'total_questions',
                    'for_sections'
                ])
                ->where(['is_deleted' => 0, 'assigned_college_enc_id' => $class_id])
                ->asArray()
                ->all();

            $i = 0;
            $data = [];
            foreach ($quizzes as $q) {

                if ($q['for_sections'] != null) {
                    $sections = explode(',', $q['for_sections']);
                    if (in_array($section['section_name'], $sections)) {
                        array_push($data, $quizzes[$i]);
                    }
                } else {
                    if ($section['section_name'] == $q['for_sections']) {
                        array_push($data, $quizzes[$i]);
                    }
                }

                $i++;
            }

            $j = 0;
            foreach ($data as $d) {
                $is_played = MockTakenQuizzes::find()
                    ->alias('a')
                    ->select(['a.taken_quiz_enc_id', 'a.total_marks', 'a.obtained_marks'])
                    ->joinWith(['mockTakenQuizQuestions b'], false)
                    ->where(['a.user_enc_id' => $user->user_enc_id, 'a.quiz_enc_id' => $d['quiz_enc_id']])
                    ->asArray()
                    ->one();
                if ($is_played) {
                    $data[$j]['is_played'] = true;
//                    $data[$j]['total_marks'] = $is_played['total_marks'];
                    $data[$j]['obtained_marks'] = $is_played['obtained_marks'];
//                    $data[$j]['time_taken'] = $is_played['time_taken'];
                } else {
                    $data[$j]['is_played'] = false;
                }

                $j++;
            }

            if ($data) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }


        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionPlayQuiz()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['quiz_enc_id']) && !empty($params['quiz_enc_id'])) {
                $quiz_enc_id = $params['quiz_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => '']);
            }

            $is_played = MockTakenQuizzes::find()
                ->where(['user_enc_id' => $user->user_enc_id, 'quiz_enc_id' => $quiz_enc_id])
                ->exists();

            if ($is_played) {
                return $this->response(409, ['status' => 409, 'message' => 'already played or not accessible']);
            }

            $quiz = MockQuizzes::find()
                ->alias('a')
                ->joinWith(['mockAssignedQuizPools'])
                ->where(['a.quiz_enc_id' => $quiz_enc_id, 'a.is_deleted' => 0])
                ->asArray()
                ->one();

            $pools_count = count($quiz['mockAssignedQuizPools']);
            $question_count = $quiz['total_questions'] / $pools_count;

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $save_quiz = new MockTakenQuizzes();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $save_quiz->taken_quiz_enc_id = $utilitiesModel->encrypt();
                $save_quiz->quiz_enc_id = $quiz_enc_id;
                $save_quiz->user_enc_id = $user->user_enc_id;
                $save_quiz->total_marks = $quiz['total_marks'];
                if ($quiz['per_ques_marks'] != null) {
                    $save_quiz->marks_per_question = $quiz['per_ques_marks'];
                } else {
                    $save_quiz->marks_per_question = $quiz['total_marks'] / $quiz['total_questions'];
                }
                $save_quiz->negative_marks = $quiz['negative_marks'];
                $save_quiz->total_time = $quiz['total_time'];
                $save_quiz->total_questions = $quiz['total_questions'];
                if ($save_quiz->save()) {
                    foreach ($quiz['mockAssignedQuizPools'] as $q) {
                        $questions = $this->getQuestions($q['quiz_pool_enc_id'], (int)$question_count);
                        foreach ($questions as $ques) {
                            $questions = new MockTakenQuizQuestions();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $questions->taken_question_enc_id = $utilitiesModel->encrypt();
                            $questions->taken_quiz_enc_id = $save_quiz->taken_quiz_enc_id;
                            $questions->quiz_question_pool_enc_id = $ques['quiz_question_pool_enc_id'];
                            $questions->created_on = date('Y-m-d H:i:s');
                            if (!$questions->save()) {
                                $transaction->rollBack();
                            }
                        }
                    }
                } else {
                    $transaction->rollBack();
                }
                $transaction->commit();
                $taken_quiz = MockTakenQuizzes::find()
                    ->alias('a')
                    ->joinWith(['mockTakenQuizQuestions b'])
                    ->where(['a.quiz_enc_id' => $quiz_enc_id, 'a.user_enc_id' => $user->user_enc_id])
                    ->one();
                $data = [];
                $data['total_time'] = $quiz['total_time'];
                $data['per_question_time'] = $quiz['per_ques_time'];
                $data['count'] = count($taken_quiz['mockTakenQuizQuestions']);
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } catch (yii\db\Exception $exception) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'Database Exception']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function getQuestions($quiz_pool_enc_id, $question_count)
    {
        $questions = MockQuizQuestionsPool::find()
            ->where(['quiz_pool_enc_id' => $quiz_pool_enc_id])
            ->orderBy(new Expression('rand()'))
            ->limit($question_count)
            ->asArray()
            ->all();

        return $questions;
    }

    public function actionGetQuestion()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();
            $quiz_enc_id = $params['quiz_enc_id'];
            $taken_question_enc_id = $params['taken_question_enc_id'];
            $quiz_answer_pool_enc_id = $params['quiz_answer_pool_enc_id'];
            $taken_time = $params['taken_time'];
            $offset = $params['question_number'];

            if (!empty($quiz_enc_id) && !empty($taken_question_enc_id) && !empty($taken_time)) {
                if ($quiz_answer_pool_enc_id != '') {
                    $correct_answer = MockQuizAnswersPool::find()
                        ->where(['quiz_answer_pool_enc_id' => $quiz_answer_pool_enc_id])
                        ->asArray()
                        ->one();
                }

                $taken_quiz = MockTakenQuizzes::find()
                    ->where(['quiz_enc_id' => $quiz_enc_id, 'user_enc_id' => $user->user_enc_id])
                    ->one();

                $quiz = MockQuizzes::find()
                    ->where(['quiz_enc_id' => $quiz_enc_id])
                    ->asArray()
                    ->one();

                if ($quiz_answer_pool_enc_id != '') {
                    if ($correct_answer && $taken_quiz) {
                        if ($correct_answer['is_answer'] == 1) {
                            $taken_quiz->obtained_marks = $taken_quiz->obtained_marks + $taken_quiz->marks_per_question;
                        } elseif ($correct_answer['is_answer'] == 0) {
                            if ($quiz['negative_marks'] != null) {
                                $taken_quiz->obtained_negative_marks = $taken_quiz->obtained_negative_marks + $taken_quiz->negative_marks;
                            }
                        }
                        $taken_quiz->updated_on = date('Y-m-d H:i:s');
                        $taken_quiz->update();
                    }
                }


                $save_answer = MockTakenQuizQuestions::find()
                    ->where(['taken_question_enc_id' => $taken_question_enc_id])
                    ->one();

                if ($save_answer) {
                    if ($quiz_answer_pool_enc_id != '') {
                        $save_answer->quiz_answer_pool_enc_id = $quiz_answer_pool_enc_id;
                        $save_answer->is_correct = $correct_answer['is_answer'];
                    }
                    $save_answer->time_taken = $taken_time;
                    $save_answer->updated_on = date('Y-m-d H:i:s');
                    if (!$save_answer->update()) {
                        return $this->response(500, ['status' => 500, 'message' => 'en error occurred']);
                    }
                }

                $play_question = $this->que($taken_quiz, $offset);

                if ($play_question) {
                    return $this->response(200, ['status' => 200, 'data' => $play_question]);
                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }

            } else {

                $taken_quiz = MockTakenQuizzes::find()
                    ->where(['quiz_enc_id' => $quiz_enc_id, 'user_enc_id' => $user->user_enc_id])
                    ->one();

                $play_question = $this->que($taken_quiz, $offset);

                if ($play_question) {
                    return $this->response(200, ['status' => 200, 'data' => $play_question]);
                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

    }

    private function que($taken_quiz, $offset)
    {
        if ($user = $this->isAuthorized()) {
            $play_question = MockTakenQuizQuestions::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.taken_question_enc_id',
                    'a.taken_quiz_enc_id',
                    'a.quiz_question_pool_enc_id'
                ])
                ->joinWith(['takenQuizEnc b'], false)
                ->joinWith(['quizQuestionPoolEnc c' => function ($c) {
                    $c->select(['c.quiz_question_pool_enc_id', 'c.question']);
                    $c->joinWith(['mockQuizAnswersPools c1' => function ($c1) {
                        $c1->select([
                            'c1.quiz_answer_pool_enc_id',
                            'c1.quiz_question_pool_enc_id',
                            'c1.answer'
                        ]);
                    }]);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['b.user_enc_id' => $user->user_enc_id, 'b.taken_quiz_enc_id' => $taken_quiz->taken_quiz_enc_id])
                ->limit(1)
                ->offset($offset)
                ->asArray()
                ->one();

            return $play_question;
        }
    }

    public function actionGetTeacherQuizzes()
    {
        if ($user = $this->isAuthorized()) {

            $quizzes = MockQuizzes::find()
                ->distinct()
                ->alias('a')
                ->select([
                    'a.quiz_enc_id', 'a.name', 'a.per_ques_marks', 'a.total_marks',
                    'a.per_ques_time', 'a.total_time', 'a.negative_marks', 'a.total_questions',
                    'a.for_sections', 'bb.course_name class_name'
                ])
                ->joinWith(['assignedCollegeEnc b' => function ($b) {
                    $b->joinWith(['courseEnc bb']);
                }], false)
                ->where(['a.created_by' => $user->user_enc_id, 'a.is_deleted' => 0])
                ->asArray()
                ->all();

            if ($quizzes) {
                return $this->response(200, ['status' => 200, 'data' => $quizzes]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'unauthorized']);
        }
    }

    public function actionTeacherQuizPools()
    {
        if ($user = $this->isAuthorized()) {

            $quiz_pools = MockQuizPool::find()
                ->distinct()
                ->alias('a')
                ->select(['a.quiz_pool_enc_id', 'a.label_enc_id', 'a.name', 'c.name label_name'])
                ->joinWith(['labelEnc b' => function ($b) {
                    $b->joinWith(['poolEnc c']);
                }], false)
                ->where(['a.created_by' => $user->user_enc_id])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($quiz_pools as $q) {
                $pool_questions_count = MockQuizQuestionsPool::find()
                    ->where(['quiz_pool_enc_id' => $q['quiz_pool_enc_id']])
                    ->count();
                $labels = $this->getLabels($q['label_enc_id']);

                $quiz_pools[$i]['labels'] = $labels;
                $quiz_pools[$i]['question_count'] = $pool_questions_count;
                $i++;
            }

            if ($quiz_pools) {
                return $this->response(200, ['status' => 200, 'data' => $quiz_pools]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function getLabels($label_id)
    {
        $label = MockLabels::find()
            ->distinct()
            ->alias('a')
            ->select(['a.label_enc_id', 'a.pool_enc_id', 'a.parent_enc_id', 'b.name'])
            ->joinWith(['poolEnc b'], false)
            ->where(['label_enc_id' => $label_id])
            ->asArray()
            ->one();

        if ($label) {
            $parent = $this->getLabels($label['parent_enc_id']);
            $label['parent'] = $parent;
        }

        return $label;
    }

    public function actionTeacherStats()
    {
        if ($user = $this->isAuthorized()) {
            $quiz_count = MockQuizzes::find()
                ->where(['created_by' => $user, 'is_deleted' => 0])
                ->count();

            $quiz_pool_count = MockQuizPool::find()
                ->where(['created_by' => $user])
                ->count();

            $played = MockQuizzes::find()
                ->where(['created_by' => $user, 'is_deleted' => 0])
                ->asArray()
                ->all();

            $played_count = 0;
            foreach ($played as $p) {
                $count = MockTakenQuizzes::find()
                    ->where(['quiz_enc_id' => $p['quiz_enc_id']])
                    ->count();

                $played_count += $count;
            }

            $count = [];
            $count['quiz_count'] = $quiz_count;
            $count['pools_count'] = $quiz_pool_count;
            $count['played_count'] = $played_count;
            return $this->response(200, ['status' => 200, 'data' => $count]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionDetaill()
    {
        if ($user = $this->isAuthorized()) {
            $id = Yii::$app->request->post('id');
            if ($id) {
                $detail = MockQuizzes::find()
                    ->alias('z')
                    ->select(['z.quiz_enc_id',
                        'z.label_enc_id',
                        'a1.name as label_name',
                        'z.name',
                        'z.per_ques_marks',
                        'z.total_marks',
                        'z.per_ques_time',
                        'z.total_time',
                        'z.negative_marks',
                        'z.slug',
                        'z.total_questions',
                        'z.for_sections',
                        'z.assigned_college_enc_id',
                        'cc.course_name class'
                    ])
                    ->joinWith(['labelEnc a' => function ($a) {
                        $a->joinWith(['poolEnc a1']);
                    }], false)
                    ->joinWith(['mockAssignedQuizPools b' => function ($b) {
                        $b->select(['b.assigned_quiz_pool_enc_id',
                            'b.quiz_enc_id',
                            'b.quiz_pool_enc_id',
                            'b.min',
                            'b.max',
                            'bb.name pool_name'
                        ]);
                        $b->joinWith(['quizPoolEnc bb'], false);
                    }])
                    ->joinWith(['assignedCollegeEnc c' => function ($b) {
                        $b->joinWith(['courseEnc cc']);
                    }], false)
                    ->where(['z.quiz_enc_id' => $id, 'z.is_deleted' => 0])
                    ->asArray()
                    ->one();

                if (!empty($detail['mockAssignedQuizPools'])) {
                    $detail['min'] = (int)$detail['mockAssignedQuizPools'][0]['min'];
                    $detail['max'] = (int)$detail['mockAssignedQuizPools'][0]['max'];
                }

                return $this->response(200, ['status' => 200, 'data' => $detail]);
            }
            return $this->response(403, ['status' => 403, 'message' => 'param must be required']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized ']);
        }
    }


    public function actionList()
    {
//        if ($user = $this->isAuthorized()) {

        $options = Yii::$app->request->post();

        $quizzes = Quiz::getQuizData($options);

        if ($quizzes) {
            return $this->response(200, ['status' => 200, 'message' => 'success', 'data' => $quizzes]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
//        } else {
//            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
//        }

    }

    public function actionDetail()
    {

        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "slug"']);
        }

        $options['slug'] = $params['slug'];

        if ($user = $this->isAuthorized()) {
            $options['user_id'] = $user->user_enc_id;
        }

        $quizModel = new Quiz();
        $detail = $quizModel->detail($options);
        unset($options['slug']);

        $options['category'] = $detail['category'];
        $options['limit'] = 3;
        $options['quiz_id'] = $detail['quiz_enc_id'];
        $related = Quiz::getQuizData($options);

        if ($detail) {
            return $this->response(200, ['status' => 200, 'message' => 'quiz detail', 'detail' => $detail, 'related' => $related]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionCategories()
    {
        $categories = Categories::find()
            ->alias('a')
            ->select(['a.category_enc_id', 'a.name'])
            ->innerJoinWith(['assignedCategories b' => function ($b) {
                $b->innerJoinWith(['quizzes b1']);
            }], false)
            ->where(['b1.is_deleted' => 0])
            ->groupBy('a.name')
            ->asArray()
            ->all();

        if ($categories) {
            return $this->response(200, ['status' => 200, 'categories' => $categories]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionRegister()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (!isset($params['quiz_id']) && empty($params['quiz_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "quiz_id"']);
            }

            $paid = QuizPayments::findOne(['quiz_enc_id' => $params['quiz_id'], 'payment_status' => 'captured', 'created_by' => $user->user_enc_id]);
            $registered = QuizRegistration::findOne(['quiz_enc_id' => $params['quiz_id'], 'created_by' => $user->user_enc_id, 'is_deleted' => 0]);

            if ($paid) {
                return $this->response(422, ['status' => 422, 'message' => 'User Already Paid The Amount and Registered']);
            }

            if ($registered) {
                return $this->response(422, ['status' => 422, 'message' => 'User Already Registered']);
            }

            $params['user_id'] = $user->user_enc_id;

            $quizModel = new Quiz();
            $register = $quizModel->registerUser($params);

            if ($register) {
                return $this->response(200, $register);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'some error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

    }

    public function actionUpdatePaymentStatus()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            $params['user_id'] = $user->user_enc_id;

            $quizModel = new Quiz();
            $update = $quizModel->updateStatus($params);

            if ($update) {
                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'some error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}