<?php

namespace frontend\models\accounts;

use common\models\User;
use frontend\models\events\SignupEvent;
use frontend\models\events\UserModel;
use Yii;
use yii\base\Model;
use common\models\RandomColors;
use common\models\Utilities;
use common\models\UserTypes;
use common\models\Users;
use common\models\Usernames;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

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
            [['username'], 'match', 'pattern' => '/^[a-z]\w*$/i'],
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
            $usernamesModel->username = $this->username;
            $usernamesModel->assigned_to = 1;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                $transaction->rollBack();
                $this->_flag = false;
            } else {
                $this->_flag = true;
            }

            if ($this->_flag) {
                $utilitiesModel = new Utilities();
                $usersModel = new Users();
                $usersModel->username = $this->username;
                $usersModel->first_name = $this->first_name;
                $usersModel->last_name = $this->last_name;
                $usersModel->email = $this->email;
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
                    $transaction->rollBack();
                    $this->_flag = false;
                } else {
                    $this->_flag = true;
                }
            }

            if ($this->_flag) {
                if(Yii::$app->emailService->registrationEmail($usersModel->user_enc_id)){
                    $transaction->commit();
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }

        if ($this->_flag) {
            return true;
        } else {
            return false;
        }
    }

}