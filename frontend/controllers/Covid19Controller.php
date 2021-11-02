<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class Covid19Controller extends Controller
{
    public function beforeAction($action)
    {
        $route = ltrim(Yii::$app->request->url, '/');
        if ($route === "") {
            $route = "/";
        }
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute($route, $this);
        return parent::beforeAction($action);
    }

    public function actionPosters()
    {
        return $this->actionSafetyPosters();
    }
    public function actionSafetyPosters()
    {
        return $this->render('warning-posters');
    }
    public function actionWarningPosters()
    {
        return $this->actionSafetyPosters();
    }
}