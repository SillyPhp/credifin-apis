<?php

namespace api\modules\v4\models;

use common\models\BillDetails;
use common\models\EmailLogs;
use common\models\Referral;
use common\models\spaces\Spaces;
use common\models\Usernames;
use common\models\Users;
use common\models\UserTypes;
use Razorpay\Api\Api;
use common\models\extended\Payments;
use common\models\EducationLoanPayments;
use common\models\extended\PaymentsModule;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
use common\models\RandomColors;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class LoanApplication extends Model
{
    public $applicant_name;
    public $phone_no;
    public $loan_amount;
    public $first_name;
    public $last_name;
    public $email;
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
    public $vehicle_option;
    public $ref_id;
    public $file;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['applicant_name', 'loan_type', 'phone_no', 'email'], 'required'],
            [['desired_tenure', 'company', 'company_type', 'business', 'annual_turnover', 'designation', 'business_premises',
                'address', 'city', 'state', 'zip', 'current_city', 'annual_income', 'occupation', 'vehicle_type', 'vehicle_option', 'ref_id', 'loan_amount'], 'safe'],
            [['applicant_name', 'loan_purpose', 'email'], 'trim'],
            [['applicant_name'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 100],
            [['phone_no'], 'string', 'length' => [10, 10]],
            [['email'], 'email'],
        ];
    }

    public function save($user_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $model = new LoanApplications();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->loan_app_enc_id = $utilitiesModel->encrypt();
            $model->had_taken_addmission = 0;
            $model->applicant_name = $this->applicant_name;
            $model->applicant_current_city = $this->current_city;
            $model->phone = $this->phone_no;
            $model->email = $this->email;
            $model->amount = str_replace(',', '', $this->loan_amount);
            $model->source = 'EmpowerFintech';
            $model->loan_type = $this->loan_type;
            $model->loan_purpose = $this->loan_purpose;
            $model->yearly_income = $this->annual_income;
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = $user_id;

            if ($this->ref_id) {
                $referralData = Referral::findOne(['code' => $this->ref_id]);
                if ($referralData) {
                    if ($referralData->user_enc_id):
                        $model->lead_by = $referralData->user_enc_id;
                    endif;
                    if ($referralData->organization_enc_id):
                        $model->lead_by = Users::findOne(['organization_enc_id' => $referralData->organization_enc_id])->user_enc_id;
                    endif;
                }
            }

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
                $loan_options->vehicle_option = $this->vehicle_option;
                $loan_options->created_on = date('Y-m-d H:i:s');
                $loan_options->created_by = $user_id;
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
                $loan_address->created_by = $user_id;
                if (!$loan_address->save()) {
                    $transaction->rollback();
                    return false;
                }
            }

            if ($this->file && ($this->loan_type == 'Medical Loan')) {
                if (!$this->uploadFile($model->loan_app_enc_id)) {
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

            $options['loan_app_id'] = $model->loan_app_enc_id;
            $options['name'] = $model->applicant_name;
            $options['phone'] = $model->phone;
            $options['email'] = $model->email;

            if (!$this->SignUp($options)) {
                $transaction->rollback();
                return false;
            }

            $payment_model = new EducationLoanPayments();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $payment_model->education_loan_payment_enc_id = $utilitiesModel->encrypt();
            $payment_model->loan_app_enc_id = $model->loan_app_enc_id;
            $payment_model->payment_amount = 500;
            $payment_model->payment_gst = 0;
            $payment_model->payment_token = Yii::$app->getSecurity()->generateRandomString();
            $payment_model->payment_status = 'waived off';
            $payment_model->created_by = $user_id;
            $payment_model->created_on = date('Y-m-d H:i:s');
            if (!$payment_model->save()) {
                return false;
            }

            $transaction->commit();

            $data = [];
            $data['loan_app_enc_id'] = $model->loan_app_enc_id;
            $data['payment_url'] = null;
            return [
                'status' => true,
                'data' => $data
            ];

//            $paymentUrl = $this->createUrl($options);
//            if ($paymentUrl['status'] == 200) {
//                $data = [];
//                $data['loan_app_enc_id'] = $model->loan_app_enc_id;
//                $data['payment_url'] = $paymentUrl['surl'];
//                return [
//                    'status' => true,
//                    'data' => $data
//                ];
//            } else {
//                $transaction->rollBack();
//                return false;
//            }

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
        $total_amount = 500;
        if ($this->loan_type == 'Medical Loan') {
            $options['amount'] = 600;
            $total_amount = 600;
        }

        if ($this->loan_type == 'Hospi Shield') {
            $options['amount'] = 170;
            $total_amount = 170;
        }

        $options['loan_enc_id'] = $id;
        $options['currency'] = "INR";
        $options['gst'] = 0;
        $options['name'] = $name;
        $options['email'] = $email;
        $options['contact'] = $phone;
        $options['total'] = $this->floatPaisa($total_amount);
        $options['callback_url'] = "https://www.empowerloans.in/payment/transaction";
        $options['brand'] = "Empower Loans";
        $link = $api->paymentLink->create([
            'amount' => $options['total'],
            'currency' => $options['currency'],
            'accept_partial' => false,
            'description' => 'Application Login Fee',
            'customer' => [
                'name' => $options['name'],
                'email' => $options['email'],
                'contact' => $options['contact']
            ],
            'notify' => [
                'sms' => true,
                'email' => true
            ],
            'reminder_enable' => true,
            'callback_url' => $options['callback_url'],
            'callback_method' => 'get',
            'options' => [
                "checkout" => [
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

    private function stringGenerate($n = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return 'Ey_' . $randomString;
    }

    public function SignUp($data)
    {
        $id = Users::find()
            ->where([
                'or',
                ['phone' => $data['phone']],
                ['email' => $data['email']],
            ])->one();
        if ($id) {
            $get = LoanApplications::findOne(['loan_app_enc_id' => $data['loan_app_id']]);
            $get->created_by = $id->user_enc_id;
            if ($get->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            $params = [];
            $params['id'] = $data['loan_app_enc_id'];
            $params['name'] = $data['name'];
            $params['email'] = $data['email'];
            $params['phone'] = str_replace('+', '', $data['phone']);
            $id = $this->userAutoSignUp($params);
            if ($id) {
                $get = LoanApplications::findOne(['loan_app_enc_id' => $data['loan_app_id']]);
                $get->created_by = $id['id'];
                if ($get->save()) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function userAutoSignUp($params)
    {
        $user_type = UserTypes::findOne([
            'user_type' => 'Individual',
        ]);

        if (!$user_type) {
            return false;
        }

        $username = $this->generate_username($params['name']);
        $password = $params['phone'];
        $arr = explode(' ', $params['name']);
        $first_name = $arr[0];
        $last_name = $arr[1] . ' ' . (($arr[2]) ? $arr[2] : '');
        if (empty($last_name)):
            $last_name = null;
        endif;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $usernamesModel = new Usernames();
            $usernamesModel->username = strtolower($username);
            $usernamesModel->assigned_to = 1;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                $transaction->rollBack();
                return false;
            }

            $utilitiesModel = new Utilities();
            $usersModel = new Candidates();
            $usersModel->username = strtolower($username);
            $usersModel->first_name = ucfirst(strtolower($first_name));
            $usersModel->last_name = ucfirst(strtolower($last_name));
            $usersModel->email = strtolower($params['email']);
            $usersModel->phone = $params['phone'];
            $usersModel->initials_color = RandomColors::one();
            $usersModel->user_type_enc_id = $user_type->user_type_enc_id;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $usersModel->user_enc_id = $utilitiesModel->encrypt();
            $usersModel->status = 'Active';
            $usersModel->last_visit = date('Y-m-d H:i:s');
            $usersModel->last_visit_through = 'EL';
            $usersModel->signed_up_through = 'EL';
            $usersModel->setPassword($password);
            $usersModel->generateAuthKey();
            if (!$usersModel->validate() || !$usersModel->save()) {
                $transaction->rollBack();
                return false;
                //throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($usersModel->errors, 0, false)));
            }

            $ref = $this->addRef($usersModel->user_enc_id);
            if (!$ref) {
                $transaction->rollBack();
                return false;
            }

//            $this->autoSignupEmail($username, $password, $usersModel);

            $transaction->commit();
            return ['id' => $usersModel->user_enc_id];

        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    private function autoSignupEmail($username, $password, $usersModel)
    {
        $params['username'] = $username;
        $params['password'] = $password;
        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app->mailer->compose(
            ['html' => 'default-user-password'], ['data' => $params]
        )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$params['email'] => $params['name']])
            ->setSubject('Your Empower Youth\'s Default Username Password Is Here');
        if ($mail->send()) {
            $mail_logs = new EmailLogs();
            $mail_logs->email_log_enc_id = Yii::$app->security->generateRandomString(15);
            $mail_logs->email_type = 5;
            $mail_logs->user_enc_id = $usersModel->user_enc_id;
            $mail_logs->receiver_name = $usersModel->first_name . " " . $usersModel->last_name;
            $mail_logs->receiver_email = $usersModel->email;
            $mail_logs->receiver_phone = $usersModel->phone;
            $mail_logs->subject = "Your Empower Youth's Default Username Password Is Here";
            $mail_logs->template = 'dafault-user-password';
            $mail_logs->is_sent = 1;
            $mail_logs->save();
        }
    }

    private function generate_username($string_name = null, $rand_no = 200)
    {
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, 8) : ""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, 5) : ""; //cut second name to 5 letters
        $part3 = ($rand_no) ? rand(0, $rand_no) : "";

        $username = $part1 . str_shuffle($part2) . $part3; //str_shuffle to randomly shuffle all characters
        return $username;
    }

    private function addRef($user_id)
    {
        $ref = new \common\models\Referral();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $ref->referral_enc_id = $utilitiesModel->encrypt();
        $ref->code = $ref->referral_link = $this->_getReferralCode();
        $ref->user_enc_id = $user_id;
        $ref->created_by = $user_id;
        $ref->created_on = date('Y-m-d H:i:s');
        if ($ref->save()) {
            return $ref->code;
        }

        return false;
    }

    private function _getReferralCode($n = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public function uploadFile($loan_id)
    {
        $utilitiesModel = new Utilities();
        $bill = new BillDetails();
        $bill->bill_detail_enc_id = \Yii::$app->getSecurity()->generateRandomString();
        $bill->loan_app_enc_id = $loan_id;
        $bill->file_location = \Yii::$app->getSecurity()->generateRandomString();
        $base_path = Yii::$app->params->upload_directories->loans->bill . $bill->file_location . '/';
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $bill->file = $utilitiesModel->encrypt() . '.' . 'pdf';
        $type = $this->file->type;
        if ($bill->save()) {
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($this->file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $bill->file, "private", ['params' => ['ContentType' => $type]]);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}