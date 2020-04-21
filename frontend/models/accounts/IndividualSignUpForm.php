<?php

namespace frontend\models\accounts;

use common\models\EmailLogs;
use Yii;
use yii\base\Model;
use common\models\RandomColors;
use common\models\Utilities;
use common\models\UserTypes;
use common\models\Users;
use common\models\Usernames;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use frontend\models\events\SignupEvent;
use frontend\models\events\UserModel;
use frontend\models\referral\Referral;

class IndividualSignUpForm extends Model
{

    public $username;
    public $email;
    public $new_password;
    public $confirm_password;
    public $first_name;
    public $last_name;
    public $phone;
    public $countryCode;
    public $user_type;
    public $_flag;

    public function behaviors()
    {
        return [
            [
                'class' => PhoneInputBehavior::className(),
                'countryCodeAttribute' => 'countryCode',
            ],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_password'], 'required'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_password'], 'trim'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_password'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['username'], 'string', 'length' => [3, 20]],
            [['new_password', 'confirm_password'], 'string', 'length' => [8, 20]],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            [['email'], 'email'],
            [['phone'], PhoneInputValidator::className()],
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password'],
            ['email', 'unique', 'targetClass' => Users::className(), 'message' => 'This email address has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
            ['phone', 'unique', 'targetClass' => Users::className(), 'targetAttribute' => ['phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            [['user_type'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::className(), 'targetAttribute' => ['user_type' => 'user_type']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('frontend', 'Username'),
            'email' => Yii::t('frontend', 'Email'),
            'password' => Yii::t('frontend', 'Password'),
            'confirm_password' => Yii::t('frontend', 'Confirm Password'),
            'first_name' => Yii::t('frontend', 'First Name'),
            'last_name' => Yii::t('frontend', 'Last Name'),
            'phone' => Yii::t('frontend', 'Contact Number'),
        ];
    }

    public function add()
    {
        if (!$this->validate()) {
            return false;
        }

        $user_type = UserTypes::findOne([
            'user_type' => $this->user_type,
        ]);

        if (!$user_type) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $usernamesModel = new Usernames();
            $usernamesModel->username = strtolower($this->username);
            $usernamesModel->assigned_to = 1;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                $this->_flag = false;
                $transaction->rollBack();
                return false;
            } else {
                $this->_flag = true;
            }

            if ($this->_flag) {
                $utilitiesModel = new Utilities();
                $usersModel = new Users();
                $usersModel->username = strtolower($this->username);
                $usersModel->first_name = ucfirst(strtolower($this->first_name));
                $usersModel->last_name = ucfirst(strtolower($this->last_name));
                $usersModel->email = strtolower($this->email);
                $usersModel->phone = $this->phone;
                $usersModel->initials_color = RandomColors::one();
                $utilitiesModel->variables['password'] = $this->new_password;
                $usersModel->password = $utilitiesModel->encrypt_pass();
                $usersModel->user_type_enc_id = $user_type->user_type_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $usersModel->user_enc_id = $utilitiesModel->encrypt();
                $usersModel->auth_key = Yii::$app->security->generateRandomString();
                $usersModel->status = 'Active';
                if (!$usersModel->validate() || !$usersModel->save()) {
                    $this->_flag = false;
                    $transaction->rollBack();
                    return false;
                }
            }

            if ($this->_flag) {
                $referralModel = new \common\models\crud\Referral();
                $referralModel->user_enc_id = $referralModel->created_by = $usersModel->user_enc_id;

                if (!$referralModel->create()) {
                    $this->_flag = false;
                    $transaction->rollBack();
                    return false;
                } else {
                    $this->_flag = true;
                }
            }

            if ($this->_flag) {
                Yii::$app->individualSignup->registrationEmail($usersModel->user_enc_id);
                $mail = Yii::$app->mail;
                $mail->receivers = [];
                $mail->receivers[] = [
                    "name" => $this->first_name ." " . $this->last_name,
                    "email" => $this->email,
                ];
                $mail->subject = 'Welcome to Empower Youth';
                $mail->template = 'thank-you';
                if($mail->send()){
                    $mail_logs = new EmailLogs();
                    $utilitesModel = new Utilities();
                    $utilitesModel->variables['string'] = time() . rand(100, 100000);
                    $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
                    $mail_logs->email_type = 5;
                    $mail_logs->user_enc_id = $usersModel->user_enc_id;
                    $mail_logs->receiver_name = $usersModel->first_name ." " . $usersModel->last_name;
                    $mail_logs->receiver_email = $usersModel->email;
                    $mail_logs->receiver_phone = $usersModel->phone;
                    $mail_logs->subject = 'Welcome to Empower Youth';
                    $mail_logs->template = 'thank-you';
                    $mail_logs->is_sent = 1;
                    $mail_logs->save();
                }

                Referral::widget(['user_id' => $usersModel->user_enc_id]);
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

}