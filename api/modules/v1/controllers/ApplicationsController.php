<?php

namespace api\modules\v1\controllers;

use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\ActiveController;

class ApplicationsController extends ActiveController {

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
        ];
    }

    public $modelClass = 'api\modules\v1\models\Jobs';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'applications',
    ];

}
