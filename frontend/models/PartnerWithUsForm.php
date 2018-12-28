<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\PartnershipData;

class PartnerWithUsForm extends Model {

    public $name;
    public $email;
    public $phone;
    public $subject;
    public $company_name;
    public $message;

    public function rules() {
        return [
            [['name', 'email', 'subject', 'phone', 'message'], 'required'],
            [['email'], 'email'],
            [['phone'], 'match', 'pattern' => '/[0-9]{10}/'],
            [['name', 'email', 'subject', 'phone', 'message', 'company_name'], 'trim'],
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
            $partnershipData = new PartnershipData();
            $utilitiesModel = new Utilities();
            $partnershipData->name = $this->name;
            $partnershipData->email = $this->email;
            $partnershipData->phone = $this->phone;
            $partnershipData->subject = $this->subject;
            $partnershipData->organization_name = $this->company_name;
            $partnershipData->message = $this->message;
            $partnershipData->created_on = date('Y-m-d H:i:s');
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $partnershipData->request_enc_id = $utilitiesModel->encrypt();
            if ($partnershipData->validate() && $partnershipData->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


}
