<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\QuizCounter;

class QuizCounterController extends ActiveController {
    
    public $modelClass = 'common\models\QuizCounter';

    public function behaviors() {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['POST'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                ],
            ],
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionAdd() {
        $attributes = Yii::$app->request->post();
        $quizCounterModel = new QuizCounter();
        $quizCounterModel->ip_address = $attributes['ip_address'];
        $quizCounterModel->location = $attributes['location'];
        $quizCounterModel->date_time = date('Y-m-d h:i:s');
        if ($quizCounterModel->validate() && $quizCounterModel->save()) {
            $response = [
                'status' => 200,
            ];
        } else {
            $response = [
                'error' => $quizCounterModel->getErrors(),
            ];
        }
        return $response;
    }

}
