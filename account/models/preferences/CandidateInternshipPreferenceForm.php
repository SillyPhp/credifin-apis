<?php

namespace account\models\preferences;

use common\models\Skills;
use common\models\UserPreferences;
use common\models\UserPreferredIndustries;
use common\models\UserPreferredJobProfile;
use common\models\UserPreferredLocations;
use common\models\UserPreferredSkills;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class CandidateInternshipPreferenceForm extends Model
{
    public $key_skills;
    public $location;
    public $industry;
    public $job_category;
    public $weekdays;
    public $weekoptsat;
    public $weekoptsund;
    public $from;
    public $to;
    public $job_type;

    public function rules() {
        return [
            [
                ['location', 'job_type', 'industry', 'job_category', 'weekdays', 'from', 'to'], 'required'],
                [['key_skills','weekoptsat','weekoptsund'],'safe']
            ];
    }

    public function attributeLabels() {
        return [
            'key_skills' => Yii::t('account', 'Key Skills'),
            'location' => Yii::t('account', 'Location'),
            'industry' => Yii::t('account', 'Industry'),
            'job_category' => Yii::t('account', 'Job Category'),
            'from' => Yii::t('account', 'From'),
            'to' => Yii::t('account', 'To'),
            'weekoptsat' => Yii::t('account', 'weekoptsat'),
            'weekoptsund' => Yii::t('account', 'weekoptsund'),
        ];
    }

    public function saveData() {

        $user_preference = new UserPreferences();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $user_preference->preference_enc_id = $utilitiesModel->encrypt();
        $user_preference->type = $this->job_type;
        $user_preference->experience = '0';
        $user_preference->min_expected_salary = 0;
        $user_preference->max_expected_salary = 0;
        $user_preference->assigned_to = "Internships";
        $user_preference->timings_from = date('H:i:s', strtotime($this->from));
        $user_preference->timings_to = date('H:i:s', strtotime($this->to));
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
                    return false;
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
                    return false;
                }
            }
            foreach ($this->key_skills as $skill) {
                $this->setSkills($skill,$user_preference->preference_enc_id);
            }
            foreach ($this->job_category as $job){
                $userpreferredJobsModel = new UserPreferredJobProfile();
                $userpreferredJobsModel->preference_enc_id = $user_preference->preference_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $userpreferredJobsModel->preferred_job_profile_enc_id = $utilitiesModel->encrypt();
                $userpreferredJobsModel->job_profile_enc_id = $job;
                $userpreferredJobsModel->created_on = date('Y-m-d h:i:s');
                $userpreferredJobsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if(!$userpreferredJobsModel->save()){
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function updateData() {
        $user_preference = UserPreferences::findOne(['created_by' => Yii::$app->user->identity->user_enc_id,'assigned_to'=>"Internships"]);
        $user_preference->type = $this->job_type;
        $user_preference->experience = '0';
        $user_preference->min_expected_salary = 0;
        $user_preference->max_expected_salary = 0;
        $user_preference->timings_from = date('H:i:s', strtotime($this->from));
        $user_preference->timings_to = date('H:i:s', strtotime($this->to));
        $user_preference->working_days = json_encode($this->weekdays);
        $user_preference->sat_frequency = $this->weekoptsat;
        $user_preference->sun_frequency = $this->weekoptsund;
        $user_preference->last_updated_on = date('Y-m-d H:i:s');
        $user_preference->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if ($user_preference->update()) {

            //update Location.
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
                        return false;
                    }
                }
            }

            //update Industry.
            $already_saved_industrry = UserPreferredIndustries::find()
                ->select(['industry_enc_id'])
                ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                ->andWhere(['is_deleted'=>0])
                ->asArray()
                ->all();

            $already_saved_industry = [];
            foreach ($already_saved_industrry as $ind){
                array_push($already_saved_industry,$ind['industry_enc_id']);
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
                        return false;
                    }
                }
            }

            //update Skills.
            $user_skill = UserPreferredSkills::find()
                ->select(['skill_enc_id'])
                ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();

            $userskill = [];
            foreach ($user_skill as $skill){
                array_push($userskill,$skill['skill_enc_id']);
            }

            $s_name = [];
            foreach ($user_skill as $skill_id){

                $skill_name = Skills::find()
                    ->select(['skill'])
                    ->where(['skill_enc_id'=>$skill_id])
                    ->asArray()
                    ->one();

                array_push($s_name,$skill_name['skill']);
            }

            $new_userskill_to_update = $this->key_skills;

            $to_be_added_userskill = array_diff($new_userskill_to_update, $s_name);
            $to_be_deleted_userskill = array_diff($s_name, $new_userskill_to_update);

            if(count($to_be_deleted_userskill) > 0) {
                foreach ($to_be_deleted_userskill as $del) {
                    $this->delSkills($del,$user_preference['preference_enc_id']);
                }
            }

            if(count($to_be_added_userskill) > 0) {
                foreach ($to_be_added_userskill as $skill) {
                    $this->setSkills($skill,$user_preference['preference_enc_id']);
                }
            }

            //update Job Profile.
            $user_job_profile = UserPreferredJobProfile::find()
                ->select(['job_profile_enc_id'])
                ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();

            $userjob = [];
            foreach ($user_job_profile as $jobp){
                array_push($userjob,$jobp['job_profile_enc_id']);
            }

            $to_be_added_userjob = array_diff($this->job_category, $userjob);
            $to_be_deleted_userjob = array_diff($userjob, $this->job_category);

            if(count($to_be_deleted_userjob) > 0) {
                foreach ($to_be_deleted_userjob as $del) {
                    $to_delete_userjob = UserPreferredJobProfile::find()
                        ->where(['job_profile_enc_id' => $del, 'preference_enc_id' => $user_preference['preference_enc_id']])
                        ->andWhere(['is_deleted' => 0])
                        ->one();

                    $to_delete_userjob->is_deleted = 1;
                    $to_delete_userjob->update();
                }
            }

            if(count($to_be_added_userjob) > 0) {
                foreach ($to_be_added_userjob as $job) {
                    $userpreferredJobsModel = new UserPreferredJobProfile();
                    $userpreferredJobsModel->preference_enc_id = $user_preference->preference_enc_id;
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $userpreferredJobsModel->preferred_job_profile_enc_id = $utilitiesModel->encrypt();
                    $userpreferredJobsModel->job_profile_enc_id = $job;
                    $userpreferredJobsModel->created_on = date('Y-m-d h:i:s');
                    $userpreferredJobsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if(!$userpreferredJobsModel->save()){
                        return false;
                    }
                }
            }
            return true;
        }else {
            return false;
        }
    }

    private function setSkills($skills,$preference_enc_id){

        $obj = new Skills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $chk = Skills::find()
            ->where(['skill' => $skills])
            ->asArray()
            ->one();

        if (empty($chk)) {
            $obj->skill_enc_id = $utilitiesModel->encrypt();
            $obj->skill = $skills;
            $obj->created_on = date('Y-m-d h:i:s');
            $obj->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$obj->save()) {
                return false;
            } else {
                $user_obj = new UserPreferredSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->preferred_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $obj->skill_enc_id;
                $user_obj->preference_enc_id = $preference_enc_id;
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$user_obj->save()) {
                    return false;
                }
            }
        } else {
            $chkk = UserPreferredSkills::find()
                ->where(['skill_enc_id' => $chk['skill_enc_id'],'is_deleted'=>0])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id,'preference_enc_id'=>$preference_enc_id])
                ->asArray()
                ->one();
            if (!$chkk) {
                $user_obj = new UserPreferredSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->preferred_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $chk['skill_enc_id'];
                $user_obj->preference_enc_id = $preference_enc_id;
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$user_obj->save()) {
                    return false;
                }
            }
        }
    }

    private function delSkills($skill,$user_preference){
        $skill_id = Skills::find()
            ->select(['skill_enc_id'])
            ->where(['skill'=>$skill])
            ->asArray()
            ->one();

        $to_delete_userskill = UserPreferredSkills::find()
            ->where(['skill_enc_id' => $skill_id['skill_enc_id'], 'preference_enc_id' => $user_preference])
            ->andWhere(['is_deleted' => 0])
            ->one();

        $to_delete_userskill->is_deleted = 1;
        $to_delete_userskill->update();
    }
}