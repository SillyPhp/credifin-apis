<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Cities;
use common\models\JobsData;

class CareerForm extends Model {

    public $job_title;
    public $designation;
    public $job_profile;
    public $salary;
    public $ctc;
    public $city;
    public $experience;
    public $company_name;
    public $job_profile2;

    public function rules() {
        return [
            [['job_title', 'designation', 'job_profile', 'salary', 'city', 'experience'], 'required'],
            [['job_title', 'designation', 'job_profile', 'job_profile2', 'salary', 'ctc', 'city', 'experience', 'company_name'], 'trim'],
            [['salary', 'ctc', 'experience'], 'integer'],
            [['city', 'company_name'], 'string', 'max' => 100],
            [['job_title', 'designation', 'job_profile', 'job_profile2'], 'string', 'max' => 50],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city' => 'city_enc_id']],
            [
                ['job_profile2'], 'required', 'when' => function ($model, $attribute) {
                    return $model->job_profile == 'Others' || $model->job_profile == 'LC' || $model->job_profile == 'Government Jobs';
                }, 'whenClient' => "function (attribute, value) {
                        return $('#job_profile').val() == 'Others' || $('#job_profile').val() == 'LC' || $('#job_profile').val() == 'Government Jobs';;
                }"
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'job_title' => Yii::t('frontend', 'Job Title'),
            'designation' => Yii::t('frontend', 'Designation'),
            'job_profile' => Yii::t('frontend', 'Job Profile'),
            'job_profile2' => Yii::t('frontend', 'Job Profile'),
            'salary' => Yii::t('frontend', 'Salary'),
            'ctc' => Yii::t('frontend', 'CTC'),
            'city' => Yii::t('frontend', 'City'),
            'experience' => Yii::t('frontend', 'Experience'),
            'company_name' => Yii::t('frontend', 'Company Name'),
        ];
    }

    public function save() {
        if ($this->validate()) {
            $jobsDataModel = new JobsData();
            $utilitiesModel = new Utilities();
            $jobsDataModel->job_title = $this->job_title;
            $jobsDataModel->designation = $this->designation;
            $jobsDataModel->salary = $this->salary;
            $jobsDataModel->ctc = $this->ctc;
            $jobsDataModel->city_enc_id = $this->city;
            $jobsDataModel->experience = $this->experience;
            $jobsDataModel->company_name = $this->company_name;
            if($this->job_profile == 'Others' || $this->job_profile == 'LC' || $this->job_profile == 'Government Jobs') {
                $jobsDataModel->job_profile = $this->job_profile2;
            } else {
                $jobsDataModel->job_profile = $this->job_profile;
            }
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $jobsDataModel->career_data_enc_id = $utilitiesModel->encrypt();
            if ($jobsDataModel->validate() && $jobsDataModel->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
