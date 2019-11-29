<?php

namespace api\modules\v1\models;

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
        ];
    }

    public function forgotPassword()
    {
        if (!$this->validate()) {
            return false;
        }

        if (Yii::$app->forgotPassword->reset($this->email)) {
            return true;
        } else {
            return false;
        }
    }

}