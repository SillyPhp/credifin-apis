<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class SignUpInvitationForm extends Model {

    public $email;

    public function rules() {
        return [
            [['email'], 'email'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => Yii::t('frontend', 'Email Address'),
        ];
    }


}
