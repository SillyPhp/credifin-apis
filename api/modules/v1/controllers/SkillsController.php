<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\Skills;

class SkillsController extends ActiveController {

    public $modelClass = 'common\models\Skills';

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
                    'index' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionIndex() {
        $skillsModel = new Skills();
        $skills = $skillsModel->find()
                ->select(['skill_enc_id', 'skill'])
                ->where(['is_deleted' => 0])
                ->all();
        if ($skills) {
            $response = [
                'status' => 200,
                'skills' => $skills,
            ];
        } else {
            $response = [
                'status' => 201,
                'message' => 'No results found.',
            ];
        }
        return $response;
    }

}
