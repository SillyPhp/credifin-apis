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
    public $appliedCollege;
    public $amount;
    public $fee;
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
            [['email','first_name','last_name','phone','degree'], 'required'],
            [['email'], 'email'],
            [['fee','amount'], 'safe'],
            [['fee','amount'], 'integer'],
            [['email', 'first_name', 'last_name', 'phone'], 'trim'],
            [['email', 'first_name', 'last_name','phone'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['phone'], PhoneInputValidator::className()],
        ];
    }
    public function save($degree, $course, $college, $field, $preference_college1,$preference_college2,$preference_college3){

    }
}