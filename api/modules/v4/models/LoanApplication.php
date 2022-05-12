<?php

namespace api\modules\v4\models;

use Razorpay\Api\Api;
use common\models\extended\Payments;
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
                'address', 'city', 'state', 'zip', 'current_city', 'annual_income', 'occupation', 'vehicle_type'], 'safe'],
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
            if ($this->loan_type == 'Business Loan' || $this->loan_type == 'Personal Loan' || $this->loan_type == 'Vehicle Loan') {
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
            if ($this->loan_type == 'Business Loan' || $this->loan_type == 'Personal Loan' || $this->loan_type == 'Loan Against Property' || $this->loan_type == 'Vehicle Loan') {
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

//            $userId = Yii::$app->user->identity->user_enc_id;
//            $total_amount = $amount = 500;
//            $gst = 0;
//            $args = [];
//            $args['amount'] = $this->floatPaisa($total_amount);
//            $args['currency'] = "INR";
//            $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
//            $response = PaymentsModule::_authPayToken($args);
//            if (isset($response['status']) && $response['status'] == 'created') {
//                $token = $response['id'];
//                $loan_payment = new EducationLoanPayments();
//                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
//                $loan_payment->education_loan_payment_enc_id = $utilitiesModel->encrypt();
//                $loan_payment->loan_app_enc_id = $model->loan_app_enc_id;
//                $loan_payment->payment_token = $token;
//                $loan_payment->payment_amount = $amount;
//                $loan_payment->payment_gst = $gst;
//                $loan_payment->created_by = (($userId) ? $userId : null);
//                $loan_payment->created_on = date('Y-m-d H:i:s');
//                if (!$loan_payment->save()) {
//                    $transaction->rollBack();
//                    return false;
//                } else {
//                    $transaction->commit();
//                    $data = [];
//                    $data['loan_app_enc_id'] = $model->loan_app_enc_id;
//                    $data['payment_enc_id'] = $loan_payment->education_loan_payment_enc_id;
//                    $data['payment_id'] = $loan_payment->payment_token;
//                    return [
//                        'status' => true,
//                        'data' => $data
//                    ];
//                }
//            }
            $transaction->commit();

            $options['loan_app_id'] = $model->loan_app_enc_id;
            $options['name'] = $model->applicant_name;
            $options['phone'] = $model->phone;
            $options['email'] = $model->email;
            $paymentUrl = $this->createUrl($options);
            if ($paymentUrl['status'] == 200) {
                $data = [];
                $data['loan_app_enc_id'] = $model->loan_app_enc_id;
                $data['payment_url'] = $paymentUrl['surl'];
                    return [
                        'status' => true,
                        'data' => $data
                    ];
            } else {
                $transaction->rollBack();
                return false;
            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
            print_r($exception);
            return false;
        }
    }

    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }

    private function createUrl($params)
    {
        $model = new Payments();
        $api_key = Yii::$app->params->razorPay->prod->apiKey;
        $api_secret = Yii::$app->params->razorPay->prod->apiSecret;
        $api = new Api($api_key, $api_secret);
        $secret_reciept_code = $this->stringGenerate(8);
        $options = [];
        $id = $params['loan_app_id'];
        $email = $params['email'];
        $phone = $params['phone'];
        $name = $params['name'];
        $d = EducationLoanPayments::find()
            ->select(['payment_short_url surl'])
            ->where(['loan_app_enc_id' => $id])
            ->andWhere([
                'or',
                ['!=', 'payment_short_url', null],
                ['!=', 'payment_short_url', '']
            ])
            ->andWhere([
                'or',
                ['!=', 'payment_status', 'created'],
                ['!=', 'payment_status', 'captured'],
                ['payment_status' => ''],
                ['payment_status' => null],
            ])
            ->asArray()
            ->one();
        if ($d):
            return [
                'surl' => $d['surl'],
                'status' => 200
            ];
        endif;
        $options['amount'] = 500;
        $options['loan_enc_id'] = $id;
        $options['currency'] = "INR";
        $options['gst'] = 0;
        $options['name'] = $name;
        $options['email'] = $email;
        $options['contact'] = $phone;
        $total_amount = 500;
        $options['total'] = $this->floatPaisa($total_amount);
//        $options['callback_url'] = "https://www.empowerloans.in/payment/transaction";
        $options['callback_url'] = "http://192.168.29.6:3000/payment/transaction";
        $options['brand'] = "Empower Loans";
        $link = $api->paymentLink->create([
            'amount'=>$options['total'],
            'currency'=>$options['currency'],
            'accept_partial'=>false,
            'description' => 'Application Login Fee',
            'customer' => [
                'name'=>$options['name'],
                'email' => $options['email'],
                'contact'=>$options['contact']
            ],
            'notify'=>[
                'sms'=>true,
                'email'=>true
            ] ,
            'reminder_enable'=>true,
            'callback_url' => $options['callback_url'],
            'callback_method'=>'get',
            'options'=>[
                "checkout"=>[
                    "name" => $options['brand']
                ]
            ]
        ]);
        if ($link->short_url) {
            $options['surl'] = $link->short_url;
            $options['token'] = $link->id;
            if ($model->createUrl($options)) {
                return [
                    'surl' => $link->short_url,
                    'status' => 200
                ];
            } else {
                return [
                    'status' => 400,
                    'message' => 'Unable To Save Information'
                ];
            }
        } else {
            return [
                'status' => 201,
                'message' => 'Unable Create Url'
            ];
        }
    }

    private function stringGenerate($n=8){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return 'Ey_'.$randomString;
    }

}