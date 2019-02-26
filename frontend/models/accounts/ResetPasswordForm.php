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
        ];
    }

    public function attributeLabels()
    {
        return [
            'new_password' => Yii::t('frontend', 'New Password'),
            'confirm_password' => Yii::t('frontend', 'Confirm Password'),
        ];
    }

    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }

        $this->_token = UserVerificationTokens::findOne([
            'token' => $token,
            'verification_type' => 'reset password',
            'status' => 'Pending',
            'is_deleted' => 0,
        ]);

        if (!$this->_token) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        $date_expire = $this->_token->created_on;
        $date = new DateTime($date_expire);
        $now = new DateTime();
        $res = $date->diff($now);
        $year = $res->y * (365 * 60 * 60 * 24);
        $month = $res->m * (30 * 60 * 60 * 24);
        $day = $res->d * (60 * 60 * 24);
        $hour = $res->h * (60 * 60);
        $minute = $res->i * 60;
        $second = $res->s;
        $result = $year + $month + $day + $hour + $minute + $second;
        if ($result > Yii::$app->params->expiration_time->reset_password) {
            throw new InvalidParamException('Password reset token has expired.');
        }
        parent::__construct($config);
    }


    public function resetPassword()
    {
        $utilitiesModel = new Utilities();
        $this->_token->created_by;
        $user = Users::findOne([
            'user_enc_id' => $this->_token->created_by,
            'status' => 'Active',
            'is_deleted' => 0,
        ]);
        if (!empty($user)) {
            $utilitiesModel->variables['password'] = $this->new_password;
            $this->new_password = $utilitiesModel->encrypt_pass();
        } else {
            return false;
        }
        $user->password = $this->new_password;
        if (!$user->validate() || !$user->save()) {
            return false;
        } else {
            return true;
        }
        if ($user) {
            $user->is_email_verified = 1;
            if ($user->update()) {
                $this->_token->status = 'Verified';
                $this->_token->is_deleted = 1;
                $this->_token->update();
            }
        }
    }

}