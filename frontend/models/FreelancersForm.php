<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\FreelancersData;

class FreelancersForm extends Model {

    public $first_name;
    public $last_name;
    public $job_profile;
    public $email;
    public $phone;
    public $description;
    public $job_profile2;
    public $portfolio;
    public $skills;

    public function rules() {
        return [
            [['first_name', 'last_name', 'job_profile', 'email', 'phone', 'skills', 'description'], 'required'],
            [['first_name', 'last_name', 'job_profile', 'job_profile2', 'email', 'phone', 'description', 'portfolio', 'skills'], 'trim'],
            [['email'], 'email'],
            [['portfolio'], 'url', 'defaultScheme' => 'http'],
            [['description', 'skills'], 'string'],
            [['portfolio'], 'string', 'max' => 100],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['first_name', 'last_name', 'job_profile', 'job_profile2'], 'string', 'max' => 50],
            [
                ['job_profile2'], 'required', 'when' => function ($model, $attribute) {
                    return $model->job_profile == 'Others';
                }, 'whenClient' => "function (attribute, value) {
                        return $('#job_profile').val() == 'Others';
                }"
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'first_name' => Yii::t('frontend', 'First Name'),
            'last_name' => Yii::t('frontend', 'Last Name'),
            'email' => Yii::t('frontend', 'Email'),
            'phone' => Yii::t('frontend', 'Phone'),
            'job_profile' => Yii::t('frontend', 'Job Profile'),
            'job_profile2' => Yii::t('frontend', 'Job Profile'),
            'description' => Yii::t('frontend', 'Description'),
            'portfolio' => Yii::t('frontend', 'Share Your Portfolio Link'),
            'skills' => Yii::t('frontend', 'Skills'),
        ];
    }

    public function save() {
        if ($this->validate()) {
            $freelancersDataModel = new FreelancersData();
            $utilitiesModel = new Utilities();
            $freelancersDataModel->first_name = $this->first_name;
            $freelancersDataModel->last_name = $this->last_name;
            $freelancersDataModel->email = $this->email;
            $freelancersDataModel->phone = $this->phone;
            $freelancersDataModel->portfolio = $this->portfolio;
            $freelancersDataModel->description = $this->description;
            $freelancersDataModel->skills = $this->skills;
            if ($this->job_profile == 'Others') {
                $freelancersDataModel->job_type = $this->job_profile2;
            } else {
                $freelancersDataModel->job_type = $this->job_profile;
            }
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $freelancersDataModel->freelancer_data_enc_id = $utilitiesModel->encrypt();
            $freelancersDataModel->created_on = date('Y-m-d H:i:s');
            if ($freelancersDataModel->validate() && $freelancersDataModel->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
