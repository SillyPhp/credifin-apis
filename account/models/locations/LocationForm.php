<?php

namespace account\models\locations;

use Yii;
use yii\base\Model;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use common\models\Utilities;
use account\models\locations\OrganizationLocations;

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
    public $location_for;
    private $_flag = false;

    public function formName() {
        return '';
    }

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
            [['name', 'address', 'city', 'state', 'longitude', 'location_for'], 'required'],
            ['email', 'email'],
            [['latitude'], 'required', 'message' => 'Get The Location First'],
            [['latitude', 'longitude'], 'number'],
            [['email', 'name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['postal_code'], 'string', 'max' => 7],
            [['phone'], PhoneInputValidator::className()],
        ];
    }

    public function attributeLabels() {
        return[
            'name' => Yii::t('account', 'Location Name'),
            'address' => Yii::t('account', 'Address'),
            'city' => Yii::t('account', 'City'),
            'state' => Yii::t('account', 'State'),
            'postal_code' => Yii::t('account', 'Postal Code'),
            'email' => Yii::t('account', 'Email'),
            'phone' => Yii::t('account', 'Phone'),
            'latitude' => Yii::t('account', 'Latitude'),
            'longitude' => Yii::t('account', 'Longitude'),
        ];
    }

    public function add() {
        if (!$this->validate()) {
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $organizationLocationsModel = new OrganizationLocations();
            $utilitiesModel = new Utilities();
            $organizationLocationsModel->location_name = $this->name;
            $organizationLocationsModel->email = $this->email;
            $organizationLocationsModel->phone = $this->phone;
            $organizationLocationsModel->address = $this->address;
            $organizationLocationsModel->city_enc_id = $this->city;
            $organizationLocationsModel->latitude = $this->latitude;
            $organizationLocationsModel->longitude = $this->longitude;
            $organizationLocationsModel->location_for = json_encode($this->location_for);
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organizationLocationsModel->location_enc_id = $utilitiesModel->encrypt();
            $organizationLocationsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
            $organizationLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
            $organizationLocationsModel->created_on = date('Y-m-d H:i:s');
            if (!$organizationLocationsModel->validate() || !$organizationLocationsModel->save()) {
                $transaction->rollBack();
                $this->_flag = false;
            } else {
                $this->_flag = true;
            }

            if ($this->_flag) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        if ($this->_flag) {
            return true;
        } else {
            return false;
        }
    }

}
