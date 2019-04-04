<?php

namespace account\models\preferences;

use Yii;
use yii\base\Model;

class CandidatePreferenceForm extends Model
{
    public $keyskills;
    public $location;
    public $work_expierence;
    public $industry;
    public $job_category;
    public $weekdays;
    public $weekoptsat;
    public $weekoptsund;
    public $from;
    public $to;
    public $jobtype;
    public $interntype;
    public $salary_range;
    public $from_salary;
    public $to_salary;

    public function rules() {
        return [
            [
                ['keyskills', 'location', 'work_expierence', 'salary_range', 'jobtype', 'interntype', 'industry', 'job_category', 'weekdays', 'weekoptsat', 'weekoptsund', 'from', 'to', 'from_salary', 'to_salary'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'keyskills' => Yii::t('account', 'KeySkills'),
            'location' => Yii::t('account', 'Location'),
            'work_expierence' => Yii::t('account', 'Work_Expierence'),
//            'expected_salary' => Yii::t('account', 'Expected_Salary'),
            'industry' => Yii::t('account', 'Industry'),
            'job_category' => Yii::t('account', 'Job_Category'),
            'from' => Yii::t('account', 'From'),
            'to' => Yii::t('account', 'To'),
            'salary_range' => Yii::t('account', 'Salary Range'),
            'from_salary' => Yii::t('account', 'Salary From'),
            'to_salary' => Yii::t('account', 'Salary to'),
        ];
    }

    public function saveData() {
        $user_preference = new UserPreferences();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $user_preference->preference_enc_id = $utilitiesModel->encrypt();
        $user_preference->job_profile = $this->job_category;
        $user_preference->type = $this->jobtype;
        $user_preference->timings_from = date('H:i:s', strtotime($this->from));
        $user_preference->timings_to = date('H:i:s', strtotime($this->to));

//        $user_preference->salary = str_replace(',', '', $this->expected_salary);

        $min_max = explode(';', $this->salary_range);
        $user_preference->min_expected_salary = $min_max[0];
        $user_preference->max_expected_salary = $min_max[1];
        $user_preference->experience = $this->work_expierence;
        $user_preference->working_days = json_encode($this->weekdays);
        $user_preference->sat_frequency = $this->weekoptsat;
        $user_preference->sun_frequency = $this->weekoptsund;
        $user_preference->created_on = date('Y-m-d h:i:s');
        $user_preference->created_by = Yii::$app->user->identity->user_enc_id;
        if ($user_preference->save()) {

            foreach (json_decode($this->location) as $loc) {

                $userpreferredlocationsModel = new UserPreferredLocations();
                $userpreferredlocationsModel->preference_enc_id = $user_preference->preference_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $userpreferredlocationsModel->preferred_location_enc_id = $utilitiesModel->encrypt();
                $userpreferredlocationsModel->city_enc_id = $loc->id;
                $userpreferredlocationsModel->created_on = date('Y-m-d h:i:s');
                $userpreferredlocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$userpreferredlocationsModel->save()) {
                    print_r($userpreferredlocationsModel->getErrors());
                }
            }
            foreach (json_decode($this->industry) as $indus) {
                $UserpreferredindustriesModel = new UserPreferredIndustries();
                $UserpreferredindustriesModel->preference_enc_id = $user_preference->preference_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $UserpreferredindustriesModel->preferred_industry_enc_id = $utilitiesModel->encrypt();
                $UserpreferredindustriesModel->industry_enc_id = $indus->id;
                $UserpreferredindustriesModel->created_on = date('Y-m-d h:i:s');
                $UserpreferredindustriesModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$UserpreferredindustriesModel->save()) {
                    print_r($UserpreferredindustriesModel->getErrors());
                }
            }
            foreach (json_decode($this->keyskills) as $skill) {
                $userpreferredskillsModel = new UserPreferredSkills();
                $userpreferredskillsModel->preference_enc_id = $user_preference->preference_enc_id;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $userpreferredskillsModel->preferred_skill_enc_id = $utilitiesModel->encrypt();
                $userpreferredskillsModel->skill_enc_id = $skill->id;
                $userpreferredskillsModel->created_on = date('Y-m-d h:i:s');
                $userpreferredskillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$userpreferredskillsModel->save()) {
                    print_r($userpreferredskillsModel->getErrors());
                }
            }
            return true;
//            $i = 1;
        } else {
            print_r($user_preference->getErrors());
        }
    }

    public function updateData() {
//            $userData = Yii::$app->request->post();
        $user_preference = UserPreferences::findOne(['created_by' => Yii::$app->user->identity->user_enc_id]);
//        return $user_preference;
        $user_preference->job_profile = $this->job_category;
        $user_preference->type = $this->jobtype;
//        $user_preference->timings_from = Yii::$app->formatter->asDate($this->from, 'php:H:i:s P');
//        $user_preference->timings_to = Yii::$app->formatter->asDate($this->to, 'php:H:i:s P');
        $user_preference->timings_from = date('H:i:s', strtotime($this->from));
        $user_preference->timings_to = date('H:i:s', strtotime($this->to));
        $min_max = explode(';', $this->salary_range);
        $user_preference->min_expected_salary = $min_max[0];
        $user_preference->max_expected_salary = $min_max[1];
        $user_preference->experience = $this->work_expierence;
        $user_preference->working_days = json_encode($this->weekdays);
        $user_preference->sat_frequency = $this->weekoptsat;
        $user_preference->sun_frequency = $this->weekoptsund;
        $user_preference->last_updated_on = date('Y-m-d H:i:s');
        $user_preference->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if ($user_preference->save()) {

            foreach (json_decode($this->location) as $loc) {
                $userdata = UserPreferredLocations::find()
                    ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                    ->select(['city_enc_id'])
                    ->andWhere(['city_enc_id' => $loc->id])
                    ->asArray()
                    ->all();

                if (empty($userdata)) {
                    $userpreferredlocationsModel = new UserPreferredLocations();
                    $utilitiesModel = new Utilities();
                    $userpreferredlocationsModel->preference_enc_id = $user_preference['preference_enc_id'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $userpreferredlocationsModel->preferred_location_enc_id = $utilitiesModel->encrypt();
                    $userpreferredlocationsModel->city_enc_id = $loc->id;
                    $userpreferredlocationsModel->created_on = date('Y-m-d h:i:s');
                    $userpreferredlocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$userpreferredlocationsModel->save()) {
                        print_r($userpreferredlocationsModel->getErrors());
                    } else {
                        return true;
                    }
                }
            }

            foreach (json_decode($this->industry) as $indus) {
                $userindus = UserPreferredIndustries::find()
                    ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                    ->select(['industry_enc_id'])
                    ->andWhere(['industry_enc_id' => $indus->id])
                    ->asArray()
                    ->all();
                if (empty($userindus)) {
                    $UserpreferredindustriesModel = new UserPreferredIndustries();
                    $utilitiesModel = new Utilities();
                    $UserpreferredindustriesModel->preference_enc_id = $user_preference['preference_enc_id'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $UserpreferredindustriesModel->preferred_industry_enc_id = $utilitiesModel->encrypt();
                    $UserpreferredindustriesModel->industry_enc_id = $indus->id;
                    $UserpreferredindustriesModel->created_on = date('Y-m-d h:i:s');
                    $UserpreferredindustriesModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$UserpreferredindustriesModel->save()) {
                        print_r($UserpreferredindustriesModel->getErrors());
                    } else {
                        return true;
                    }
                }
            }
            foreach (json_decode($this->keyskills) as $skill) {
                $userskill = UserPreferredSkills::find()
                    ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                    ->select(['skill_enc_id'])
                    ->andWhere(['skill_enc_id' => $skill->id])
                    ->asArray()
                    ->all();
                if (empty($userskill)) {
                    $userpreferredskillsModel = new UserPreferredSkills();
                    $utilitiesModel = new Utilities();
                    $userpreferredskillsModel->preference_enc_id = $user_preference['preference_enc_id'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $userpreferredskillsModel->preferred_skill_enc_id = $utilitiesModel->encrypt();
                    $userpreferredskillsModel->skill_enc_id = $skill->id;
                    $userpreferredskillsModel->created_on = date('Y-m-d h:i:s');
                    $userpreferredskillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$userpreferredskillsModel->save()) {
                        print_r($userpreferredskillsModel->getErrors());
                    } else {
                        return true;
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
}