<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;

class MentorsController extends Controller
{
    public function actionDashboard(){
        return $this->render('dashboard');
    }
    public function actionAllMentee(){
        return $this->render('all-mentee');
    }
}