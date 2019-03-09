<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\Cities;

class CitiesController extends ActiveController {

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
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionList() {
        $attributes = Yii::$app->request->post();
        if(!empty($attributes['state_id'])) {
            $citiesModel = new Cities();
            $cities = $citiesModel->find()
                    ->select(['city_enc_id AS id', 'name'])
                    ->where(['state_enc_id' => $attributes['state_id']])
                    ->orderBy(['name' => SORT_ASC])
                    ->asArray()
                    ->all();

            return [
                'cities' => $cities,
            ];
        } else {
            return [
                'message' => 'State is required.'
            ];
        }
        
    }

}
