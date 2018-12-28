<?php

namespace frontend\models\accounts;

use Yii;
use yii\base\Model;

class ForgotPasswordForm extends Model {

    public $email;
    
    public function formName() {
        return '';
    }

    public function rules() {
        return [
            [['email'], 'required'],
            [['email'], 'trim'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\extended\Users',
                'filter' => ['status' => 'Active', 'is_deleted' => 0],
                'message' => Yii::t('frontend', 'There is no user with this email address.'),
            ],
        ];
    }
    
    public function attributeLabels() {
        return [
            'email' => Yii::t('frontend', 'Email'),
        ];
    }

    public function forgotPassword() {
        if (!$this->validate()) {
            return false;
        }

        $userEmailsModel = new UserEmails();
        if ($userEmailsModel->resetPasswordEmail($this->email)) {
            return true;
        } else {
            return 'error';
        }
    }

}
