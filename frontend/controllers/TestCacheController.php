<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TestCacheController extends Controller
{
    public function actionIndex()
    {
        return 'cache';
    }
}