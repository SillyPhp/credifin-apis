<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

class LocationForm extends Model {

    public $name;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $phone;
    public $email;
    public $latitude;
    public $longitude;
    public $countryCode;
    public $location_type;

    public function behaviors() {
        return [
            [
                'class' => PhoneInputBehavior::className(),
                'countryCodeAttribute' => 'countryCode',
            ],
        ];
    }

    public function rules() {
        return [
            [['name', 'address', 'city', 'state', 'postal_code', 'latitude', 'longitude'], 'required'],
            ['email', 'email'],
            [['latitude', 'longitude'], 'number'],
            [['email', 'address'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['postal_code'], 'string', 'max' => 7],
            [['name'], 'string', 'max' => 100],
            [['phone'], PhoneInputValidator::className()],
        ];
    }

    public function attributeLabels() {
        return[
            'name' => Yii::t('frontend', 'Name'),
            'address' => Yii::t('frontend', 'Address'),
            'city' => Yii::t('frontend', 'City'),
            'state' => Yii::t('frontend', 'State'),
            'postal_code' => Yii::t('frontend', 'Postal Code'),
            'email' => Yii::t('frontend', 'Email'),
            'phone' => Yii::t('frontend', 'Phone'),
            'latitude' => Yii::t('frontend', 'Latitude'),
            'longitude' => Yii::t('frontend', 'Longitude'),
        ];
    }

}
