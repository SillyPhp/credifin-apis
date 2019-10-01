<?php

namespace frontend\controllers;

use frontend\models\EducationalLoans;
use Yii;
use yii\web\Controller;


class EducationLoansController extends Controller
{
    public function actionIndex(){
        return $this->render("index");
    }
    public function actionApply(){
        $model = new EducationalLoans();
        return $this->render('apply',[
            'EducationalLoan' => $model,
        ]);
    }
}