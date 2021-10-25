<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;

class AssociativeController extends Controller{
    public function actionDashboard(){
        return $this->render('index');
    }
}