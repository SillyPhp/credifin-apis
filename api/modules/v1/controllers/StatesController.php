<?php

namespace api\modules\v1\controllers;

use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\States;

class StatesController extends ActiveController {

    public $modelClass = 'common\models\Cities';

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
                    'list' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionList() {
        $statesModel = new States();
        $states = $statesModel->find()
                ->select(['state_enc_id AS id', 'name'])
                ->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all();

        return [
            'states' => $states,
        ];
    }

}
