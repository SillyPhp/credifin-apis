<?php

namespace frontend\models;

use common\models\Usernames;
use common\models\Users;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use frontend\models\events\UserModel;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class AdmissionForm extends Model
{
    public $email;
    public $username;
    public $new_password;
    public $confirm_password;
    public $first_name;
    public $last_name;
    public $phone;
    public $countryCode;
    public $degree;
    public $course;
    public $college;
    public $preference_college1;
    public $preference_college2;
    public $preference_college3;
    public $field;
    public $amount;
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

    public function formName(){
        return '';
    }

    public function rules()
    {
        return [
            [['email','username','new_password','confirm_password','first_name','last_name','phone'], 'required'],
            [['email'], 'email'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_password'], 'trim'],
            [['username', 'email', 'first_name', 'last_name','phone', 'new_password', 'confirm_password'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['username'], 'string', 'length' => [3, 20]],
            [['new_password', 'confirm_password'], 'string', 'length' => [8, 20]],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            [['phone'], PhoneInputValidator::className()],
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password'],
            ['phone', 'unique', 'targetClass' => Users::className(), 'targetAttribute' => ['phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['email', 'unique', 'targetClass' => Users::className(), 'message' => 'This email address has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
        ];
    }
    public function save($degree, $course, $college, $field, $preference_college1,$preference_college2,$preference_college3){

    }
}