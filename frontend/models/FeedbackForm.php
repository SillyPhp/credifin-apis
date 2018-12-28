<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\FeedbackData;

class FeedbackForm extends Model {

    public $name;
    public $email;
    public $phone;
    public $subject;
    public $message;

    public function rules() {
        return [
            [['name', 'email', 'subject', 'message'], 'required'],
            [['email'], 'email'],
            [['phone'], 'match', 'pattern' => '/[0-9]{10}/'],
            [['name', 'email', 'subject', 'phone', 'message'], 'trim'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => Yii::t('frontend', 'Your Name'),
            'email' => Yii::t('frontend', 'Email Address'),
            'phone' => Yii::t('frontend', 'Phone Number'),
        ];
    }
    
    public function save() {
        if ($this->validate()) {
            $feedbackData = new FeedbackData();
            $utilitiesModel = new Utilities();
            $feedbackData->name = $this->name;
            $feedbackData->email = $this->email;
            $feedbackData->phone = $this->phone;
            $feedbackData->subject = $this->subject;
            $feedbackData->feedback = $this->message;
            $feedbackData->created_on = date('Y-m-d H:i:s');
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $feedbackData->feedback_enc_id = $utilitiesModel->encrypt();
            if ($feedbackData->validate() && $feedbackData->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}