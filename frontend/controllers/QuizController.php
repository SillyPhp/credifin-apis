<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\Quiz;

class QuizController extends Controller
{

    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'quiz-details' => ['post'],
//                ],
//            ],
//        ];
//    }

    public function actionDetail($slug, $s = NULL, $t = NULL)
    {
        $this->layout = 'quiz-main';
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
        return $this->render('cricket-quiz', [
            'score' => $s,
            'total' => $t
        ]);
    }

//    public function actionQuizDetails()
//    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
//        $response = [];
//        if (Yii::$app->request->isAjax) {
//            $slug = Yii::$app->request->post('slug');
//            $quiz = Quiz::find()
//                ->alias('a')
//                ->joinWith(['quizQuestions b' => function ($x) {
//                    $x->andWhere([
//                        'b.status' => 1,
//                        'b.is_deleted' => 0
//                    ]);
//                    $x->joinWith(['quizAnswers c']);
//                }])
//                ->where([
//                    'a.slug' => $slug,
//                    'a.status' => 1,
//                    'a.is_deleted' => 0
//                ])
//                ->asArray()
//                ->one();
//            if ($quiz) {
//                $response = [
//                    'results' => $quiz['quizQuestions'],
//                ];
//            }
//        }
//
//        return $response;
//    }

}