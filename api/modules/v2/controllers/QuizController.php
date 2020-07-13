<?php


namespace api\modules\v2\controllers;

use common\models\CollegeCourses;
use common\models\MockAssignedQuizPool;
use common\models\MockLabelPool;
use common\models\MockLabels;
use common\models\MockLevels;
use common\models\MockQuizAnswersPool;
use common\models\MockQuizPool;
use common\models\MockQuizQuestionsPool;
use common\models\MockQuizzes;
use common\models\Users;
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
                        'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
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
                        'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
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
        $data = Yii::$app->request->post();
        if (!empty($data) && !empty($data->pools)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($user = $this->isAuthorized()) {
                    $quizModel = new MockQuizzes();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $quizModel->quiz_enc_id = $utilitiesModel->encrypt();
                    $quizModel->name = $data->name;
                    $quizModel->total_questions = $data->total_ques;
                    if ($data->ques_marks) {
                        $quizModel->per_ques_marks = $data->ques_marks;
                        $data->whole_marks = $data->ques_marks * $data->total_ques;
                    }
                    $quizModel->total_marks = $data->whole_marks;
                    if ($data->ques_time) {
                        $quizModel->per_ques_time = $data->ques_time;
                        $data->whole_time = $data->ques_time * $data->total_ques;
                    }
                    $quizModel->total_time = $data->whole_time;
                    if ($data->is_nagetive_marking) {
                        $quizModel->negetive_marks = $data->nagetive_marks;
                    }
                    $utilitiesModel->variables['name'] = $data->name;
                    $utilitiesModel->variables['table_name'] = MockQuizzes::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $quizModel->slug = $utilitiesModel->create_slug();
                    if ($data->class && $data->section) {
                        $level_id = MockLevels::findOne(['assigned_to' => $data->type, 'name' => 'Class'])['level_enc_id'];
                        if (!$level_id) {
                            $level_id = MockLevels::findOne(['assigned_to' => $data->type, 'name' => 'Course'])['level_enc_id'];
                        }
                        $label_id = MockLabels::findOne(['level_enc_id' => $level_id, 'poolEnc.name' => $data->class])['label_enc_id'];
                        $quizModel->for_sections = implode(",", $data->section);
                    }
                    $quizModel->label_enc_id = $label_id;
                    $quizModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$quizModel->validate() || !$quizModel->save()) {
                        $transaction->rollBack();
                        return $this->response(401, ['status' => 500, 'message' => 'Error Occured...']);
                    }
                    foreach ($data->pools as $pool) {
                        $assignedPoolModel = new MockAssignedQuizPool();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $assignedPoolModel->assigned_quiz_pool_enc_id = $utilitiesModel->encrypt();
                        $assignedPoolModel->quiz_enc_id = $quizModel->quiz_enc_id;
                        $assignedPoolModel->quiz_pool_enc_id = $pool;
                        $assignedPoolModel->min = $data->min;
                        $assignedPoolModel->max = $data->max;
                        if (!$assignedPoolModel->save() || !$assignedPoolModel->validate()) {
                            $transaction->rollBack();
                            return $this->response(500, ['status' => 500, 'message' => 'Error Occured...']);
                        }
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'Saved Successfully..']);
                } else {
                    return $this->response(500, ['status' => 401, 'message' => 'unauthorized']);
                }
            } catch (yii\db\Exception $exception) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'Database Exception']);
            }
        }
    }
}