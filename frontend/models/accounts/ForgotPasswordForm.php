<?php

namespace frontend\models\accounts;

use common\models\Organizations;
use common\models\Users;
use Yii;
use yii\base\Model;

class ForgotPasswordForm extends Model
{

    public $email;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'trim'],
            ['email', 'email'],
            ['email', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
//            ['email', 'exist',
//                'targetClass' => '\common\models\extended\Users',
//                'filter' => ['status' => 'Active', 'is_deleted' => 0],
//                'message' => Yii::t('frontend', 'There is no user with this email address.'),
//            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('frontend', 'Email'),
        ];
    }

    private function validateEmail($email){
        $org = Organizations::find()
            ->where(['email' => $email])
            ->exists();
        if($org){
            return true;
        }
        $user = Users::find()
            ->where(['email' => $email, 'status' => 'Active', 'is_deleted' => 0])
            ->exists();
        if($user){
            return true;
        }
        return false;
    }

    public function forgotPassword()
    {
        if (!$this->validate()) {
            return false;
        }
        if(!$this->validateEmail($this->email)){
            return 'User Not Exist';
        }
        if (Yii::$app->forgotPassword->reset($this->email)) {
            return true;
        } else {
            return false;
        }
    }

}