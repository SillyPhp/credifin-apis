<?php

namespace frontend\controllers;
use common\models\EducationLoanPayments;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class PaymentController extends Controller
{
 public function actionGateway($id){
   $payment = EducationLoanPayments::find()
       ->select(['payment_token','education_loan_payment_enc_id','loan_app_enc_id'])
       ->andWhere(['loan_app_enc_id' => $id])
       ->asArray()
       ->one();
     $this->layout = 'widget-layout';
     return $this->render('gateway',[
        'token' => $payment['payment_token'],
         'education_loan_id' => $payment['education_loan_payment_enc_id'],
         'loan_id' => $payment['loan_app_enc_id'],
     ]);
 }
}