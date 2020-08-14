<?php

namespace frontend\controllers;

use frontend\models\EducationalLoans;
use Yii;
use yii\web\Controller;


class EducationLoansController extends Controller
{
    public function actionIndex(){
        return $this->render("education-loan-index");
    }
    public function actionApply(){
        $model = new EducationalLoans();
        return $this->render('apply',[
            'EducationalLoan' => $model,
        ]);
    }
    public function actionEducationLoanView(){
        return $this->render('education-loan-view');
    }
    public function actionLoanViewCollege()
    {
        return $this->render('loan-view-college');
    }

    public function actionLoanCollegeIndex(){
        return $this->render('loan-college-index');
    }
}