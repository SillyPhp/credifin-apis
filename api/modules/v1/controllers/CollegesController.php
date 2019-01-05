<?php

namespace api\modules\v1\controllers;

use yii\web\Response;
use yii\rest\ActiveController;

class CollegesController extends ActiveController {

    public $modelClass = 'common\models\Colleges';

    public function behaviors() {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }
   
}
