<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class JobsAlertForm extends Model {

    public $name;
    public $email;
    public $location;
    public $email_frequency;


    public function rules() {
        return [
            [['location', 'email', 'name','email_frequency'], 'required'],
            [['email', 'name'], 'trim'],
            [['email'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 30],
            [['email'], 'email'],
        ];
    }
//
//    public function attributeLabels() {
//        return [
//            'name' => Yii::t('frontend', 'Name'),
//            'email' => Yii::t('frontend', 'Email'),
//            'location' => Yii::t('frontend', 'Location'),
//        ];
//    }

}
