<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class TrainingsController extends Controller
{
    public function actionDetail(){
        return $this->render('detail');
    }
}