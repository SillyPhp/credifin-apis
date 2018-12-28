<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model {

    public $first_name;
    public $last_name;
    public $email;
    public $subject;
    public $phone;
    public $message;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [['first_name', 'last_name', 'email', 'subject', 'phone', 'message'], 'required'],
            [['first_name', 'last_name', 'email', 'subject', 'phone', 'message'], 'trim'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'first_name' => Yii::t('frontend', 'First Name'),
            'last_name' => Yii::t('frontend', 'Last Name'),
            'email' => Yii::t('frontend', 'Email'),
            'phone' => Yii::t('frontend', 'Phone'),
            'message' => Yii::t('frontend', 'Message'),
            'verifyCode' => Yii::t('frontend', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact() {
        if (Yii::$app->mailer->compose('layouts/contact', [
                            'name' => $this->first_name . ' ' . $this->last_name,
                            'email' => $this->email,
                            'phone' => $this->phone,
                            'message' => $this->message,
                        ])
                        ->setTo('jyoti@empoweryouth.in')
                        ->setFrom([$this->email => $this->first_name . ' ' . $this->last_name])
                        ->setSubject($this->subject)
                        ->send()) {
            return true;
        } else {
            return false;
        }
    }

}
