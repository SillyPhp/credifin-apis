<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\UserPreferences;
use common\models\UserPreferredLocations;

class ApplicationPreferenceForm extends Model {

    public $keyskills;
    public $location;
    public $work_expierence;
    public $expected_salary;
    public $industry;
    public $job_category;
    public $weekdays;
    public $weekoptsat;
    public $weekoptsund;
    public $from;
    public $to;
    public $jobtype;
    public $salary_range;

    public function rules() {
        return [
            [
                ['keyskills', 'location', 'work_expierence', 'salary_range', 'jobtype', 'expected_salary', 'industry', 'job_category', 'weekdays', 'weekoptsat', 'weekoptsund', 'from', 'to'], 'required'],
            [['expected_salary'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'keyskills' => Yii::t('frontend', 'KeySkills'),
            'location' => Yii::t('frontend', 'Location'),
            'work_expierence' => Yii::t('frontend', 'Work_Expierence'),
            'expected_salary' => Yii::t('frontend', 'Expected_Salary'),
            'industry' => Yii::t('frontend', 'Industry'),
            'job_category' => Yii::t('frontend', 'Job_Category'),
            'from' => Yii::t('frontend', 'From'),
            'to' => Yii::t('frontend', 'To'),
            'salary_range' => Yii::t('frontend', 'Salary Range'),
        ];
    }

    public function saveData() {
        foreach($this->location as $loc)
            {
                $location = explode(',', $loc);
            }
            
         
            
            
        $userpreferencesModel = new UserPreferences();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userpreferencesModel->preference_enc_id = $utilitiesModel->encrypt();
        $userpreferencesModel->job_profile = $this->job_category;
        $userpreferencesModel->type = $this->jobtype;
        $userpreferencesModel->timings_from = $this->from;
        $userpreferencesModel->timings_to = $this->to;
        $userpreferencesModel->salary = str_replace(',', '', $this->expected_salary);

        $min_max = explode(';', $this->salary_range);


        $userpreferencesModel->min_expected_salary = $min_max[0];
        $userpreferencesModel->max_expected_salary = $min_max[1];

        $userpreferencesModel->experience = $this->work_expierence;
        $userpreferencesModel->working_days = json_encode($this->weekdays);
        $userpreferencesModel->sat_frequency = $this->weekoptsat;
        $userpreferencesModel->sun_frequency = $this->weekoptsund;
        $userpreferencesModel->created_on = date('Y-m-d H:i:s');
        $userpreferencesModel->created_by = Yii::$app->user->identity->user_enc_id;

        if (!$userpreferencesModel->save()) {
            print_r($userpreferencesModel->getErrors());
        } else {

            $userpreferredlocationsModel = new UserPreferredLocations();
            $userpreferredlocationsModel->preference_enc_id = $userpreferencesModel->preference_enc_id;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userpreferredlocationsModel->preferred_location_enc_id = $utilitiesModel->encrypt();
            $userpreferredlocationsModel->city_enc_id = $this->location;
            $userpreferredlocationsModel->created_on = date('Y-m-d H:i:s');
            $userpreferredlocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
            
             exit();
            if (!$userpreferredlocationsModel->save()) {
                print_r($userpreferredlocationsModel->getErrors());
            }
        }
    }

}
