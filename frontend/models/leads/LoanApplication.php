<?php

namespace frontend\models\leads;

use common\models\EducationLoanPayments;
use common\models\extended\PaymentsModule;
use common\models\InstituteLeadsPayments;
use common\models\LoanApplications;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class LoanApplication extends Model
{
    public $applicantName;
    public $loanType;
    public $loanAmount;
    public $email;
    public $contact;
    public $loanPurpose;
    public $current_city;
    public $_flag;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['current_city', 'applicantName', 'loanPurpose', 'loanType', 'email', 'contact', 'loanAmount'], 'required'],
            [['applicantName', 'loanPurpose', 'email'], 'trim'],
            [['applicantName'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 100],
            [['contact'], 'string', 'length' => [10, 10]],
            [['email'], 'email'],
        ];
    }

    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new LoanApplications();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->loan_app_enc_id = $utilitiesModel->encrypt();
            $model->had_taken_addmission = 0;
            $model->applicant_name = $this->applicantName;
            $model->applicant_current_city = $this->current_city;
            $model->phone = $this->contact;
            $model->email = $this->email;
            $model->amount = str_replace(',', '', $this->loanAmount);
            $model->source = 'Ey';
            $model->loan_type = $this->loanType;
            $model->loan_purpose = $this->loanPurpose;
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = ((Yii::$app->user->identity->user_enc_id) ? Yii::$app->user->identity->user_enc_id : NULL);
            if (!$model->save()) {
                $transaction->rollback();
                return false;
            }

            $userId = Yii::$app->user->identity->user_enc_id;
            $total_amount = $amount = 500;
            $gst = 0;
            $args = [];
            $args['amount'] = $this->floatPaisa($total_amount);
            $args['currency'] = "INR";
            $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
            $response = PaymentsModule::_authPayToken($args);
            if (isset($response['status']) && $response['status'] == 'created') {
                $token = $response['id'];
                $loan_payment = new EducationLoanPayments();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $loan_payment->education_loan_payment_enc_id = $utilitiesModel->encrypt();
                $loan_payment->loan_app_enc_id = $model->loan_app_enc_id;
                $loan_payment->payment_token = $token;
                $loan_payment->payment_amount = $amount;
                $loan_payment->payment_gst = $gst;
                $loan_payment->created_by = (($userId) ? $userId : null);
                $loan_payment->created_on = date('Y-m-d H:i:s');
                if (!$loan_payment->save()) {
                    $transaction->rollBack();
                    return false;
                } else {
                    $transaction->commit();
                    $data = [];
                    $data['loan_app_enc_id'] = $model->loan_app_enc_id;
                    $data['payment_enc_id'] = $loan_payment->education_loan_payment_enc_id;
                    $data['payment_id'] = $loan_payment->payment_token;
                    return [
                        'status' => true,
                        'data' => $data
                    ];
                }
            } else {
                $transaction->rollBack();
                return false;
            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
            echo $exception;
        }
    }

    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }

}