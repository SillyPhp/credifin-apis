<?php

namespace account\models\recruiter;
use common\models\Organizations;
use common\models\Usernames;
use Yii;
use yii\base\Model;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
class AddCompany extends Model
{
    public $username;
    public $created_by;
    public $phone;
    public $countryCode;
    public $organization_name;
    public $organization_email;
    public $organization_website;
    public $organization_phone;
    public $description;

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
            [['username','created_by','organization_name', 'organization_email', 'organization_phone'], 'required'],
            [['username','created_by','description','organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'trim'],
            [['username','description','organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['organization_name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 300],
            [['username'], 'string', 'length' => [3, 20]],
            [['organization_email'], 'string', 'max' => 50],
            [['organization_phone'], 'string', 'max' => 15],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            [['organization_email'], 'email'],
            [['organization_website'], 'url', 'defaultScheme' => 'http'],
            [['organization_phone'], PhoneInputValidator::className()],
            ['organization_email', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_email' => 'email'], 'message' => 'This email address has already been used.'],
            ['organization_phone', 'unique', 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
        ];
    }


}