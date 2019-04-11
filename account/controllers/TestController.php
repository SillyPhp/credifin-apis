<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller{

    public function actionIndex(){
        return $this->render('main');
    }

}