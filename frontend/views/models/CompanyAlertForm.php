<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class CompanyAlertForm extends Model {

    public $firstname;
    public $lastname;
    public $email;
    public $location;
   


    public function rules() {
        return [
            [['location', 'email', 'firstname','lastname'], 'required'],
            [['email', 'name'], 'trim'],
            [['email'], 'string', 'max' => 50],
            [['firstname','lastname'], 'string', 'max' => 30],
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
