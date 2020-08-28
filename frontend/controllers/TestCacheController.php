<?php

namespace frontend\controllers;
use common\models\EducationLoanPayments;
use yii\web\Controller;
use common\models\Utilities;

class TestCacheController extends Controller
{
    public function actionStatusUpdate()
    {
        $paymentsModes = ['pending','failed','cancelled',NULL,''];
        $applications = EducationLoanPayments::find()
                        ->select(['education_loan_payment_enc_id','loan_app_enc_id','payment_status','created_on'])
                        ->andWhere([
                            'or',
                            ['payment_status'=>'pending'],
                            ['payment_status'=>'failed'],
                            ['payment_status'=>'cancelled'],
                            ['payment_status'=>NULL],
                            ['payment_status'=>''],
                        ])
                        ->asArray()
                        ->all();

        foreach ($applications as $app)
        {

        }
    }

}