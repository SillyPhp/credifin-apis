<?php

namespace account\models\preferences;

use common\models\UserPreferences;
use common\models\UserPreferredIndustries;
use common\models\UserPreferredLocations;
use common\models\UserPreferredSkills;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class CandidatePreferenceForm extends Model
{
    public $key_skills;
    public $location;
    public $work_experience;
    public $industry;
    public $job_category;
    public $weekdays;
    public $weekoptsat;
    public $weekoptsund;
    public $from;
    public $to;
    public $job_type;
    public $assigned_too;
    public $interntype;
    public $salary_range;
    public $from_salary;
    public $to_salary;

    public function rules() {
        return [
            [
                ['key_skills', 'location', 'work_experience', 'salary_range', 'assigned_too', 'job_type', 'interntype', 'industry', 'job_category', 'weekdays', 'weekoptsat', 'weekoptsund', 'from', 'to', 'from_salary', 'to_salary'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'key_skills' => Yii::t('account', 'Key Skills'),
            'location' => Yii::t('account', 'Location'),
            'work_experience' => Yii::t('account', 'Work Experience'),
            'industry' => Yii::t('account', 'Industry'),
            'job_category' => Yii::t('account', 'Job Category'),
            'from' => Yii::t('account', 'From'),
            'to' => Yii::t('account', 'To'),
            'salary_range' => Yii::t('account', 'Salary Range'),
            'from_salary' => Yii::t('account', 'Salary from'),
            'to_salary' => Yii::t('account', 'Salary To'),
            'weekoptsat' => Yii::t('account', 'weekoptsat'),
            'weekoptsund' => Yii::t('account', 'weekoptsund'),
        ];
    }

    public function saveData() {

        $user_preference = new UserPreferences();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $user_preference->preference_enc_id = $utilitiesModel->encrypt();
        $user_preference->job_profile = $this->job_category;
        $user_preference->type = $this->job_type;
        $user_preference->assigned_to = $this->assigned_too;
        $user_preference->timings_from = date('H:i:s', strtotime($this->from));
        $user_preference->timings_to = date('H:i:s', strtotime($this->to));
        $min_max = explode(';', $this->salary_range);
        $user_preference->min_expected_salary = $min_max[0];
        $user_preference->max_expected_salary = $min_max[1];
        $user_preference->experience = $this->work_experience;
        $user_preference->working_days = json_encode($this->weekdays);
        $user_preference->sat_frequency = $this->weekoptsat;
        $user_preference->sun_frequency = $this->weekoptsund;
        $user_preference->created_on = date('Y-m-d h:i:s');
        $user_preference->created_by = Yii::$app->user->identity->user_enc_id;
        if ($user_preference->save()) {

            foreach (explode(',',$this->location) as $loc) {

                $userpreferredlocationsModel = new UserPreferredLocations();
                $userpreferredlocationsModel->preference_enc_id = $user_preference->preference_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $userpreferredlocationsModel->preferred_location_enc_id = $utilitiesModel->encrypt();
                $userpreferredlocationsModel->city_enc_id = $loc;
                $userpreferredlocationsModel->created_on = date('Y-m-d h:i:s');
                $userpreferredlocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$userpreferredlocationsModel->save()) {
                    print_r($userpreferredlocationsModel->getErrors());
                }
            }
            foreach (explode(',',$this->industry) as $indus) {
                $UserpreferredindustriesModel = new UserPreferredIndustries();
                $UserpreferredindustriesModel->preference_enc_id = $user_preference->preference_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $UserpreferredindustriesModel->preferred_industry_enc_id = $utilitiesModel->encrypt();
                $UserpreferredindustriesModel->industry_enc_id = $indus;
                $UserpreferredindustriesModel->created_on = date('Y-m-d h:i:s');
                $UserpreferredindustriesModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$UserpreferredindustriesModel->save()) {
                    print_r($UserpreferredindustriesModel->getErrors());
                }
            }
            foreach (explode(',',$this->key_skills) as $skill) {
                $userpreferredskillsModel = new UserPreferredSkills();
                $userpreferredskillsModel->preference_enc_id = $user_preference->preference_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $userpreferredskillsModel->preferred_skill_enc_id = $utilitiesModel->encrypt();
                $userpreferredskillsModel->skill_enc_id = $skill;
                $userpreferredskillsModel->created_on = date('Y-m-d h:i:s');
                $userpreferredskillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$userpreferredskillsModel->save()) {
                    print_r($userpreferredskillsModel->getErrors());
                }
            }
            return true;
        } else {
            print_r($user_preference->getErrors());
        }
    }

    public function updateData() {
        $user_preference = UserPreferences::findOne(['created_by' => Yii::$app->user->identity->user_enc_id,'assigned_to'=>$this->assigned_too]);
        $user_preference->job_profile = $this->job_category;
        $user_preference->type = $this->job_type;
        $user_preference->assigned_to = $this->assigned_too;
        $user_preference->timings_from = date('H:i:s', strtotime($this->from));
        $user_preference->timings_to = date('H:i:s', strtotime($this->to));
        $min_max = explode(';', $this->salary_range);
        $user_preference->min_expected_salary = $min_max[0];
        $user_preference->max_expected_salary = $min_max[1];
        $user_preference->experience = $this->work_experience;
        $user_preference->working_days = json_encode($this->weekdays);
        $user_preference->sat_frequency = $this->weekoptsat;
        $user_preference->sun_frequency = $this->weekoptsund;
        $user_preference->last_updated_on = date('Y-m-d H:i:s');
        $user_preference->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if ($user_preference->update()) {

            $already_saved_location = UserPreferredLocations::find()
                ->select(['city_enc_id'])
                ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                ->andWhere(['is_deleted'=>0])
                ->asArray()
                ->all();

            $already_saved_locations = [];
            foreach ($already_saved_location as $loc){
                array_push($already_saved_locations,$loc['city_enc_id']);
            }

            $new_location_to_update = explode(',',$this->location);

            $to_be_added_location = array_diff($new_location_to_update, $already_saved_locations);
            $to_be_deleted_location = array_diff($already_saved_locations, $new_location_to_update);

            if(count($to_be_deleted_location) > 0) {
                foreach ($to_be_deleted_location as $del) {
                    $to_delete = UserPreferredLocations::find()
                        ->where(['city_enc_id' => $del, 'preference_enc_id' => $user_preference['preference_enc_id']])
                        ->andWhere(['is_deleted' => 0])
                        ->one();

                    $to_delete->is_deleted = 1;
                    $to_delete->update();
                }
            }

            if(count($to_be_added_location) > 0) {
                foreach ($to_be_added_location as $loc) {

                    $userpreferredlocationsModel = new UserPreferredLocations();
                    $utilitiesModel = new Utilities();
                    $userpreferredlocationsModel->preference_enc_id = $user_preference['preference_enc_id'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $userpreferredlocationsModel->preferred_location_enc_id = $utilitiesModel->encrypt();
                    $userpreferredlocationsModel->city_enc_id = $loc;
                    $userpreferredlocationsModel->created_on = date('Y-m-d h:i:s');
                    $userpreferredlocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$userpreferredlocationsModel->save()) {
                        print_r($userpreferredlocationsModel->getErrors());
                    }
                }
            }


            $already_saved_industrry = UserPreferredIndustries::find()
                ->select(['industry_enc_id'])
                ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                ->andWhere(['is_deleted'=>0])
                ->asArray()
                ->all();

            $already_saved_industry = [];
            foreach ($already_saved_industrry as $ind){
                array_push($already_saved_industry,$ind);
            }

            $new_industry_to_update = explode(',',$this->industry);

            $to_be_added_industry = array_diff($new_industry_to_update, $already_saved_industry);
            $to_be_deleted_industry = array_diff($already_saved_industry, $new_industry_to_update);

            if(count($to_be_deleted_industry) > 0) {
                foreach ($to_be_deleted_industry as $del) {
                    $to_delete_indus = UserPreferredIndustries::find()
                        ->where(['industry_enc_id' => $del, 'preference_enc_id' => $user_preference['preference_enc_id']])
                        ->andWhere(['is_deleted' => 0])
                        ->one();

                    $to_delete_indus->is_deleted = 1;
                    $to_delete_indus->update();
                }
            }

            if(count($to_be_added_industry) > 0) {
                foreach ($to_be_added_industry as $indus) {

                    $UserpreferredindustriesModel = new UserPreferredIndustries();
                    $utilitiesModel = new Utilities();
                    $UserpreferredindustriesModel->preference_enc_id = $user_preference['preference_enc_id'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $UserpreferredindustriesModel->preferred_industry_enc_id = $utilitiesModel->encrypt();
                    $UserpreferredindustriesModel->industry_enc_id = $indus;
                    $UserpreferredindustriesModel->created_on = date('Y-m-d h:i:s');
                    $UserpreferredindustriesModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$UserpreferredindustriesModel->save()) {
                        print_r($UserpreferredindustriesModel->getErrors());
                    }
                }
            }


            $user_skill = UserPreferredSkills::find()
                ->select(['skill_enc_id'])
                ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();

            $userskill = [];
            foreach ($user_skill as $skill){
                array_push($userskill,$skill);
            }


            $new_userskill_to_update = explode(',',$this->key_skills);

            $to_be_added_userskill = array_diff($new_userskill_to_update, $userskill);
            $to_be_deleted_userskill = array_diff($userskill, $new_userskill_to_update);

            if(count($to_be_deleted_userskill) > 0) {
                foreach ($to_be_deleted_userskill as $del) {
                    $to_delete_userskill = UserPreferredSkills::find()
                        ->where(['skill_enc_id' => $del, 'preference_enc_id' => $user_preference['preference_enc_id']])
                        ->andWhere(['is_deleted' => 0])
                        ->one();

                    $to_delete_userskill->is_deleted = 1;
                    $to_delete_userskill->update();
                }
            }

            if(count($to_be_added_userskill) > 0) {
                foreach ($to_be_added_userskill as $skill) {

                    $userpreferredskillsModel = new UserPreferredSkills();
                    $utilitiesModel = new Utilities();
                    $userpreferredskillsModel->preference_enc_id = $user_preference['preference_enc_id'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $userpreferredskillsModel->preferred_skill_enc_id = $utilitiesModel->encrypt();
                    $userpreferredskillsModel->skill_enc_id = $skill;
                    $userpreferredskillsModel->created_on = date('Y-m-d h:i:s');
                    $userpreferredskillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$userpreferredskillsModel->save()) {
                        print_r($userpreferredskillsModel->getErrors());
                    }
                }
            }
            return true;
        }else {
            return false;
        }
    }
}