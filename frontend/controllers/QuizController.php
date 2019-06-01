<?php

namespace frontend\controllers;

use common\models\Quiz;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class QuizController extends Controller
{

    public function actionDetail($slug, $s = NULL, $t= NULL)
    {
        $this->layout = 'quiz-main';
        if (Yii::$app->request->isAjax) {
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

}