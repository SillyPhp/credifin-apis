<?php

namespace frontend\controllers;

use common\models\QuizAnswersPool;
use common\models\QuizPool;
use common\models\Quizs;
use common\models\QuizSubmittedAnswers;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\Quiz;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class QuizController extends Controller
{

    public function actionDetail($slug, $s = NULL, $t = NULL)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $quiz = Quiz::find()
                ->alias('a')
                ->joinWith(['quizQuestions b' => function ($x) {
                    $x->andWhere([
                        'b.status' => 1,
                        'b.is_deleted' => 0
                    ]);
                    $x->joinWith(['quizAnswers c']);
                }])
                ->where([
                    'a.slug' => $slug,
                    'a.status' => 1,
                    'a.is_deleted' => 0
                ])
                ->asArray()
                ->one();
            return [
                'results' => $quiz['quizQuestions']
            ];
        }
        $temp = Quiz::find()
            ->alias('a')
            ->where([
                'a.slug' => $slug,
                'a.status' => 1,
                'a.is_deleted' => 0
            ])
            ->asArray()
            ->one();
        if ($temp['template'] == 1) {
            $this->layout = 'quiz-main';
            return $this->render('cricket-quiz', [
                'score' => $s,
                'total' => $t,
                'quiz' => $temp
            ]);
        } elseif ($temp['template'] == 2) {
            $this->layout = 'quiz2-main';
            return $this->render('cricket-quiz-2', [
                'score' => $s,
                'total' => $t,
                'quiz' => $temp
            ]);
        } elseif ($temp['template'] == 3) {
            $this->layout = 'quiz3-main';
            return $this->render('quiz-3', [
                'score' => $s,
                'total' => $t,
                'quiz' => $temp
            ]);
        } elseif ($temp['template'] == 4) {
            $this->layout = 'quiz4-main';
            return $this->render('quiz-4', [
                'score' => $s,
                'total' => $t,
                'quiz' => $temp
            ]);
        } elseif ($temp['template'] == 5) {
            $this->layout = 'quiz5-main';
            return $this->render('quiz-5', [
                'score' => $s,
                'total' => $t,
                'quiz' => $temp
            ]);
        }
    }

    public function actionTest($slug = 'college-quiz')
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
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

        $this->layout = 'quiz6-main';
        $result = QuizSubmittedAnswers::find()
            ->select(['answer_enc_id'])
            ->where(['quiz_slug' => $slug, 'user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->count();
        if ($result == 0) {
            return $this->render('c-quiz', [
                'quiz' => $this->_getQuestion([],$slug),
            ]);
        } else {
            $noOfQuestion = Quizs::find()
                ->select('num_of_ques')
                ->where(['slug' => $slug])
                ->asArray()
                ->one();
            return $this->render('c-quiz', [
                'result' => $this->_getQuizResult($slug),
                'noOfQuestion' => $noOfQuestion,
            ]);
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

    public function actionGetResult($slug = 'college-quiz')
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

    public function actionPlayQuiz(){
        $this->layout = 'empty-layout';
        return $this->render('play-quiz');
    }
}
