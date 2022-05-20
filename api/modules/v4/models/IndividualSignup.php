<?php

namespace api\modules\v4\models;

use common\models\EmailLogs;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\UserTypes;
use common\models\RandomColors;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class IndividualSignup extends Model
{

    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $username;
    public $password;
    public $source;


    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'username', 'email'], 'required'],
            [['first_name', 'last_name', 'phone', 'username', 'email'], 'trim'],

            ['phone', 'unique', 'targetClass' => 'api\modules\v4\models\Candidates', 'message' => 'phone number already registered'],

            [['username'], 'string', 'length' => [3, 20]],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            ['username', 'unique', 'targetClass' => 'api\modules\v4\models\Candidates', 'message' => 'username already taken'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'api\modules\v4\models\Candidates', 'message' => 'email already taken'],

            ['password', 'required'],
            [['password'], 'string', 'length' => [8, 20]],

            ['source', 'required']
        ];
    }

    public function saveUser()
    {

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new Candidates();
            $username = new Usernames();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);

            $username->username = $this->username;
            $username->assigned_to = 1;
            if (!$username->validate() || !$username->save()) {
                $transaction->rollback();
                return false;
            }

            $user->username = $this->username;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->phone = preg_replace("/\s+/", "", $this->phone);
            $user->email = $this->email;
            $user->user_enc_id = $utilitiesModel->encrypt();
            $user->user_type_enc_id = UserTypes::findOne(['user_type' => 'Individual'])->user_type_enc_id;
            $user->initials_color = RandomColors::one();
            $user->created_on = date('Y-m-d H:i:s', strtotime('now'));
            $user->status = 'Active';
            $user->last_visit = date('Y-m-d H:i:s');
            $user->last_visit_through = 'EL';
            $user->signed_up_through = 'EL';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if (!$user->save()) {
                $transaction->rollback();
                return false;
            }

            if (!$this->addRef($user->user_enc_id)) {
                $transaction->rollback();
                return false;
            }

            $transaction->commit();

            $data['username'] = $user->username;
            $data['user_enc_id'] = $user->user_enc_id;
            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['initials_color'] = $user->initials_color;
            $data['phone'] = $user->phone;
            $data['email'] = $user->email;
            $data['user_type'] = 'Individual';
            $data['access_token'] = '';
            $data['source'] = '';
            $data['refresh_token'] = '';
            $data['access_token_expiry_time'] = '';
            $data['refresh_token_expiry_time'] = '';
            $data['image'] = '';

            if ($token = $this->newToken($user->user_enc_id, $this->source)) {
                $data['access_token'] = $token->access_token;
                $data['source'] = $token->source;
                $data['refresh_token'] = $token->refresh_token;
                $data['access_token_expiry_time'] = $token->access_token_expiration;
                $data['refresh_token_expiry_time'] = $token->refresh_token_expiration;
            }

            return $data;

        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
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
            return true;
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

}