<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class CandidatesController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->seo->setSeoByRoute(Yii::$app->requestedRoute, $this);
        return parent::beforeAction($action);
    }

    public function actionFeatures()
    {
        return $this->render('features');
    }

}