<?php

namespace frontend\models\accounts;

use Yii;
use yii\base\Model;
use common\models\RandomColors;
use common\models\Utilities;
use common\models\UserTypes;
use common\models\Users;
use common\models\Usernames;
use common\models\Organizations;
use common\models\BusinessActivities;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

class OrganizationSignUpForm extends Model
{

    public $username;
    public $email;
    public $new_password;
    public $confirm_password;
    public $first_name;
    public $last_name;
    public $phone;
    public $countryCode;
    public $organization_business_activity;
    public $organization_name;
    public $organization_email;
    public $organization_website;
    public $organization_phone;
    public $user_type;
    private $_flag = false;

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
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_password', 'organization_business_activity', 'organization_name', 'organization_email', 'organization_phone'], 'required'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_password', 'organization_business_activity', 'organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'trim'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_password', 'organization_business_activity', 'organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['organization_name'], 'string', 'max' => 100],
            [['username', 'email', 'organization_email'], 'string', 'max' => 50],
            [['new_password', 'confirm_password'], 'string', 'length' => [8, 20]],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone', 'organization_phone'], 'string', 'max' => 15],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            [['email', 'organization_email'], 'email'],
            [['organization_website'], 'url', 'defaultScheme' => 'http'],
            [['phone', 'organization_phone'], PhoneInputValidator::className()],
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password'],
            ['email', 'unique', 'targetClass' => Users::className(), 'message' => 'This email address has already been used.'],
            ['organization_email', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_email' => 'email'], 'message' => 'This email address has already been used.'],
            ['organization_phone', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['phone', 'unique', 'targetClass' => Users::className(), 'targetAttribute' => ['phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
            [['organization_business_activity'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['organization_business_activity' => 'business_activity_enc_id']],
            [['user_type'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::className(), 'targetAttribute' => ['user_type' => 'user_type']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('frontend', 'Organization Username'),
            'email' => Yii::t('frontend', 'Email'),
            'password' => Yii::t('frontend', 'Password'),
            'confirm_password' => Yii::t('frontend', 'Confirm Password'),
            'first_name' => Yii::t('frontend', 'First Name'),
            'last_name' => Yii::t('frontend', 'Last Name'),
            'phone' => Yii::t('frontend', 'Contact Number'),
            'organization_name' => Yii::t('frontend', 'Organization Name'),
            'organization_email' => Yii::t('frontend', 'Organization Email'),
            'organization_website' => Yii::t('frontend', 'Website'),
            'organization_phone' => Yii::t('frontend', 'Phone'),
            'organization_business_activity' => Yii::t('frontend', 'Business Activity'),
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
            $usernamesModel->assigned_to = 2;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                $transaction->rollBack();
                $this->_flag = false;
            } else {
                $this->_flag = true;
            }

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
            } else {
                $this->_flag = true;
            }

            if ($this->_flag) {
                $organizationsModel = new Organizations();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $organizationsModel->organization_enc_id = $utilitiesModel->encrypt();
                $organizationsModel->business_activity_enc_id = $this->organization_business_activity;
                $organizationsModel->name = $this->organization_name;
                $organizationsModel->email = $this->organization_email;
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
                    $transaction->rollBack();
                    $this->_flag = false;
                }

                $usersModel->organization_enc_id = $organizationsModel->organization_enc_id;
                if (!$usersModel->validate() || !$usersModel->update()) {
                    $transaction->rollBack();
                    $this->_flag = false;
                }
            }

            if ($this->_flag) {
                if(Yii::$app->organizationSignup->registrationEmail($organizationsModel->organization_enc_id)){
                    $transaction->commit();
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }

        if ($this->_flag) {
            Yii::$app->sitemap->generate();
            return true;
        } else {
            return false;
        }
    }

}