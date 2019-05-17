<?php

namespace frontend\models\accounts;

use Yii;
use DateTime;
use yii\base\Model;
use common\models\Utilities;
use yii\base\InvalidParamException;
use common\models\Users;
use common\models\UserVerificationTokens;

class ResetPasswordForm extends Model
{

    public $new_password;
    public $confirm_password;
    private $_token;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['new_password', 'confirm_password',], 'required'],
            [['new_password', 'confirm_password',], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password'],
            [['new_password', 'confirm_password'], 'string', 'length' => [8, 20]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'new_password' => Yii::t('frontend', 'New Password'),
            'confirm_password' => Yii::t('frontend', 'Confirm Password'),
        ];
    }

}