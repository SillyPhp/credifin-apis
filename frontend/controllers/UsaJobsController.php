<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class UsaJobsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}