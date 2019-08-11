<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TwitterJobsController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'main-secondary';
        return $this->render('index');
    }
}