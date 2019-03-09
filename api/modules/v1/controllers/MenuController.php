<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\Controller;

class MenuController extends Controller {

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
                    'index' => ['GET'],
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

    public function actionIndex() {
        $menu = [
            'items' => [
                [
                    'id' => 2,
                    'name' => 'Jobs',
                    'visible' => true,
                ],
                [
                    'id' => 3,
                    'name' => 'Internships',
                    'visible' => true,
                ],
                [
                    'id' => 4,
                    'name' => 'Trainings',
                    'visible' => true,
                ],
                [
                    'id' => 5,
                    'name' => 'Quiz',
                    'visible' => false,
                ],
                [
                    'id' => 6,
                    'name' => 'Question Papers',
                    'visible' => false,
                ],
                [
                    'id' => 7,
                    'name' => 'Notes',
                    'visible' => false,
                ],
                [
                    'id' => 8,
                    'name' => 'Learning Corner',
                    'visible' => true,
                ],
            ],
        ];

        return $menu;
    }

}
