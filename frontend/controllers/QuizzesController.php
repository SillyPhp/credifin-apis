<?php

namespace frontend\controllers;

use common\models\AssignedCategories;
use common\models\QuizAnswersPool;
use common\models\QuizPool;
use common\models\Quizs;
use common\models\QuizSubmittedAnswers;
use common\models\Quiz;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\web\Response;

class QuizzesController extends Controller
{
    public function actionIndex($type = null){
        if ($type == null) {
            $categories = AssignedCategories::find()
                ->alias('a')
                ->select(['b.name','b.slug','CASE WHEN a.icon_png IS NULL OR a.icon_png = "" THEN "' . Url::to('@commonAssets/quiz_categories/others.png') . '" ELSE CONCAT("' . Url::to('@commonAssets/quiz_categories/') . '", a.icon_png) END icon'])
                ->joinWith(['parentEnc b'], false)
                ->innerJoinWith(['quizzes c'], false)
                ->where(['a.assigned_to'=> 'Quiz','a.status' =>'Approved', 'a.is_deleted' => 0, 'c.is_deleted'=> 0, 'c.display' => 1])
                ->groupBy(['a.assigned_category_enc_id'])
                ->asArray()
                ->all();

            $quizes = Quiz::find()
                ->alias('a')
                ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'COUNT(b.quiz_question_enc_id) cnt'])
                ->joinWith(['quizQuestions b' => function ($x) {
                    $x->onCondition([
                        'b.is_deleted' => 0
                    ]);
                    $x->groupBy(['b.quiz_enc_id']);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 1,
                    'a.display' => 1
                ])
                ->asArray()
                ->all();
            return $this->render('quiz-landing-page', [
                'data' => $categories,
                'quiz' => $quizes
            ]);
        } else {
            $quizes = Quiz::find()
                ->alias('a')
                ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'COUNT(b.quiz_question_enc_id) cnt', 'd.name category_name', 'CONCAT("' . Url::to('@commonAssets/categories/svg/') . '", d.icon) icon'])
                ->joinWith(['quizQuestions b' => function ($x) {
                    $x->onCondition([
                        'b.is_deleted' => 0
                    ]);
                    $x->groupBy(['b.quiz_enc_id']);
                }], false)
                ->joinWith(['assignedCategoryEnc c' => function ($x) {
                    $x->joinWith(['parentEnc d']);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                    'a.display' => 1,
                    'd.slug' => $type
                ])
                ->asArray()
                ->all();
            return $this->render('all-quiz', [
                'data' => $quizes
            ]);
        }
    }

    public function actionAll(){
        $quizes = Quiz::find()
            ->alias('a')
            ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'COUNT(b.quiz_question_enc_id) cnt'])
            ->joinWith(['quizQuestions b' => function ($x) {
                $x->onCondition([
                    'b.is_deleted' => 0
                ]);
                $x->groupBy(['b.quiz_enc_id']);
            }], false)
            ->where([
                'a.display' => 1,
                'a.is_deleted' => 0
            ])
            ->asArray()
            ->all();

        return $this->render('all', [
            'data' => $quizes
        ]);
    }

    public function actionDetail($slug, $s = NULL, $t = NULL)
    {
        $temp = Quizs::find()
            ->alias('a')
            ->where([
                'a.slug' => $slug,
                'a.status' => 1,
                'a.is_deleted' => 0
            ])
            ->asArray()
            ->one();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($temp['template'] == 6) {
                $data = Yii::$app->request->post();
                $quizSubmittedAnsers = new QuizSubmittedAnswers();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $quizSubmittedAnsers->quiz_submitted_answers_enc_id = $utilitiesModel->encrypt();
                $quizSubmittedAnsers->quiz_question_pool_enc_id = $data['question'];
                $quizSubmittedAnsers->answer_enc_id = $data['ans'];
                $quizSubmittedAnsers->user_enc_id = Yii::$app->user->identity->user_enc_id;
                $quizSubmittedAnsers->quiz_slug = $slug;
                $checkAns = QuizAnswersPool::find()
                    ->select(['is_answer'])
                    ->where(['quiz_answer_pool_enc_id' => $data['ans']])
                    ->one();
                $quizSubmittedAnsers->is_correct = $checkAns['is_answer'];
                if (!$quizSubmittedAnsers->save()) {
                    return false;
                }

                $submittedQuestions = $this->_getPreviousQuestions($slug);
                $newQuestion = $this->_getQuestion($submittedQuestions, $slug);
                if ($newQuestion) {
                    return $response = [
                        'status' => 200,
                        'message' => 'Success',
                        'question' => $newQuestion,
                    ];
                } else {
                    $result = $this->_getQuizResult($slug);
                    return $response = [
                        'status' => 205,
                        'message' => 'Success',
                        'result' => $result,
                    ];
                }
            }
        }
        if ($temp['template'] == 6) {
            $this->layout = 'quiz6-main';
            $result = QuizSubmittedAnswers::find()
                ->select(['answer_enc_id'])
                ->where(['quiz_slug' => $slug, 'user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->count();
            if ($result == 0) {
                return $this->render('college-quiz', [
                    'quiz' => $this->_getQuestion([],$slug),
                ]);
            } else {
                $noOfQuestion = Quizs::find()
                    ->select('num_of_ques')
                    ->where(['slug' => $slug])
                    ->asArray()
                    ->one();
                return $this->render('college-quiz', [
                    'result' => $this->_getQuizResult($slug),
                    'noOfQuestion' => $noOfQuestion,
                ]);
            }
//            return $this->render('college-quiz', [
//                'score' => $s,
//                'total' => $t,
//                'quiz' => $temp
//            ]);
        } else{
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    private function _getPreviousQuestions($slug)
    {
        $previousQuestions = QuizSubmittedAnswers::find()
            ->select(['quiz_question_pool_enc_id'])
            ->where(['quiz_slug' => $slug, 'user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();
        $r = ArrayHelper::getColumn($previousQuestions, 'quiz_question_pool_enc_id');
        return $r;
    }

    private function _getQuestion($isSubmitted = [], $slug)
    {
        $question = Quizs::find()
            ->alias('z')
            ->innerJoinWith(['quizPoolEnc a' => function ($a) use ($isSubmitted) {
                $a->innerJoinWith(['quizQuestionsPools c' => function ($c) use ($isSubmitted) {
                    $c->innerJoinWith(['quizAnswersPools d' => function ($d) {
                        $d->select(['d.quiz_answer_pool_enc_id', 'd.quiz_question_pool_enc_id', 'd.answer']);
                    }]);
                    $c->andWhere(['not in', 'c.quiz_question_pool_enc_id', $isSubmitted]);
                    $c->orderby(new Expression('rand()'));
                    $c->limit(1);
                }]);
            }])
            ->where(['z.slug' => $slug])
            ->asArray()
            ->one();
        return $question;
    }

    private function _getQuizResult($slug)
    {
        $result = QuizSubmittedAnswers::find()
            ->select(['answer_enc_id'])
            ->where(['quiz_slug' => $slug, 'is_correct' => 1, 'user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->count();
        return $result;
    }

    public function actionGetResult($slug)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = $this->_getQuizResult($slug);
            return $response = [
                'status' => 205,
                'message' => 'Success',
                'result' => $result,
            ];
        }
    }
}