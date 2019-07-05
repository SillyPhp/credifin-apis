<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\Quiz;

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
        if($temp['template'] == 1) {
            $this->layout = 'quiz-main';
            return $this->render('cricket-quiz', [
                'score' => $s,
                'total' => $t,
                'quiz' => $temp
            ]);
        }elseif ($temp['template'] == 2){
            $this->layout = 'quiz2-main';
            return $this->render('cricket-quiz-2', [
                'score' => $s,
                'total' => $t,
                'quiz' => $temp
            ]);
        }elseif($temp['template'] == 3){
            $this->layout = 'quiz3-main';
            return $this->render('quiz-3', [
                'score' => $s,
                'total' => $t,
                'quiz' => $temp
            ]);
        }
    }

    public function actionTest(){
        $this->layout = 'quiz4-main';
        return $this->render('quiz-4');
    }

}
