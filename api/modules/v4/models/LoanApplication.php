<?php

namespace api\modules\v4\models;

use common\models\CertificateTypes;
use common\models\EmailLogs;
use common\models\extended\AssignedLoanProviderExtended;
use common\models\extended\EducationLoanPaymentsExtends;
use common\models\extended\LoanApplicantResidentialInfoExtended;
use common\models\extended\LoanApplicationOptionsExtended;
use common\models\extended\LoanApplicationsExtended;
use common\models\extended\LoanCertificatesExtended;
use common\models\extended\LoanPurposeExtended;
use common\models\LoanPurpose;
use common\models\Organizations;
use common\models\Referral;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\Users;
use common\models\UserTypes;
use Razorpay\Api\Api;
use common\models\extended\Payments;
use common\models\EducationLoanPayments;
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
    public $pan_number;
    public $loan_lender;
    public $aadhar_number;
    public $voter_card_number;
    public $vehicle_brand;
    public $vehicle_model;
    public $vehicle_making_year;
    public $lead_type;
    public $dealer_name;
    public $disbursement_date;
    public $form_type;
    public $branch_id;
    public $applicant_dob;
    public $gender;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['applicant_name', 'loan_type', 'phone_no'], 'required'],
            [['desired_tenure', 'company', 'company_type', 'business', 'annual_turnover', 'designation', 'business_premises', 'email', 'pan_number', 'aadhar_number', 'loan_lender',
                'address', 'city', 'state', 'zip', 'current_city', 'annual_income', 'occupation', 'vehicle_type', 'vehicle_option', 'ref_id', 'loan_amount', 'applicant_dob', 'gender',
                'vehicle_brand', 'vehicle_model', 'vehicle_making_year', 'lead_type', 'dealer_name', 'disbursement_date', 'form_type', 'branch_id', 'voter_card_number'], 'safe'],
            [['applicant_name', 'loan_purpose', 'email'], 'trim'],
            [['applicant_name'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 100],
            [['phone_no'], 'string', 'length' => [10, 15]],
            [['email'], 'email'],
        ];
    }

    // function to save loan application
    public function save($user_id)
    {
        // starting db transaction
        $transaction = Yii::$app->db->beginTransaction();
        try {

            // getting user type if user id not null
            $user_type = null;
            if ($user_id) {
                $user = Users::findOne(['user_enc_id' => $user_id]);
                $user_type = UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])->user_type;
            }

            // saving data in loan applications using extended model to save audit trails and data
            $model = new LoanApplicationsExtended();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->loan_app_enc_id = $utilitiesModel->encrypt();
            $model->had_taken_addmission = 0;
            $model->applicant_name = $this->applicant_name;
            $model->applicant_current_city = $this->current_city;
            $model->phone = $this->phone_no;
            $model->email = $this->email;
            $model->applicant_dob = $this->applicant_dob;
            $model->gender = $this->gender;
            $model->voter_card_number = $this->voter_card_number;
            $model->aadhaar_number = $this->aadhar_number;
            $model->pan_number = $this->pan_number;
            $model->amount = str_replace(',', '', $this->loan_amount);
            $model->source = 'EmpowerFintech';
            if ($this->form_type == 'diwali-dhamaka') {
                $model->form_type = $this->form_type;
            }

            // if loan lender then auto assigning lender to application
            if ($this->loan_lender) {
                $model->auto_assigned = 1;
            }
            $model->loan_type = $this->loan_type;
            $model->yearly_income = $this->annual_income;
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = $user_id;

            // assigning lead by id to ref id user enc id
            if ($this->ref_id) {
                $referralData = Referral::findOne(['code' => $this->ref_id]);
                if ($referralData) {

                    // if it's normal user then assigning user enc id
                    if ($referralData->user_enc_id) {
                        $model->lead_by = $referralData->user_enc_id;
                    }

                    // if it's organization then getting user id of this organization and assign it to lead by
                    if ($referralData->organization_enc_id) {
                        $model->lead_by = Users::findOne(['organization_enc_id' => $referralData->organization_enc_id])->user_enc_id;
                    }
                }
            }

            // if user type employee then setting lead by to employee user id
            if ($user_type == 'Employee') {
                $model->lead_by = $user_id;
            }

            if (!$model->save()) {
                $transaction->rollback();
                throw new \Exception(json_encode($model->getErrors()));
            }

            // if not empty loan purpose then saving it
            if (!empty($this->loan_purpose)) {

                // if not array making it into array
                if (!is_array($this->loan_purpose)) {
                    $this->loan_purpose = [$this->loan_purpose];
                }

                foreach ($this->loan_purpose as $p) {
                    $this->addPurpose($model->loan_app_enc_id, $user_id, $p);
                }
            }

            // saving other options if loan types are these
            if ($this->loan_type == 'Business Loan' || $this->loan_type == 'Personal Loan' || $this->loan_type == 'Vehicle Loan') {
                $loan_options = new LoanApplicationOptionsExtended();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
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
                $loan_options->vehicle_brand = $this->vehicle_brand;
                $loan_options->vehicle_model = $this->vehicle_model;
                $loan_options->vehicle_making_year = $this->vehicle_making_year;
                $loan_options->lead_type = $this->lead_type;
                $loan_options->dealer_name = $this->dealer_name;
                $loan_options->disbursement_date = $this->disbursement_date;
                $loan_options->created_on = date('Y-m-d H:i:s');
                $loan_options->created_by = $user_id;
                if (!$loan_options->save()) {
                    $transaction->rollback();
                    throw new \Exception(json_encode($loan_options->getErrors()));
                }
            }

            // saving address
            $loan_address = new LoanApplicantResidentialInfoExtended();
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
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
                throw new \Exception(json_encode($loan_address->getErrors()));
            }

            // assign lender to loan application
            if ($this->loan_lender) {
                $this->saveLender($model->loan_app_enc_id, $this->loan_lender, $user_id);
            }

            $data = [];
            $options['loan_app_id'] = $model->loan_app_enc_id;
            $options['name'] = $model->applicant_name;
            $options['phone'] = $model->phone;
            $options['email'] = $model->email;

            // if user id null or user submitting application without login
            if ($user_id == null) {

                $user = $this->SignUp($options);

                $access_token = $this->newToken($user->user_enc_id);
                $data['username'] = $user->username;
                $data['user_enc_id'] = $user->user_enc_id;
                $data['first_name'] = $user->first_name;
                $data['last_name'] = $user->last_name;
                $data['initials_color'] = $user->initials_color;
                $data['email'] = $user->email;
                $data['phone'] = $user->phone;
                $data['access_token'] = $access_token->access_token;
                $data['source'] = $access_token->source;
                $data['refresh_token'] = $access_token->refresh_token;
                $data['access_token_expiry_time'] = $access_token->access_token_expiration;
                $data['refresh_token_expiry_time'] = $access_token->refresh_token_expiration;
                $data['image'] = '';
                $data['user_type'] = 'Individual';
            }

            $user = Users::findOne(['phone' => [$model->phone, '+91' . $model->phone]]);
            if (empty($user)) {
                $this->SignUp($options);
            }

            // saving data in education loan payments right now it's waived off by default
            $payment_model = new EducationLoanPaymentsExtends();
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
                throw new \Exception(json_encode($payment_model->getErrors()));
            }

            $transaction->commit();

            $data['loan_app_enc_id'] = $model->loan_app_enc_id;
            $data['payment_url'] = null;
            $data['user_id'] = Users::findOne(['phone' => [$model->phone, '+91' . $model->phone]])->user_enc_id;

            return ['status' => 200, 'data' => $data];

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => json_decode($exception->getMessage(), true)];
        }
    }

    // private function to save loan purpose
    private function addPurpose($loan_id, $user_id, $p)
    {
        $purpose = new LoanPurposeExtended();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $purpose->loan_purpose_enc_id = $utilitiesModel->encrypt();
        $purpose->loan_app_enc_id = $loan_id;
        $purpose->financer_loan_purpose_enc_id = $p;
        $purpose->created_by = $user_id;
        $purpose->created_on = date('Y-m-d H:i:s');
        if (!$purpose->save()) {
            throw new \Exception(json_encode($purpose->getErrors()));
        }
    }

    // saving loan certificate
    private function saveCertificate($loan_id, $key, $val, $user_id = null)
    {
        $utilitiesModel = new Utilities();
        $certificate_type = CertificateTypes::findOne(['name' => $key]);

        // if certification type not exits then saving it into certificate type table
        if (!$certificate_type) {
            $certificate_type = new CertificateTypes();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $certificate_type->certificate_type_enc_id = $utilitiesModel->encrypt();
            $certificate_type->name = $key;
            if (!$certificate_type->save()) {
                throw new \Exception(json_encode($certificate_type->getErrors()));
            }
        }

        // if certificate type exists or after saving now saving main data
        $loanCertificate = new LoanCertificatesExtended();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $loanCertificate->certificate_enc_id = $utilitiesModel->encrypt();
        $loanCertificate->loan_app_enc_id = $loan_id;
        $loanCertificate->certificate_type_enc_id = $certificate_type->certificate_type_enc_id;
        $loanCertificate->number = $val;
        $loanCertificate->created_by = $user_id;
        $loanCertificate->created_on = date('Y-m-d H:i:s');
        if (!$loanCertificate->save()) {
            throw new \Exception(json_encode($loanCertificate->getErrors()));
        }
    }

    // assign lender to loan application
    private function saveLender($loan_id, $lender_slug, $user_id = null)
    {
        // finding organization from slug or organization id
        $organization = Organizations::find()->where(['or', ['slug' => $lender_slug], ['organization_enc_id' => $lender_slug],])->one();

        if (!$organization) {
            throw new \Exception(json_encode('lender not found'));
        }

        $loan_provider = new AssignedLoanProviderExtended();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $loan_provider->assigned_loan_provider_enc_id = $utilitiesModel->encrypt();
        $loan_provider->loan_application_enc_id = $loan_id;
        $loan_provider->provider_enc_id = $organization->organization_enc_id;
        $loan_provider->branch_enc_id = !empty($this->branch_id) ? $this->branch_id : null;
        if ($this->form_type == 'diwali-dhamaka') {
            $loan_provider->status = 31;
        }
        $loan_provider->created_by = $user_id;
        $loan_provider->created_on = date('Y-m-d H:i:s');
        if (!$loan_provider->save()) {
            throw new \Exception(json_encode($loan_provider->getErrors()));
        }
    }

    // updating loan application
    public function update($loan_id, $user_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new Utilities();
            $model = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $loan_id]);
            $model->applicant_current_city = $this->current_city;
            $model->email = $this->email ? $this->email : $model->email;
            $model->gender = $this->gender ? $this->gender : $model->gender;
            $model->aadhaar_number = $this->aadhar_number ? $this->aadhar_number : $model->aadhaar_number;
            $model->voter_card_number = $this->voter_card_number ? $this->voter_card_number : $model->voter_card_number;
            $model->pan_number = $this->pan_number ? $this->pan_number : $model->pan_number;
            $model->applicant_dob = $this->applicant_dob ? $this->applicant_dob : $model->applicant_dob;
            $model->loan_purpose = $this->loan_purpose ? $this->loan_purpose : $model->loan_purpose;
            $model->yearly_income = $this->annual_income ? $this->annual_income : $model->yearly_income;
            $model->updated_on = date('Y-m-d H:i:s');
            $model->updated_by = $user_id;
            if (!$model->update()) {
                $transaction->rollback();
                throw new \Exception(json_encode($model->getErrors()));
            }

            // saving other options
            if ($this->loan_type == 'Business Loan' || $this->loan_type == 'Personal Loan' || $this->loan_type == 'Vehicle Loan') {
                $loan_options = LoanApplicationOptionsExtended::findOne(['loan_app_enc_id' => $loan_id, 'is_deleted' => 0]);
                if (!$loan_options) {
                    $loan_options = new LoanApplicationOptionsExtended();
                    $loan_options->option_enc_id = $utilitiesModel->encrypt();
                    $loan_options->loan_app_enc_id = $model->loan_app_enc_id;
                    $loan_options->created_on = date('Y-m-d H:i:s');
                    $loan_options->created_by = $user_id;
                }

                $loan_options->name_of_company = $this->company ? $this->company : $loan_options->name_of_company;
                $loan_options->type_of_company = $this->company_type ? $this->company_type : $loan_options->type_of_company;
                $loan_options->nature_of_business = $this->business ? $this->business : $loan_options->nature_of_business;
                $loan_options->annual_turnover = $this->annual_turnover ? $this->annual_turnover : $loan_options->annual_turnover;
                $loan_options->business_premises = $this->business_premises ? $this->business_premises : $loan_options->business_premises;
                $loan_options->designation = $this->designation ? $this->designation : $loan_options->designation;
                $loan_options->occupation = $this->occupation ? $this->occupation : $loan_options->occupation;
                $loan_options->vehicle_type = $this->vehicle_type ? $this->vehicle_type : $loan_options->vehicle_type;
                $loan_options->vehicle_option = $this->vehicle_option ? $this->vehicle_option : $loan_options->vehicle_option;
                $loan_options->last_updated_on = date('Y-m-d H:i:s');
                $loan_options->last_updated_by = $user_id;
                if (!$loan_options->save()) {
                    $transaction->rollback();
                    throw new \Exception(json_encode($loan_options->getErrors()));
                }
            }

            // saving address
            $loan_address = LoanApplicantResidentialInfoExtended::findOne(['loan_app_enc_id' => $loan_id, 'is_deleted' => 0]);

            if (!$loan_address) {
                $loan_address = new LoanApplicantResidentialInfoExtended();
                $loan_address->loan_app_res_info_enc_id = $utilitiesModel->encrypt();
                $loan_address->loan_app_enc_id = $model->loan_app_enc_id;
                $loan_address->created_on = date('Y-m-d H:i:s');
                $loan_address->created_by = $user_id;
            } else {
                $loan_address->updated_on = date('Y-m-d H:i:s');
                $loan_address->updated_by = $user_id;
            }


            $loan_address->address = $this->address ? $this->address : $loan_address->address;
            $loan_address->city_enc_id = $this->city ? $this->city : $loan_address->city_enc_id;
            $loan_address->state_enc_id = $this->state ? $this->state : $loan_address->state_enc_id;
            $loan_address->postal_code = $this->zip ? $this->zip : $loan_address->postal_code;

            if (!$loan_address->save()) {
                $transaction->rollback();
                throw new \Exception(json_encode($loan_address->getErrors()));
            }

            $transaction->commit();

            $data = [];
            $data['loan_app_enc_id'] = $model->loan_app_enc_id;
            $data['payment_url'] = null;
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => json_decode($exception->getMessage(), true)];
        }
    }

    // converting amount RS to paisa for payment gateway
    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }

    // creating url for payment
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
        // finding user with email or phone
        $user = Users::find();
        if ($data['email']) {
            $user->where(['or', ['phone' => [$data['phone'], '+91' . $data['phone']]], ['email' => $data['email']]]);
        } else {
            $user->where(['phone' => [$data['phone'], '+91' . $data['phone']]]);
        }
        $user = $user->one();

        // if user already exists then assign user to loan application
        $loan_app = LoanApplications::findOne(['loan_app_enc_id' => $data['loan_app_id']]);
        if ($user) {
            $loan_app->created_by = $user->user_enc_id;
            if ($loan_app->update()) {
                return $user;
            } else {
                throw new \Exception(json_encode($loan_app->getErrors()));
            }

        } else {
            $data['id'] = $data['loan_app_id'];
            $data['phone'] = str_replace('+', '', $data['phone']);
            $user = $this->userAutoSignUp($data);
            $loan_app->created_by = $user->user_enc_id;
            if ($loan_app->update()) {
                return $user;
            } else {
                throw new \Exception(json_encode($loan_app->getErrors()));
            }

        }
    }

    // user auto-signup if not exists in DB
    public function userAutoSignUp($params)
    {
        $user_type = UserTypes::findOne(['user_type' => 'Individual']);

        if (!$user_type) {
            throw new \Exception(json_encode('user type not found'));
        }

        $username = $this->generate_username($params['name']);
        $password = $params['phone'];
        $arr = explode(' ', $params['name']);
        $first_name = $arr[0];
        $last_name = isset($arr[1]) ? $arr[1] . ' ' . ((isset($arr[2]) && !empty($arr[2])) ? $arr[2] : '') : null;
        if (empty($last_name)) {
            $last_name = null;
        }

        $usernamesModel = new Usernames();
        $usernamesModel->username = strtolower($username);
        $usernamesModel->assigned_to = 1;

        //if username exists then concat random string to username to create new one
        $username_exists = Usernames::findOne(['username' => $username]);
        if ($username_exists) {
            $usernamesModel->username = strtolower($username . Yii::$app->getSecurity()->generateRandomString(5));
        }

        if (!$usernamesModel->validate() || !$usernamesModel->save()) {
            throw new \Exception(json_encode($usernamesModel->getErrors()));
        }

        // saving/signup user
        $utilitiesModel = new Utilities();
        $usersModel = new Candidates();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $usersModel->user_enc_id = $utilitiesModel->encrypt();
        $usersModel->username = $usernamesModel->username;
        $usersModel->first_name = ucfirst(strtolower($first_name));
        $usersModel->last_name = ucfirst(strtolower($last_name));
        if ($params['email']) {
            $usersModel->email = strtolower($params['email']);
        }
        $usersModel->phone = $params['phone'];
        $usersModel->initials_color = RandomColors::one();
        $usersModel->user_type_enc_id = $user_type->user_type_enc_id;
        $usersModel->status = 'Active';
        $usersModel->last_visit = date('Y-m-d H:i:s');
        $usersModel->last_visit_through = 'EL';
        $usersModel->signed_up_through = 'EL';
        $usersModel->setPassword($password);
        $usersModel->generateAuthKey();
        if (!$usersModel->validate() || !$usersModel->save()) {
            throw new \Exception(json_encode($usersModel->getErrors()));
        }

        // generating and saving referral code for sign up user
        $this->addRef($usersModel->user_enc_id);
//        $this->autoSignupEmail($username, $password, $usersModel);

        return $usersModel;

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

    // generating username for auto signup
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

    // creating referral code for new sign up user
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

        throw new \Exception(json_encode($ref->getErrors()));
    }

    // generating random referral code
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

    // generating token for new sign up user
    private function newToken($user_id)
    {
        $source = Yii::$app->getRequest()->getUserIP();
        $token = new UserAccessTokens();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $time_now = date('Y-m-d H:i:s', time());
        $token->access_token_enc_id = $utilitiesModel->encrypt();
        $token->user_enc_id = $user_id;
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        $token->source = $source;
        if ($token->save()) {
            return $token;
        }
        throw new \Exception(json_encode($token->getErrors()));
    }

}