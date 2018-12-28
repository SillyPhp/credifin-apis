<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Companies;

class CompanyProfileForm extends Model {

    public $email;
    public $phone;
    public $fax;
    public $website;
    public $social_links;
    public $instagram;
    public $google;
    public $linkedin;
    public $facebook;
    public $twitter;
    public $company_type;
    public $industry_type;
    public $description;
    public $vission;
    public $mission;
    public $values;
    

    public function rules() {
        return [
            [['email', 'phone', 'company_type', 'industry_type'], 'required'],
            [['email', 'phone', 'fax', 'website', 'company_type', 'industry_type', 'description'], 'trim'],
            [['description'], 'string'],
            [['vission'], 'string'],
            [['mission'], 'string'],
            [['values'], 'string'],
            [['website'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['phone', 'fax'], 'string', 'max' => 15],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['website'], 'url', 'defaultScheme' => 'http'],
            [['instagram'], 'url', 'defaultScheme' => 'http'],
            [['google'], 'url', 'defaultScheme' => 'http'],
            [['linkedin'], 'url', 'defaultScheme' => 'http'],
            [['facebook'], 'url', 'defaultScheme' => 'http'],
            [['twitter'], 'url', 'defaultScheme' => 'http'],
        ];
    }

    public function attributeLabels() {
        return[
            'id' => Yii::t('frontend', 'ID'),
            'emailid' => Yii::t('frontend', 'Email ID'),
            'contactnumber' => Yii::t('frontend', 'Contact Number'),
            'website' => Yii::t('frontend', 'Website'),
            'social_links' => Yii::t('frontend', 'Social Links'),
            'instagram' => Yii::t('frontend', 'Instagram'),
            'google' => Yii::t('frontend', 'Google'),
            'linkedin' => Yii::t('frontend', 'Linked In'),
            'facebook' => Yii::t('frontend', 'Facebook'),
            'twitter' => Yii::t('frontend', 'Twitter'),
            'companytype' => Yii::t('frontend', 'Company Type'),
            'industrytype' => Yii::t('frontend', 'Industry Type'),
            'companyoverview' => Yii::t('frontend', 'Company Overview'),
            'contactemail' => Yii::t('frontend', 'Contact Email'),
            'vission' => Yii::t('frontend', 'Vission'),
            'mission' => Yii::t('frontend', 'Mission'),
            'values' => Yii::t('frontend', 'Values'),
        ];
    }

    public function save() {
        if ($this->validate()) {
            $companiesModel = new Companies();
            $company = $companiesModel->find()
                    ->where(['organization_enc_id' => Yii::$app->user->identity->company->organization_enc_id])
                    ->one();
            $company->email = $this->email;
            $company->phone = $this->phone;
            $company->fax = $this->fax;
            $company->website = $this->website;
            $company->description = $this->description;
            if ($company->validate() && $company->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
