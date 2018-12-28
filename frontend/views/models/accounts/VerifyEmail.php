<?php

namespace frontend\models\accounts;

use Yii;
use DateTime;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\Users;
use common\models\UserVerificationTokens;

class VerifyEmail extends Model {

    public $new_password;
    public $confirm_new_password;
    private $_token;
    
    public function formName() {
        return '';
    }

    public function rules() {
        return [
            [['new_password', 'confirm_new_password',], 'required'],
            [['confirm_new_password'], 'compare', 'compareAttribute' => 'new_password'],
        ];
    }

    public function attributeLabels() {
        return [
            'new_password' => Yii::t('frontend', 'New Password'),
            'confirm_new_password' => Yii::t('frontend', 'Confirm New Password'),
        ];
    }

    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Email verification code cannot be blank.');
        }

        $this->_token = UserVerificationTokens::findOne([
                    'token' => $token,
                    'verification_type' => 'email verification',
                    'status' => 'Pending',
                    'is_deleted' => 0,
        ]);

        if (!$this->_token) {
            throw new InvalidParamException('Invalid verification code.');
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
        if ($result > Yii::$app->params->expiration_time->email_verification) {
            throw new InvalidParamException('Verification link has expired.');
        }
        parent::__construct($config);
    }

    public function emailVerification() {
        $organization_id = $this->_token->organization_enc_id;
        if ($organization_id) {
            $organization = Organizations::findOne([
                        'organization_enc_id' => $organization_id,
                        'status' => 'Active',
                        'is_email_verified' => 0,
                        'is_deleted' => 0,
            ]);

            if ($organization) {
                $organization->is_email_verified = 1;
                $organization->last_updated_on = date('Y-m-d H:i:s');
                $organization->last_updated_by = $this->_token->created_by;
                if (!$organization->update()) {
                    throw new HttpException(404, Yii::t('frontend', 'An Error has occurred. Please try again.'));
                }
            }
        }

        $user = Users::findOne([
                    'user_enc_id' => $this->_token->created_by,
                    'is_email_verified' => 0,
                    'status' => 'Active',
                    'is_deleted' => 0,
        ]);

        if ($user) {
            $user->is_email_verified = 1;
            $user->last_updated_on = date('Y-m-d H:i:s');
            if ($user->update()) {
                $this->_token->status = 'Verified';
                $this->_token->is_deleted = 1;
                $this->_token->last_updated_on = date('Y-m-d H:i:s');
                $this->_token->last_updated_by = $this->_token->created_by;
                $this->_token->update();
                return true;
            } else {
                return false;
            }
        }
    }

}
