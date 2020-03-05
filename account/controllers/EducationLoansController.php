<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;


class EducationLoansController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id,2);
        return parent::beforeAction($action);
    }

    public function actionDashboard(){
        return $this->render('dashboard');
    }
}