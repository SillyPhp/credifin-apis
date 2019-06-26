<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class EmployersController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFeatures()
    {
        return $this->render('features');
    }

}