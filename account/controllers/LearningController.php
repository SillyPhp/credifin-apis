<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

class LearningController extends Controller
{
    public function actionDashboard()
    {
        return $this->render('dashboard');
    }
}