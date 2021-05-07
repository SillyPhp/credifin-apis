<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;

class SkillUpController extends Controller{
    public function actionDashboard(){
        return $this->render('feed-dashboard');
    }
}