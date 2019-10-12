<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class UsaJobsController extends Controller
{
    public function actionIndex($keywords=null)
    {
        return $this->render('index',['keywords'=>$keywords]);
    }

    public function actionTest()
    {
        return $this->render('test');
    }
}