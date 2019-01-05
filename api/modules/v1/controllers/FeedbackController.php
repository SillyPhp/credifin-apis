<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\Utilities;
use common\models\Feedback;

class FeedbackController extends ActiveController {

    public $modelClass = 'common\models\Feedback';

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
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionAdd() {
        if ($attributes = Yii::$app->request->post()) {
            $utilitiesModel = new Utilities();
            $feedbackModel = new Feedback();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $feedbackModel->feedback_enc_id = $utilitiesModel->encrypt();
            $feedbackModel->feedback = $attributes['feedback'];
            $feedbackModel->created_by = $attributes['user_id'];
            $feedbackModel->created_on = date('Y-m-d h:i:s');
            if ($feedbackModel->validate() && $feedbackModel->save()) {
                $response = [
                    'status' => 200,
                    'message' => 'Thank you for your feedback. We will get back to you soon.',
                ];
            } else {
                $response = [
                    'status' => 201,
                    'message' => $feedbackModel->getErrors(),
                ];
            }
        }
        return $response;
    }

}
