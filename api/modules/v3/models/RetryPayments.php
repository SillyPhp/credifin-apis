<?php
namespace api\modules\v3\models;
use common\models\EducationLoanPayments;
use common\models\InstituteLeadsPayments;
use common\models\Utilities;
use yii\base\Model;

class RetryPayments extends Model
{
    public $loan_app_id;
    public $token;
    public $pay_amount;
    public $status;
    public $payment_id;
    public $gst;

    public function rules()
    {
        return [
            [['loan_app_id', 'token','pay_amount','status','payment_id','gst'], 'required'],
        ];
    }
    public function formName()
    {
        return '';
    }

    public function Insert()
    {
        $loan_payment = new EducationLoanPayments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $loan_payment->education_loan_payment_enc_id = $utilitiesModel->encrypt();
        $loan_payment->loan_app_enc_id = $this->loan_app_id;
        $loan_payment->payment_token = $this->token;
        $loan_payment->payment_amount = $this->pay_amount;
        $loan_payment->payment_status = $this->status;
        $loan_payment->payment_id = $this->payment_id;
        $loan_payment->payment_gst = $this->gst;
        $loan_payment->created_on = date('Y-m-d H:i:s');
        if ($loan_payment->save())
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function Update($options)
    {
        $loan_payment = EducationLoanPayments::findOne(['payment_token'=>$options['invoice_id']]);
        $loan_payment->payment_status = (($options['status']=='paid')?'captured':$options['status']);
        $loan_payment->payment_id = $options['payment_id'];
        $loan_payment->payment_signature = $options['signature'];
        if ($loan_payment->save()){
            return true;
        }else{
            return false;
        }
    }
    public function UpdateInstitute($options)
    {
        $loan_payment = InstituteLeadsPayments::findOne(['payment_token'=>$options['invoice_id']]);
        $loan_payment->payment_status = (($options['status']=='paid')?'captured':$options['status']);
        $loan_payment->payment_id = $options['payment_id'];
        $loan_payment->payment_signature = $options['signature'];
        if ($loan_payment->save()){
            return true;
        }else{
            return false;
        }
    }
}