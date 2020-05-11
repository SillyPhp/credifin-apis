<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\VerbFilter;

class ProfilesController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'active' => ['post'],
                ],
            ],
        ];
    }

    public function actionActive()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $parameters = Yii::$app->request->post();
            $categories = \frontend\models\profiles\ProfileCards::activeProfiles($parameters);
            if ($categories) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'categories' => $categories
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

}