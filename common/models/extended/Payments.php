<?php

namespace common\models\extended;

use common\models\InstituteLeadsPayments;
use common\models\Utilities;

use common\models\EducationLoanPayments;

class Payments {
    public function createUrl($options){
        $model = new EducationLoanPayments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->education_loan_payment_enc_id = $utilitiesModel->encrypt();
        $model->loan_app_enc_id = $options['loan_enc_id'];
        $model->payment_amount = $options['amount'];
        $model->payment_gst = $options['gst'];
        $model->payment_token = $options['token'];
        $model->payment_short_url = $options['surl'];
        if ($model->save()){
            return true;
        }else{
            return false;
        }
    }
    public function createUrlInstitute($options){
        $model = new InstituteLeadsPayments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->payment_enc_id = $utilitiesModel->encrypt();
        $model->lead_enc_id = $options['loan_enc_id'];
        $model->payment_amount = $options['amount'];
        $model->payment_gst = $options['gst'];
        $model->payment_token = $options['token'];
        $model->payment_short_url = $options['surl'];
        if ($model->save()){
            return true;
        }else{
            return false;
        }
    }
}