<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;


class EducationLoansController extends Controller
{
    public function actionIndex(){
        return $this->render("index");
    }
    public function actionApply(){
        return $this->render('apply');
    }
}