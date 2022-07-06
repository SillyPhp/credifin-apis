<?php

namespace api\modules\v4\models;

use common\models\EmailLogs;
use common\models\Organizations;
use common\models\Referral;
use common\models\SelectedServices;
use common\models\Services;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\UserTypes;
use common\models\RandomColors;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class OrganizationSignup extends Model
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

    public function rules()
    {
        return [
            [['username', 'email', 'first_name', 'last_name', 'phone', 'password', 'organization_name', 'organization_email', 'organization_phone'], 'required'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'password', 'organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'trim'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'password', 'organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['organization_name'], 'string', 'max' => 100],
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
            ['organization_email', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_email' => 'email'], 'message' => 'This email address has already been used.'],
            ['organization_phone', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['phone', 'unique', 'targetClass' => Candidates::className(), 'targetAttribute' => ['phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
            ['source', 'required']
        ];
    }

    public function add()
    {

        $user_type = UserTypes::findOne([
            'user_type' => 'Organization Admin',
        ]);

        if (!$user_type) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $usernamesModel = new Usernames();
            $usernamesModel->username = strtolower($this->username);
            $usernamesModel->assigned_to = 2;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                $transaction->rollback();
                return false;
            }

            $utilitiesModel = new Utilities();
            $usersModel = new Candidates();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $usersModel->user_enc_id = $utilitiesModel->encrypt();
            $usersModel->username = strtolower($this->username);
            $usersModel->first_name = ucfirst(strtolower($this->first_name));
            $usersModel->last_name = ucfirst(strtolower($this->last_name));
            $usersModel->email = strtolower($this->email);
            $usersModel->phone = $this->phone;
            $usersModel->initials_color = RandomColors::one();
            $usersModel->user_type_enc_id = $user_type->user_type_enc_id;
            $usersModel->status = 'Active';
            $usersModel->last_visit = date('Y-m-d H:i:s');
            $usersModel->last_visit_through = 'EL';
            $usersModel->signed_up_through = 'EL';
            $usersModel->setPassword($this->password);
            $usersModel->generateAuthKey();

            if (!$usersModel->validate() || !$usersModel->save()) {
                $transaction->rollback();
                return false;
            }

            $organizationsModel = new Organizations();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organizationsModel->organization_enc_id = $utilitiesModel->encrypt();
            $organizationsModel->name = $this->organization_name;
            $organizationsModel->email = strtolower($this->organization_email);
            $organizationsModel->initials_color = RandomColors::one();
            $organizationsModel->phone = $this->organization_phone;
            $organizationsModel->website = $this->organization_website;
            $organizationsModel->created_on = date('Y-m-d H:i:s');
            $organizationsModel->created_by = $usersModel->user_enc_id;
            $utilitiesModel->variables['name'] = $usersModel->username;
            $utilitiesModel->variables['table_name'] = Organizations::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $organizationsModel->slug = $utilitiesModel->create_slug();
            $organizationsModel->status = 'Active';
            if (!$organizationsModel->validate() || !$organizationsModel->save()) {
                $transaction->rollback();
                return false;
            }

            $usersModel->organization_enc_id = $organizationsModel->organization_enc_id;
            if (!$usersModel->validate() || !$usersModel->update()) {
                $transaction->rollback();
                return false;
            }

            $ref_code = $this->addRef($organizationsModel->organization_enc_id, $usersModel->user_enc_id);
            if (!$ref_code) {
                $transaction->rollback();
                return false;
            }

            if (!$this->addService($organizationsModel->organization_enc_id, $usersModel->user_enc_id)) {
                $transaction->rollback();
                return false;
            }

            $transaction->commit();

            $data['username'] = $usersModel->username;
            $data['user_enc_id'] = $usersModel->user_enc_id;
            $data['first_name'] = $usersModel->first_name;
            $data['last_name'] = $usersModel->last_name;
            $data['initials_color'] = $usersModel->initials_color;
            $data['phone'] = $usersModel->phone;
            $data['email'] = $usersModel->email;
            $data['referral_code'] = $ref_code;
            $data['organization_name'] = $organizationsModel->name;
            $data['organization_slug'] = $organizationsModel->slug;
            $data['organization_enc_id'] = $organizationsModel->organization_enc_id;
            $data['user_type'] = 'DSA';
            $data['access_token'] = '';
            $data['source'] = '';
            $data['refresh_token'] = '';
            $data['access_token_expiry_time'] = '';
            $data['refresh_token_expiry_time'] = '';
            $data['image'] = '';

            if ($token = $this->newToken($usersModel->user_enc_id, $this->source)) {
                $data['access_token'] = $token->access_token;
                $data['source'] = $token->source;
                $data['refresh_token'] = $token->refresh_token;
                $data['access_token_expiry_time'] = $token->access_token_expiration;
                $data['refresh_token_expiry_time'] = $token->refresh_token_expiration;
            }

            return $data;

        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    private function addRef($organization_id, $user_id)
    {
        $ref = new Referral();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $ref->referral_enc_id = $utilitiesModel->encrypt();
        $ref->code = $ref->referral_link = $this->_getReferralCode();
        $ref->organization_enc_id = $organization_id;
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

    private function addService($organization_id, $user_id)
    {
        $service_id = Services::findOne(['name' => 'E-Partners'])->service_enc_id;

        $service = new SelectedServices();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $service->selected_service_enc_id = $utilitiesModel->encrypt();
        $service->service_enc_id = $service_id;
        $service->organization_enc_id = $organization_id;
        $service->created_on = date('Y-m-d H:i:s');
        $service->created_by = $user_id;
        if (!$service->save()) {
            return false;
        }

        return true;
    }

    private function newToken($user_id, $source)
    {
        $token = new UserAccessTokens();
        $time_now = date('Y-m-d H:i:s');
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
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
        return false;
    }

    private function sendMail($organizationsModel, $usersModel)
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