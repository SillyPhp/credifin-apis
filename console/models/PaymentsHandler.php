<?php
namespace console\models;
use common\models\EducationLoanPayments;

class PaymentsHandler {

    public static function get($options)
    {
        return self::getApplication($options);
    }

    private static function getApplication($options=[])
    {
      //getting all the applications except captured status
      $app =  EducationLoanPayments::find()
            ->select(['education_loan_payment_enc_id','loan_app_enc_id','payment_token','payment_status','created_on'])
            ->andWhere([
                'or',
                ['payment_status'=>'pending'],
                ['payment_status'=>'failed'],
                ['payment_status'=>'cancelled'],
                ['payment_status'=>NULL],
                ['payment_status'=>''],
            ])
            ->andWhere([
                'or',
                ['!=','payment_token',null],
                ['!=','payment_token','']
            ])
            ->andWhere(['between', 'created_on', $options['interval'], $options['today']])
            ->orderBy(['created_on'=>SORT_DESC])
            ->asArray()
            ->all();
      return $app;
    }

}