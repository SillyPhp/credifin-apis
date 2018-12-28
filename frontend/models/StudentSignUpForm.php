<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

class StudentSignUpForm extends Model {

    public $username;
    public $email;
    public $new_password;
    public $confirm_new_password;
    public $first_name;
    public $last_name;
    public $phone;
    public $countryCode;

    public function behaviors() {
        return [
            [
                'class' => PhoneInputBehavior::className(),
                'countryCodeAttribute' => 'countryCode',
            ],
        ];
    }

    public function rules() {
        return [
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_new_password'], 'required'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_new_password'], 'trim'],
            [['username', 'email'], 'string', 'max' => 50],
            [['new_password', 'confirm_new_password'], 'string', 'max' => 20],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['username'], 'match', 'pattern' => '/^[a-z]\w*$/i'],
            [['email'], 'email'],
            [['phone'], PhoneInputValidator::className()],
            [['confirm_new_password'], 'compare', 'compareAttribute' => 'new_password'],
            ['email', 'unique', 'targetClass' => Users::className(), 'message' => 'This email address has already been used.'],
            ['username', 'unique', 'targetClass' => Users::className(), 'message' => 'This username has already been taken.'],
        ];
    }

    public function attributeLabels() {
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

}
