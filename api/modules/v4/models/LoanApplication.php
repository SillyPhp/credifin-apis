<?php

namespace api\modules\v4\models;

use common\models\EducationLoanPayments;
use common\models\extended\PaymentsModule;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class LoanApplication extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone_no;
    public $loan_amount;
    public $loan_purpose;
    public $desired_tenure;
    public $company;
    public $company_type;
    public $business;
    public $annual_turnover;
    public $designation;
    public $business_premises;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $loan_type;
    public $current_city;
    public $annual_income;
    public $is_simple;
    public $occupation;
    public $vehicle_type;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'loan_type', 'phone_no', 'loan_amount', 'email'], 'required'],
            [['desired_tenure', 'company', 'company_type', 'business', 'annual_turnover', 'designation', 'business_premises',
                'address', 'city', 'state', 'zip', 'current_city', 'annual_income', 'is_simple', 'occupation', 'vehicle_type'], 'safe'],
            [['first_name', 'last_name', 'loan_purpose', 'email', 'loan_purpose'], 'trim'],
            [['first_name', 'last_name'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 100],
            [['phone_no'], 'string', 'length' => [10, 10]],
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
            $model->applicant_name = $this->first_name . ' ' . $this->last_name;
            $model->applicant_current_city = $this->current_city;
            $model->phone = $this->phone_no;
            $model->email = $this->email;
            $model->amount = str_replace(',', '', $this->loan_amount);
            $model->source = 'EmpowerFintech';
            $model->loan_type = $this->loan_type;
            $model->loan_purpose = $this->loan_purpose;
            $model->yearly_income = $this->annual_income;
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = ((Yii::$app->user->identity->user_enc_id) ? Yii::$app->user->identity->user_enc_id : NULL);
            if (!$model->save()) {
                $transaction->rollback();
                return false;
            }

            // saving other options
            if (!$this->is_simple && ($this->loan_type == 'Business Loan' || $this->loan_type == 'Personal Loan' || $this->loan_type == 'Vehicle Loan')) {
                $loan_options = new LoanApplicationOptions();
                $loan_options->option_enc_id = $utilitiesModel->encrypt();
                $loan_options->loan_app_enc_id = $model->loan_app_enc_id;
                $loan_options->name_of_company = $this->company;
                $loan_options->type_of_company = $this->company_type;
                $loan_options->nature_of_business = $this->business;
                $loan_options->annual_turnover = $this->annual_turnover;
                $loan_options->business_premises = $this->business_premises;
                $loan_options->designation = $this->designation;
                $loan_options->occupation = $this->occupation;
                $loan_options->vehicle_type = $this->vehicle_type;
                $loan_options->created_on = date('Y-m-d H:i:s');
                $loan_options->created_by = ((Yii::$app->user->identity->user_enc_id) ? Yii::$app->user->identity->user_enc_id : NULL);
                if (!$loan_options->save()) {
                    $transaction->rollback();
                    return false;
                }
            }

            // saving address
            if (!$this->is_simple && ($this->loan_type == 'Business Loan' || $this->loan_type == 'Personal Loan' || $this->loan_type == 'Loan Against Property' || $this->loan_type == 'Vehicle Loan')) {
                $loan_address = new LoanApplicantResidentialInfo();
                $loan_address->loan_app_res_info_enc_id = $utilitiesModel->encrypt();
                $loan_address->loan_app_enc_id = $model->loan_app_enc_id;
                $loan_address->address = $this->address;
                $loan_address->city_enc_id = $this->city;
                $loan_address->state_enc_id = $this->state;
                $loan_address->postal_code = $this->zip;
                $loan_address->created_on = date('Y-m-d H:i:s');
                $loan_address->created_by = ((Yii::$app->user->identity->user_enc_id) ? Yii::$app->user->identity->user_enc_id : NULL);
                if (!$loan_address->save()) {
                    $transaction->rollback();
                    return false;
                }
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
            return false;
        }
    }

    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }
}