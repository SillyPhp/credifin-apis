<?php

namespace api\modules\v4\models;

use api\modules\v4\controllers\DealersController;
use api\modules\v4\controllers\DealsController;
use common\models\AssignedDealerBrands;
use common\models\AssignedDealerOptions;
use common\models\AssignedDealerVehicleTypes;
use common\models\AssignedSupervisor;
use common\models\BankDetails;
use common\models\EmailLogs;
use common\models\FinancerVehicleTypes;
use common\models\Organizations;
use common\models\RandomColors;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\SelectedServices;
use common\models\Services;
use common\models\spaces\Spaces;
use common\models\Usernames;
use common\models\UserRoles;
use common\models\Users;
use common\models\UserTypes;
use common\models\Utilities;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

// this signup form is used to signup users with type Individual, Financer, Employee, DSA, Dealer, Connector
class SignupForm extends Model
{
    public $organization_name;
    public $organization_email;
    public $organization_website;
    public $organization_phone;
    public $username;
    public $email;
    public $phone;
    public $first_name;
    public $last_name;
    public $password;
    public $source;
    public $ref_id;
    public $user_type;
    public $user_id;
    public $organization_id;
    public $employee_code;
    public $vehicle_type;
    public $brands;
    public $category;
    public $dealer_type;
    public $account_name;
    public $bank_name;
    public $account_number;
    public $ifsc_code;
//    public $company_type;
    public $trade_certificate;

    // rules for form
    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'phone', 'password', 'source'], 'required'],
            [['organization_name', 'organization_email', 'organization_phone'], 'required', 'on' => 'Financer'],
            [['employee_code'], 'required', 'when' => function () {
                return $this->user_type == 'Employee';
            }],
            [['organization_name', 'category', 'trade_certificate', 'dealer_type'], 'required', 'on' => 'FinancerDealer'],

            [['username', 'email', 'vehicle_type', 'brands', 'first_name', 'last_name', 'phone', 'password', 'organization_name', 'ifsc_code', 'account_number', 'bank_name', 'account_name', 'organization_email', 'organization_phone', 'organization_website', 'ref_id', 'user_type'], 'trim'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'password', 'organization_name', 'organization_email', 'organization_phone', 'organization_website', 'ref_id', 'user_type'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['organization_name'], 'string', 'max' => 100],
//            [['vehicle_type', 'brands'], function () {
//                if (!is_array($this->brands) && !is_array($this->vehicle_type)) {
//                    $this->addError('vehicle_type', 'It must be an array!');
//                    $this->addError('brands', 'It must be an array!');
//                }
//            }],
            [['username'], 'string', 'length' => [3, 20]],
            [['email', 'organization_email'], 'string', 'max' => 100],
            [['password'], 'string', 'length' => [8, 20]],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['first_name', 'last_name'], 'match', 'pattern' => '/^([A-Z a-z])+$/', 'message' => 'Name can only contain alphabets'],
            [['phone', 'organization_phone'], 'string', 'max' => 15],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            [['email', 'organization_email'], 'email'],
            [['organization_website'], 'url', 'defaultScheme' => 'http'],
            ['email', 'unique', 'targetClass' => Candidates::className(), 'message' => 'This email address has already been used.'],
            ['employee_code', 'unique', 'targetClass' => UserRoles::className(), 'message' => 'This employee_code has already been used.'],
            ['organization_email', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_email' => 'email'], 'message' => 'This email address has already been used.'],
            ['organization_phone', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['phone', 'unique', 'targetClass' => Candidates::className(), 'targetAttribute' => ['phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
        ];
    }

    public function formName()
    {
        return '';
    }

    // saving data
    public function save()
    {
        // if user type is Employee or Dealer it will be saved as it is PA0iwUzc4y
        if ($this->user_type == 'Financer') {
            // if user_type is financer its type will be saved as Organization Admin and for financer (Loans) service assigned in selected_services
            $user_type = 'Organization Admin';
        } else {
            // else type will be individual for DSA without organization name, Connector and Individual user. for connector (Connector) service  assigned in selected_services
            $user_type = !empty($this->user_type) ? $this->user_type : 'Individual';
        }

        // transaction begin
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // saving username for user
            $this->saveUsername($user_type);
            // saving user data
            $user = new Candidates();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $this->user_id = $user->user_enc_id = $utilitiesModel->encrypt();
            $user->username = strtolower($this->username);
            $user->first_name = ucfirst(strtolower($this->first_name));
            $user->last_name = ucfirst(strtolower($this->last_name));
            $user->phone = preg_replace("/\s+/", "", $this->phone);
            $user->email = $this->email ? strtolower($this->email) : null;
            $user->initials_color = RandomColors::one();
            $user->user_type_enc_id = UserTypes::findOne(['user_type' => $user_type])->user_type_enc_id;
            $user->status = ($user_type == 'Individual' || $this->getScenario() == 'FinancerDealer') ? 'Active' : 'Pending';
            $user->created_on = date('Y-m-d H:i:s', strtotime('now'));
            $user->last_visit = date('Y-m-d H:i:s');
            $user->last_visit_through = 'EL';
            $user->signed_up_through = 'EL';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if (!$user->save()) {
                $transaction->rollback();
                throw new \Exception(json_encode($user->getErrors()));
            }

            // if user_type Organization Admin or Organization name not empty for dealer user_type
            if ($user_type == 'Organization Admin' || (!empty($this->organization_name))) {

                // saving organization data
                $this->organization_id = $this->saveOrganization($user);

                // assigning organization id to user
                $user->organization_enc_id = $this->organization_id;

                $query = (new FinancerVehicleTypeForm)->vehicleType($user, $this->organization_id);
                if (!$user->update()) {
                    throw new \Exception(json_encode($user->getErrors()));
                }
            }

            if ($this->getScenario() == 'Dealer' || $this->getScenario() == 'FinancerDealer') {
                $this->dealerCreate($this->organization_id);
            }

            // adding Referral code for new signed-up user
            $this->addReferralCode();

            // signup tracking with ref id
            if (!empty($this->ref_id)) {
                $this->signupTracking();
            }

            // if user_type Employee or Dealer then saving user role for them
            if (($user_type == 'Employee' || $user_type == 'Dealer') && !empty($this->ref_id)) {
                $this->addUserRole($user->user_type_enc_id);
            }

            // if user_type financer, DSA, Connector then services for them
            if ($this->user_type == 'Financer' || $this->user_type == 'DSA' || $this->user_type == 'Connector') {
                $this->addService();
            }

            // commiting code
            $transaction->commit();
            return ['status' => 201, 'user_id' => $user->user_enc_id];

        } catch (\Exception $exception) {
            $transaction->rollback();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }

    private function dealerCreate($organization_id)
    {
        $ref = Referral::findOne(['code' => $this->ref_id]);
        if (!$ref['organization_enc_id']) {
            throw new \Exception(json_encode('Organization not found'));
        }

        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);

        $options = new AssignedDealerOptions();
        $options->assigned_dealer_options_enc_id = $utilitiesModel->encrypt();
        $options->organization_enc_id = $ref['organization_enc_id'];
        $options->category = $this->category;
        if ($this->dealer_type == 'vehicle') {
            $options->dealer_type = 0;
        } else if ($this->dealer_type == 'electronics') {
            $options->dealer_type = 1;
        } else {
            throw new \Exception('Invalid dealer_type value');
        }

        $options->trade_certificate = $this->trade_certificate ? 1 : 0;
        $options->created_on = $options->updated_on = date('Y-m-d H:i:s');
        $options->created_by = $options->updated_by = $this->user_id;
        if (!$options->save()) {
            throw new \Exception(json_encode($options->getErrors()));
        }

        if ($this->bank_name && $this->account_number && $this->account_name && $this->ifsc_code) {
            $bankDetails = new BankDetails();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $bankDetails->bank_details_enc_id = $utilitiesModel->encrypt();
            $bankDetails->name = $this->account_name;
            $bankDetails->bank_name = $this->bank_name;
            $bankDetails->bank_account_number = $this->account_number;
            $bankDetails->ifsc_code = $this->ifsc_code;
            $bankDetails->created_on = $bankDetails->updated_on = date('Y-m-d H:i:s');
            $bankDetails->created_by = $bankDetails->updated_by = $this->user_id;
            if (!$bankDetails->save()) {
                throw new \Exception(json_encode($bankDetails->getErrors()));
            }
        } else {
            if ($this->bank_name || $this->account_number || $this->account_name || $this->ifsc_code) {
                throw new \Exception('please fill all bank details');
            }
        }


        if ($this->dealer_type == 0 && is_array($this->brands)) {
            foreach ($this->brands as $value) {
                $brand = new AssignedDealerBrands();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $brand->assigned_dealer_brands_enc_id = $utilitiesModel->encrypt();
                $brand->organization_enc_id = $ref['organization_enc_id'];
                $brand->financer_vehicle_brand_enc_id = $value;
                $brand->created_on = $brand->updated_on = date('Y-m-d H:i:s');
                $brand->created_by = $brand->updated_by = $this->user_id;
                if (!$brand->save()) {
                    throw new \Exception(json_encode($brand->getErrors()));
                }
            }
        }

        if ($this->dealer_type == 0 && is_array($this->vehicle_type)) {
            foreach ($this->vehicle_type as $value) {
                $type = new FinancerVehicleTypes();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $type->financer_vehicle_type_enc_id = $utilitiesModel->encrypt();
                $type->organization_enc_id = $organization_id;
                $type->vehicle_type = $value;
                $type->created_on = $type->updated_on = date('Y-m-d H:i:s');
                $type->created_by = $type->updated_by = $this->user_id;
                if (!$type->save()) {
                    throw new \Exception(json_encode($type->getErrors()));
                }
            }
        }
    }


    // saving username data
    private function saveUsername($user_type)
    {
        $username = new Usernames();
        $username->username = strtolower($this->username);
        $username->assigned_to = ($user_type == 'Organization Admin') ? 2 : 1;
        if (!$username->validate() || !$username->save()) {
            throw new \Exception(json_encode($username->getErrors()));
        }
    }

    // saving organization data
    private function saveOrganization($user)
    {
        $organizationsModel = new Organizations();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $organizationsModel->organization_enc_id = $utilitiesModel->encrypt();
        $organizationsModel->name = $this->organization_name;
        $organizationsModel->email = !empty($this->organization_email) ? strtolower($this->organization_email) : strtolower($user->email);
        $organizationsModel->phone = !empty($this->organization_phone) ? $this->organization_phone : $user->phone;
        $organizationsModel->website = $this->organization_website;
        $organizationsModel->initials_color = RandomColors::one();
        $organizationsModel->created_on = date('Y-m-d H:i:s');
        $organizationsModel->created_by = $user->user_enc_id;
        $utilitiesModel->variables['name'] = $user->username;
        $utilitiesModel->variables['table_name'] = Organizations::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $organizationsModel->slug = $utilitiesModel->create_slug();


        $logo = UploadedFile::getInstanceByName('dealer_logo');
        if ($logo) {
            $organizationsModel->logo_location = \Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->organizations->logo . $organizationsModel->logo_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organizationsModel->logo = $utilitiesModel->encrypt() . '.' . $logo->extension;
            $type = $logo->type;
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($logo->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $organizationsModel->logo, "public", ['params' => ['ContentType' => $type]]);
            if (!$result) {
                throw new \Exception('Failed to upload logo');
            }
        }

        if (!$organizationsModel->save()) {
            throw new \Exception(implode(", ", \yii\helpers\ArrayHelper::getColumn($organizationsModel->errors, 0, false)));
        }

        return $organizationsModel->organization_enc_id;
    }

    // adding referral code for new signed-up user
    private function addReferralCode()
    {
        $referral = new Referral();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $referral->referral_enc_id = $utilitiesModel->encrypt();
        $referral->code = $referral->referral_link = $this->_getReferralCode();
        !empty($this->organization_id) ? $referral->organization_enc_id = $this->organization_id : $referral->user_enc_id = $this->user_id;
        $referral->created_by = $this->user_id;
        $referral->created_on = date('Y-m-d H:i:s');
        if (!$referral->save()) {
            throw new \Exception(json_encode($referral->getErrors()));
        }
    }

    // generating referral code
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

    // signup tracking to check with whom referral code user signed-up
    private function signupTracking()
    {
        $referralData = Referral::findOne(['code' => $this->ref_id]);

        $tracking = new ReferralSignUpTracking();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $tracking->tracking_signup_enc_id = $utilitiesModel->encrypt();
        $tracking->referral_enc_id = $referralData->referral_enc_id;
        !empty($this->organization_id) ? $tracking->sign_up_org_enc_id = $this->organization_id : $tracking->sign_up_user_enc_id = $this->user_id;
        $tracking->created_on = date('Y-m-d H:i:s');
        if (!$tracking->save()) {
            throw new \Exception(json_encode($tracking->getErrors()));
        }
    }

    // adding user role in user roles table for Employee and Dealer
    private function addUserRole($user_type_id)
    {
        $ref = Referral::findOne(['code' => $this->ref_id]);

        if (!empty($ref)) {
            $user_role = new UserRoles();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $user_role->role_enc_id = $utilitiesModel->encrypt();
            $user_role->user_type_enc_id = $user_type_id;
            $user_role->user_enc_id = $this->user_id;
            $user_role->organization_enc_id = $ref->organization_enc_id;
            if ($this->user_type == 'Employee') {
                $user_role->employee_code = $this->employee_code;
            }
            $user_role->created_by = $this->user_id;
            $user_role->created_on = date('Y-m-d H:i:s');
            if (!$user_role->save()) {
                throw new \Exception(json_encode($user_role->getErrors()));
            }
        }

    }

    // adding service for Financer, DSA and Connector
    private function addService()
    {
        $assigned_id = null;
        if (!empty($this->ref_id)) {
            // getting referral data from ref_id for connector. connector can be referred by DSA or Financer
            $referralData = Referral::findOne(['code' => $this->ref_id]);

            // if referral data user id not empty
            if (!empty($referralData->user_enc_id)) {
                $assigned_id = $referralData->user_enc_id;
            }

            // if referral data organization id not empty
            if (!empty($referralData->organization_enc_id)) {
                $assigned_id = Users::findOne(['organization_enc_id' => $referralData->organization_enc_id])->user_enc_id;
            }
        }

        // if user_type financer then service will be Loans
        if ($this->user_type == 'Financer') {
            $service = 'Loans';
        } elseif ($this->user_type == 'DSA') {

            // if user_type DSA then service will be E-Partners
            $service = 'E-Partners';

            // assigning supervisor to dsa if ref id not empty
            if (!empty($this->ref_id)) {
                $this->assignedSupervisor();
                $this->assignedSupervisor('Lead Source');
            }
        } elseif ($this->user_type == 'Connector') {
            // if user_type Connector then service will be Connector
            $service = $this->user_type;
        }

        $service_id = Services::findOne(['name' => $service])->service_enc_id;

        $selected_service = new SelectedServices();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $selected_service->selected_service_enc_id = $utilitiesModel->encrypt();
        $selected_service->service_enc_id = $service_id;
        $selected_service->organization_enc_id = !empty($this->organization_id) ? $this->organization_id : null;
        $selected_service->assigned_user = ($service == 'Connector' && $assigned_id != null) ? $assigned_id : null;
        $selected_service->created_on = date('Y-m-d H:i:s');
        $selected_service->created_by = $this->user_id;
        if (!$selected_service->save()) {
            throw new \Exception(json_encode($selected_service->getErrors()));
        }
    }

    // assigning supervisor to DSA
    public function assignedSupervisor($role = 'Manager')
    {
        $referralData = Referral::findOne(['code' => $this->ref_id]);

        $assignedSuper = new AssignedSupervisor();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $assignedSuper->assigned_enc_id = $utilitiesModel->encrypt();
        $assignedSuper->supervisor_enc_id = Users::findOne(['organization_enc_id' => $referralData->organization_enc_id])->user_enc_id;
        !empty($this->organization_id) ? $assignedSuper->assigned_organization_enc_id = $this->organization_id : $assignedSuper->assigned_user_enc_id = $this->user_id;
        $assignedSuper->is_supervising = 1;
        $assignedSuper->supervisor_role = $role;
        $assignedSuper->created_on = date('Y-m-d H:i:s');
        $assignedSuper->created_by = $this->user_id;
        if (!$assignedSuper->save()) {
            throw new \Exception(json_encode($assignedSuper->getErrors()));
        }
    }


    private function sendMail($userId)
    {
        $mail = Yii::$app->mail;
        $mail->receivers = [];
        $mail->receivers[] = [
            "name" => $this->first_name . " " . $this->last_name,
            "email" => $this->email,
        ];
        $mail->subject = 'Welcome to My eCampus';
        $mail->template = 'mec-thank-you';
        if ($mail->send()) {
            $mail_logs = new EmailLogs();
            $utilitesModel = new Utilities();
            $utilitesModel->variables['string'] = time() . rand(100, 100000);
            $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
            $mail_logs->email_type = 5;
            $mail_logs->user_enc_id = $userId;
            $mail_logs->receiver_name = $this->first_name . " " . $this->last_name;
            $mail_logs->receiver_email = $this->email;
            $mail_logs->receiver_phone = $this->phone;
            $mail_logs->subject = 'Welcome to My eCampus';
            $mail_logs->template = 'mec-thank-you';
            $mail_logs->is_sent = 1;
            $mail_logs->save();
        }
    }

    private function sendOrgMail($organizationsModel, $usersModel)
    {
        Yii::$app->organizationSignup->registrationEmail($organizationsModel->organization_enc_id);
        $mail = Yii::$app->mail;
        $mail->receivers = [];
        $mail->receivers[] = [
            "name" => $this->organization_name,
            "email" => $this->organization_email,
        ];
        $mail->subject = 'Welcome to Empower Youth';
        $mail->template = 'thank-you';
        if ($mail->send()) {
            $mail_logs = new EmailLogs();
            $utilitesModel = new Utilities();
            $utilitesModel->variables['string'] = time() . rand(100, 100000);
            $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
            $mail_logs->email_type = 5;
            $mail_logs->organization_enc_id = $organizationsModel->organization_enc_id;
            $mail_logs->user_enc_id = $usersModel->user_enc_id;
            $mail_logs->receiver_name = $organizationsModel->name;
            $mail_logs->receiver_email = $usersModel->email;
            $mail_logs->receiver_phone = $usersModel->phone;
            $mail_logs->subject = 'Welcome to Empower Youth';
            $mail_logs->template = 'thank-you';
            $mail_logs->is_sent = 1;
            $mail_logs->save();
        }
    }

}