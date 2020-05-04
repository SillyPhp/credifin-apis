<?php

namespace account\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
class QuizController extends Controller
{
    public function actionDashboard(){
        return $this->render('dashboard');
    }
    public function actionCreate(){
        return $this->render('create-quiz-multi');
    }
}