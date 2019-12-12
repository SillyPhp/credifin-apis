<?php

namespace account\models\applications;

use common\models\ApplicationOption;
use common\models\Currencies;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\ApplicationTypes;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationInterviewLocations;
use common\models\ApplicationSkills;
use common\models\ApplicationJobDescription;
use common\models\JobDescription;
use common\models\Utilities;
use common\models\Skills;
use common\models\ApplicationOptions;
use common\models\Categories;
use common\models\AssignedCategories;
use common\models\EducationalRequirements;
use common\models\ApplicationEducationalRequirements;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\Designations;
use common\models\ApplicationEmployeeBenefits;
use common\models\AssignedJobDescription;
use common\models\AssignedEducationalRequirements;
use common\models\AssignedSkills;
use common\models\Industries;
use common\models\OrganizationLocations;
use common\models\OrganizationQuestionnaire;
use common\models\OrganizationInterviewProcess;
use common\models\OrganizationEmployeeBenefits;
use common\models\Cities;
use yii\helpers\ArrayHelper;

class ApplicationForm extends Model
{

    public $questionnaire;
    public $title;
    public $type;
    public $workfromhome;
    public $pre_placement_offer;
    public $pre_placement_package;
    public $ctc;
    public $fixed_wage;
    public $max_wage;
    public $min_wage;
    public $wage_type;
    public $wage_duration;
    public $description;
    public $othrdetail;
    public $job_desc_array;
    public $interviewstarttime;
    public $interviewendtime;
    public $interviewdate;
    public $interviewcity;
    public $addressforinterview;
    public $primaryfield;
    public $internshiptitle;
    public $fieldofwork;
    public $mainfield;
    public $pref_indus;
    public $internshiptype;
    public $cities;
    public $specialskillsrequired;
    public $earliestjoiningdate;
    public $from;
    public $to;
    public $internship_duration;
    public $internship_duration_type;
    public $is_online_interview;
    public $is_online_options;
    public $questions;
    public $checkbox;
    public $getinterviewcity;
    public $placement_loc;
    public $placement_locations;
    public $startdate;
    public $enddate;
    public $checkboxArray;
    public $skillsArray;
    public $interradio;
    public $quesradio;
    public $weekdays = [1, 2, 3, 4, 5];
    public $weekoptsat;
    public $weekoptsund;
    public $custom_job_title;
    public $last_date;
    public $gender;
    public $min_exp;
    public $industry;
    public $fill_quesio_on;
    public $qualifications_arr;
    public $qualifications;
    public $interview_process;
    public $question_process;
    public $designations;
    public $emp_benefit;
    public $clone_desc = [];
    public $clone_edu = [];
    public $clone_skills = [];
    public $positions = [];
    public $questionfields = [];
    public $benefit_selection;
    public $questionnaire_selection;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [[
                'questions',
                'pref_indus',
                'internship_duration',
                'internship_duration_type',
                'mainfield',
                'primaryfield',
                'workfromhome',
                'is_online_interview',
                'pre_placement_package',
                'is_online_options',
                'questionnaire_selection',
                'benefit_selection',
                'clone_desc',
                'clone_edu',
                'pre_placement_offer',
                'clone_skills',
                'emp_benefit',
                'fieldofwork',
                'question_process',
                'interview_process',
                'questionnaire',
                'addressforinterview',
                'cities',
                'specialskillsrequired',
                'earliestjoiningdate',
                'qualifications_arr',
                'from',
                'othrdetail',
                'job_desc_array',
                'to',
                'weekdays',
                'checkboxArray',
                'skillsArray',
                'max_wage',
                'min_wage',
                'wage_type',
                'questions',
                'startdate',
                'enddate',
                'wage_duration',
                'interviewstarttime',
                'interviewendtime',
                'getinterviewcity',
                'jobposition',
                'placement_loc',
                'checkbox',
                'gender',
                'min_exp',
                'industry',
                'last_date',
                'last_date',
                'designations',
                'placement_locations',
                'fill_quesio_on',
                'fixed_wage', 'weekoptsat', 'custom_job_title', 'weekoptsund', 'title', 'type', 'interviewdate', 'interviewcity', 'description', 'ctc', 'interradio', 'quesradio'], 'required'],
        ];
    }

    public function saveValues($type)
    {
        if (in_array('online001', $this->interviewcity)) {
            $has_online_int = 1;
            array_shift($this->interviewcity);
        } else {
            $has_online_int = 0;
        }
        switch ($this->wage_type) {
            case 1:
                $wage_type = 'Fixed';
                break;
            case 2:
                $wage_type = 'Negotiable';
                break;
            case 3:
                $wage_type = 'Performance Based';
                break;
            case 0:
                $wage_type = 'Unpaid';
                break;
            default:
                $wage_type = 'Unpaid';
        }

        if ($type == 'Jobs' || $type == 'Clone_Jobs') {
            $application_type_enc_id = ApplicationTypes::findOne(['name' => 'Jobs']);
            $type = 'Jobs';
        } else if (($type == 'Internships' || $type == 'Clone_Internships')) {
            $application_type_enc_id = ApplicationTypes::findOne(['name' => 'Internships']);
            $type = 'Internships';
        }

        $employerApplicationsModel = new EmployerApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $employerApplicationsModel->application_enc_id = $utilitiesModel->encrypt();
        $employerApplicationsModel->application_number = rand(1000, 10000) . time();
        $employerApplicationsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $employerApplicationsModel->application_type_enc_id = $application_type_enc_id->application_type_enc_id;
        $employerApplicationsModel->interview_process_enc_id = $this->interview_process;
        $employerApplicationsModel->published_on = date('Y-m-d H:i:s');
        $employerApplicationsModel->status = 'Active';
        $category_execute = Categories::find()
            ->alias('a')
            ->where(['name' => $this->title]);
        $chk_cat = $category_execute->asArray()->one();

        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $cat_id = $categoriesModel->category_enc_id;
            $categoriesModel->name = $this->title;
            $utilitiesModel->variables['name'] = $this->title;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $employerApplicationsModel,$type);
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                ->andWhere(['not', ['b.parent_enc_id' => null]])
                ->andWhere(['b.assigned_to' => $type, 'b.parent_enc_id' => $this->primaryfield])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $employerApplicationsModel, $type);
            } else {
                $employerApplicationsModel->title = $chk_assigned['assigned_category_enc_id'];
                $utilitiesModel->variables['name'] = $chk_assigned['name'] . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
                $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $employerApplicationsModel->slug = $utilitiesModel->create_slug();
            }
        }

        $script_image_location = Yii::$app->getSecurity()->generateRandomString();
        $script_image = Yii::$app->getSecurity()->generateRandomString() . '.png';
        $base_path = Yii::$app->params->upload_directories->employer_applications->ai->image_path.$script_image_location;
        if (!is_dir($base_path)) {
            if (mkdir($base_path, 0755, true)) {
                if (!empty(Yii::$app->user->identity->organization->logo)) {
                    $res = $this->genrateImage(
                        $this->title,
                        Yii::$app->user->identity->organization->name,
                        Yii::$app->params->upload_directories->organizations->logo_path . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo,
                        $base_path.DIRECTORY_SEPARATOR.$script_image,
                        Url::to('@rootDirectory/assets/common/images/image_script/share-orignal-image.png')
                    );
                }
                else
                {
                    $res =  $this->genrateImage(
                        $this->title,
                        Yii::$app->user->identity->organization->name,
                        '',
                        $base_path.DIRECTORY_SEPARATOR.$script_image,
                        Url::to('@rootDirectory/assets/common/images/image_script/share-orignal-image.png')
                    );
                }
            }
        }

        if ($res)
        {
          $employerApplicationsModel->image_location = $script_image_location;
          $employerApplicationsModel->image = $script_image;
        }
        else
        {
            $employerApplicationsModel->image_location = 0;
            $employerApplicationsModel->image = 0;
        }

//        $image_information = $this->_createSharingImage($employerApplicationsModel->title, $type);
//        if (!$image_information) {
//            return false;
//        } else {
//            $employerApplicationsModel->image_location = $image_information['image_location'];
//            $employerApplicationsModel->image = $image_information['image'];
//        }

//        $employerApplicationsModel->image_location = 1;
//        $employerApplicationsModel->image = 1;

        if (!empty($this->designations)) {
            $chk_d = Designations::find()
                ->select(['designation_enc_id', 'designation'])
                ->where(['designation' => $this->designations])
                ->asArray()
                ->one();

            if (empty($chk_d)) {
                $desigModel = new Designations;
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $desigModel->designation_enc_id = $utilitiesModel->encrypt();
                $utilitiesModel->variables['name'] = $this->designations;
                $utilitiesModel->variables['table_name'] = Designations::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $desigModel->slug = $utilitiesModel->create_slug();
                $desigModel->designation = $this->designations;
                $desigModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                $desigModel->created_on = date('Y-m-d H:i:s');
                $desigModel->created_by = Yii::$app->user->identity->user_enc_id;
                if ($desigModel->save()) {
                    $employerApplicationsModel->designation_enc_id = $desigModel->designation_enc_id;
                } else {
                    return false;
                }
            } else {
                $employerApplicationsModel->designation_enc_id = $chk_d['designation_enc_id'];
            }
        }

        $employerApplicationsModel->description = $this->othrdetail;
        $employerApplicationsModel->type = $this->type;
        $employerApplicationsModel->timings_from = date("H:i:s", strtotime($this->from));
        $employerApplicationsModel->timings_to = date("H:i:s", strtotime($this->to));
        $employerApplicationsModel->experience = $this->min_exp;
        $employerApplicationsModel->preferred_gender = $this->gender;
        $employerApplicationsModel->preferred_industry = $this->industry;
        $employerApplicationsModel->joining_date = date('Y-m-d', strtotime($this->earliestjoiningdate));
        $employerApplicationsModel->last_date = date('Y-m-d', strtotime($this->last_date));
        $employerApplicationsModel->created_on = date('Y-m-d H:i:s');
        $employerApplicationsModel->created_by = Yii::$app->user->identity->user_enc_id;

        if ($employerApplicationsModel->save()) {
            if ($this->questionnaire_selection == 1) {
                $process_questionnaire = json_decode($this->question_process);
                if (!empty($process_questionnaire)) {
                    foreach ($process_questionnaire as $process) {
                        $processModel = new ApplicationInterviewQuestionnaire();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $processModel->interview_questionnaire_enc_id = $utilitiesModel->encrypt();
                        $processModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $processModel->field_enc_id = $process->process_id;
                        $processModel->questionnaire_enc_id = $process->id;
                        $processModel->created_on = date('Y-m-d H:i:s');
                        $processModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$processModel->save()) {
                            return false;
                        }
                    }
                }
            }
            if ($this->benefit_selection == 1) {
                if (!empty($this->emp_benefit)) {
                    foreach ($this->emp_benefit as $benefit) {
                        $benefitModel = new ApplicationEmployeeBenefits();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $benefitModel->application_benefit_enc_id = $utilitiesModel->encrypt();
                        $benefitModel->benefit_enc_id = $benefit;
                        $benefitModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $benefitModel->created_on = date('Y-m-d H:i:s');
                        $benefitModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$benefitModel->save()) {
                            return false;
                        }
                    }
                }
            }
            if (in_array("6", $this->weekdays)) {
                $weekoptionsat = $this->weekoptsat;
            } else {
                $weekoptionsat = NULL;
            }
            if (in_array("7", $this->weekdays)) {
                $weekoptionsund = $this->weekoptsund;
            } else {
                $weekoptionsund = NULL;
            }
            if ($this->interradio == 1) {
                $interview_strt_date = date('Y-m-d H:i:s', strtotime($this->startdate . ' ' . $this->interviewstarttime));
                $interview_end_date = date('Y-m-d H:i:s', strtotime($this->enddate . ' ' . $this->interviewendtime));
            } else {
                $interview_strt_date = null;
                $interview_end_date = null;
            }

            $applicationoptionsModel = new ApplicationOptions();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $applicationoptionsModel->option_enc_id = $utilitiesModel->encrypt();
            $applicationoptionsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
            $applicationoptionsModel->wage_type = $wage_type;
            $applicationoptionsModel->fixed_wage = (($this->fixed_wage) ? str_replace(',', '', $this->fixed_wage) : null);
            $applicationoptionsModel->min_wage = (($this->min_wage) ? str_replace(',', '', $this->min_wage) : null);
            $applicationoptionsModel->max_wage = (($this->max_wage) ? str_replace(',', '', $this->max_wage) : null);
            $applicationoptionsModel->ctc = (($this->ctc) ? str_replace(',', '', $this->ctc) : null);
            $applicationoptionsModel->wage_duration = $this->wage_duration;
            $applicationoptionsModel->has_online_interview = $has_online_int;
            $applicationoptionsModel->has_questionnaire = $this->questionnaire_selection;
            $applicationoptionsModel->pre_placement_offer = (($this->pre_placement_package) ? str_replace(',', '', $this->pre_placement_package) : null);
            $applicationoptionsModel->has_placement_offer = $this->pre_placement_offer;
            $applicationoptionsModel->has_benefits = $this->benefit_selection;
            $applicationoptionsModel->internship_duration = $this->internship_duration;
            $applicationoptionsModel->internship_duration_type = $this->internship_duration_type;
            $applicationoptionsModel->working_days = json_encode($this->weekdays);
            $applicationoptionsModel->saturday_frequency = $weekoptionsat;
            $applicationoptionsModel->sunday_frequency = $weekoptionsund;
            $applicationoptionsModel->interview_start_date = $interview_strt_date;
            $applicationoptionsModel->interview_end_date = $interview_end_date;
            $applicationoptionsModel->created_on = date('Y-m-d H:i:s');
            $applicationoptionsModel->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$applicationoptionsModel->save()) {
                return false;
            }
            if ($this->type == "Work From Home") {
                $locations = [];
            } else {
                $locations = json_decode($this->placement_loc);
            }
            if (!empty($locations)) {
                foreach ($locations as $array) {
                    $applicationPlacementLocationsModel = new ApplicationPlacementLocations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationPlacementLocationsModel->placement_location_enc_id = $utilitiesModel->encrypt();
                    $applicationPlacementLocationsModel->positions = $array->value;
                    $applicationPlacementLocationsModel->location_enc_id = $array->id;
                    $applicationPlacementLocationsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationPlacementLocationsModel->created_on = date('Y-m-d H:i:s');
                    $applicationPlacementLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationPlacementLocationsModel->save()) {
                        return false;
                    }
                }
            }

            if (!empty($this->interviewcity) && count($this->interviewcity) > 0) {
                foreach ($this->interviewcity as $interviewcity) {
                    $applicationInterviewLocationsModel = new ApplicationInterviewLocations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationInterviewLocationsModel->interview_location_enc_id = $utilitiesModel->encrypt();
                    $applicationInterviewLocationsModel->location_enc_id = $interviewcity;
                    $applicationInterviewLocationsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationInterviewLocationsModel->created_on = date('Y-m-d H:i:s');
                    $applicationInterviewLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationInterviewLocationsModel->save()) {
                        return false;
                    }
                }
            }

            $skills_array = array_unique(json_decode($this->skillsArray, true));
            foreach ($skills_array as $skill) {
                $data_skill = Skills::find()
                    ->alias('a')
                    ->select(['a.skill_enc_id'])
                    ->where(['a.skill' => $skill]);

                $skills_set = $data_skill->asArray()->one();
                if (!empty($skills_set)) {
                    $applicationSkillsModel = new ApplicationSkills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                    $applicationSkillsModel->skill_enc_id = $skills_set['skill_enc_id'];
                    $applicationSkillsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                    $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($applicationSkillsModel->save()) {
                        $chk_skill = $data_skill
                            ->innerJoin(AssignedSkills::tableName().'as b','b.skill_enc_id = a.skill_enc_id')
                            ->andWhere(['b.assigned_to'=>$type,'category_enc_id'=>$cat_id])
                            ->asArray()
                            ->one();
                        if (empty($chk_skill)):
                            $this->assignedSkill($skills_set['skill_enc_id'], $cat_id,$type);
                        endif;
                    }
                    else
                    {
                        return false;
                    }
                } else {
                    $skillsModel = new Skills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                    $skillsModel->skill = $skill;
                    $skillsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                    $skillsModel->created_on = date('Y-m-d H:i:s');
                    $skillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($skillsModel->save()) {
                        $applicationSkillsModel = new ApplicationSkills();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                        $applicationSkillsModel->skill_enc_id = $skillsModel->skill_enc_id;
                        $applicationSkillsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                        $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$applicationSkillsModel->save()) {
                            return false;
                        }
                        $this->assignedSkill($skillsModel->skill_enc_id, $cat_id,$type);
                    }
                }
            }
            $job_desc_array = array_unique(json_decode($this->checkboxArray, true));
            foreach ($job_desc_array as $jd) {
                $data_job_desc = JobDescription::find()
                    ->alias('a')
                    ->select(['a.job_description_enc_id'])
                    ->where(['a.job_description' => $jd]);

                $job_desc = $data_job_desc->asArray()->one();
                if (!empty($job_desc)) {
                    $applicationJobDescriptionModel = new ApplicationJobDescription();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationJobDescriptionModel->application_job_description_enc_id = $utilitiesModel->encrypt();
                    $applicationJobDescriptionModel->job_description_enc_id = $job_desc['job_description_enc_id'];
                    $applicationJobDescriptionModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationJobDescriptionModel->created_on = date('Y-m-d H:i:s');
                    $applicationJobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($applicationJobDescriptionModel->save()) {
                        $chk_jd_des = $data_job_desc
                            ->innerJoin(AssignedJobDescription::tableName().'as b','b.job_description_enc_id = a.job_description_enc_id')
                            ->andWhere(['b.assigned_to'=>$type,'category_enc_id'=>$cat_id])
                            ->asArray()
                            ->one();
                        if (empty($chk_jd_des)):
                            $this->assignedJob($job_desc['job_description_enc_id'], $cat_id,$type);
                        endif;
                    }
                    else
                    {
                        return false;
                    }
                    //new code added//
                } else {
                    $jobDescriptionModel = new JobDescription();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $jobDescriptionModel->job_description_enc_id = $utilitiesModel->encrypt();
                    $jobDescriptionModel->job_description = $jd;
                    $jobDescriptionModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                    $jobDescriptionModel->created_on = date('Y-m-d H:i:s');
                    $jobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($jobDescriptionModel->save()) {
                        $applicationJobDescriptionModel = new ApplicationJobDescription();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationJobDescriptionModel->application_job_description_enc_id = $utilitiesModel->encrypt();
                        $applicationJobDescriptionModel->job_description_enc_id = $jobDescriptionModel->job_description_enc_id;
                        $applicationJobDescriptionModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $applicationJobDescriptionModel->created_on = date('Y-m-d H:i:s');
                        $applicationJobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$applicationJobDescriptionModel->save()) {
                            return false;
                        }
                        //new code added//
                        $this->assignedJob($jobDescriptionModel->job_description_enc_id, $cat_id,$type);
                        //new code added//
                    }
                }
            }

            $job_edu_array = array_unique((json_decode($this->qualifications_arr, true)));
            foreach ($job_edu_array as $edu) {
                $data_edu_quali = EducationalRequirements::find()
                    ->alias('a')
                    ->select(['a.educational_requirement_enc_id'])
                    ->where(['a.educational_requirement' => $edu]);

                $edu_quali = $data_edu_quali->asArray()->one();
                if (!empty($edu_quali)) {
                    $applicationEducationalModel = new ApplicationEducationalRequirements();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationEducationalModel->application_educational_requirement_enc_id = $utilitiesModel->encrypt();
                    $applicationEducationalModel->educational_requirement_enc_id = $edu_quali['educational_requirement_enc_id'];
                    $applicationEducationalModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationEducationalModel->created_on = date('Y-m-d H:i:s');
                    $applicationEducationalModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($applicationEducationalModel->save()) {
                        $chk_ed_des = $data_edu_quali
                            ->innerJoin(AssignedEducationalRequirements::tableName().'as b','b.educational_requirement_enc_id = a.educational_requirement_enc_id')
                            ->andWhere(['b.assigned_to'=>$type,'category_enc_id'=>$cat_id])
                            ->asArray()
                            ->one();
                        if (empty($chk_ed_des)):
                            $this->assignedEdu($edu_quali['educational_requirement_enc_id'], $cat_id,$type);
                        endif;
                    }
                    else
                    {
                        return false;
                    }
                    //new code//
                } else {
                    $qualificationsModel = new EducationalRequirements();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $qualificationsModel->educational_requirement_enc_id = $utilitiesModel->encrypt();
                    $qualificationsModel->educational_requirement = $edu;
                    $qualificationsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                    $qualificationsModel->created_on = date('Y-m-d H:i:s');
                    $qualificationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($qualificationsModel->save()) {
                        $applicationEducationalModel = new ApplicationEducationalRequirements();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationEducationalModel->application_educational_requirement_enc_id = $utilitiesModel->encrypt();
                        $applicationEducationalModel->educational_requirement_enc_id = $qualificationsModel->educational_requirement_enc_id;
                        $applicationEducationalModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $applicationEducationalModel->created_on = date('Y-m-d H:i:s');
                        $applicationEducationalModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$applicationEducationalModel->save()) {
                            return false;
                        }
                        //new code//
                        $this->assignedEdu($qualificationsModel->educational_requirement_enc_id, $cat_id,$type);
                        //new code//
                    }
                }
            }
            Yii::$app->sitemap->generate();
            return $employerApplicationsModel->application_enc_id;
        } else {
            return false;
        }
    }

    private function assignedJob($j_id, $cat_id,$type)
    {
        $asignedJobModel = new AssignedJobDescription();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedJobModel->assigned_job_description_enc_id = $utilitiesModel->encrypt();
        $asignedJobModel->job_description_enc_id = $j_id;
        $asignedJobModel->assigned_to = $type;
        $asignedJobModel->category_enc_id = $cat_id;
        $asignedJobModel->created_on = date('Y-m-d H:i:s');
        $asignedJobModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedJobModel->save()) {
            return false;
        }
    }

    private function assignedEdu($e_id, $cat_id,$type)
    {
        $asignedEduModel = new AssignedEducationalRequirements();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedEduModel->assigned_educational_requirement_enc_id = $utilitiesModel->encrypt();
        $asignedEduModel->educational_requirement_enc_id = $e_id;
        $asignedEduModel->category_enc_id = $cat_id;
        $asignedEduModel->assigned_to = $type;
        $asignedEduModel->created_on = date('Y-m-d H:i:s');
        $asignedEduModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedEduModel->save()) {
            return false;
        }
    }

    private function assignedSkill($s_id, $cat_id,$type)
    {
        $asignedSkillModel = new AssignedSkills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedSkillModel->assigned_skill_enc_id = $utilitiesModel->encrypt();
        $asignedSkillModel->skill_enc_id = $s_id;
        $asignedSkillModel->assigned_to = $type;
        $asignedSkillModel->category_enc_id = $cat_id;
        $asignedSkillModel->created_on = date('Y-m-d H:i:s');
        $asignedSkillModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedSkillModel->save()) {
            return false;
        }
    }

    private function addNewAssignedCategory($category_id, $employerApplicationsModel, $type)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = $this->primaryfield;
        $assignedCategoryModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $assignedCategoryModel->assigned_to = $type;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            $employerApplicationsModel->title = $assignedCategoryModel->assigned_category_enc_id;
            $utilitiesModel->variables['name'] = $this->title . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
            $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $employerApplicationsModel->slug = $utilitiesModel->create_slug();
        } else {
            return false;
        }
    }

    private function _createSharingImage($category, $type)
    {
        $profile = AssignedCategories::find()
            ->alias('a')
            ->select(['b.name', 'CONCAT("' . Url::to('@commonAssetsDirectory/categories/png/') . '", b.icon_png) icon'])
            ->innerJoinWith(['parentEnc b' => function ($b) {
                $b->onCondition([
                    'or',
                    ['!=', 'b.icon', NULL],
                    ['!=', 'b.icon', ''],
                ])
                    ->groupBy(['b.category_enc_id']);
            }], false)
            ->where([
                'a.assigned_to' => ucfirst($type),
                'a.assigned_category_enc_id' => $category,
            ])
            ->asArray()
            ->one();

        if (!$profile) {
            return false;
        }

        if (isset(Yii::$app->user->identity->organization->logo) && !empty(Yii::$app->user->identity->organization->logo)) {
            $organizationLogo = Yii::$app->params->upload_directories->organizations->logo_path . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
        } else {
            $organizationLogo = "https://ui-avatars.com/api/?name=" . Yii::$app->user->identity->organization->name . "&size=200&rounded=true&background=" . str_replace("#", "", Yii::$app->user->identity->organization->initials_color) . "&color=ffffff";
        }

        $pyscript = Url::to('@consoleDirectory/commands/applicationSharingImage/main.py');
        $backgroudImage = Url::to('@consoleDirectory/commands/applicationSharingImage/hiring.png');

        $sharingImagePath = Yii::$app->getSecurity()->generateRandomString();
        $sharingImage = Yii::$app->getSecurity()->generateRandomString() . '.png';
        $imagePath = Yii::$app->params->upload_directories->applications->image_path . $sharingImagePath . DIRECTORY_SEPARATOR . $sharingImage;

        $cmd = 'sudo python3 "' . $pyscript . '" "' . $backgroudImage . '" "' . $organizationLogo . '" "' . $imagePath . '" "' . $profile["name"] . '" "' . $profile["icon"] . '" "' . $fontPath . '" "' . $isUrl . '"';
        if (exec($cmd)) {
            return [
                'image_location' => $sharingImagePath,
                'image' => $sharingImage,
            ];
        }

        return false;
    }

    public function getQuestionnnaireList($type = 1)
    {
        $questions_list = OrganizationQuestionnaire::find()
            ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->andWhere(['like', 'questionnaire_for', '"' . $type . '"'])
            ->andWhere(['is_deleted' => 0])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
        $que = ArrayHelper::map($questions_list, 'questionnaire_enc_id', 'questionnaire_name');
        return $que;
    }
    public function getCurrency()
    {
        $d = Currencies::find()
            ->select(['currency_enc_id','CONCAT(code," ",html_code) code'])
            ->orderBy([new \yii\db\Expression('FIELD (code, "INR") DESC, code ASC')])
            ->asArray()->all();
        $d = ArrayHelper::map($d, 'currency_enc_id', 'code');
        return $d;
    }
    public function getOrganizationLocations($type = 1)
    {
        $loc_list = OrganizationLocations::find()
            ->alias('a')
            ->distinct()
            ->select(['a.location_enc_id', 'a.organization_enc_id', 'a.location_name', 'a.address', 'b.name AS city_name', 'c.name AS state_name'])
            ->where(['like', 'location_for', '"' . $type . '"'])
            ->andWhere(['a.is_deleted' => 0])
            ->andWhere(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->joinWith(['cityEnc b' => function ($b) {
                $b->joinWith(['stateEnc c'], false);
            }], false)
            ->orderBy(['a.id' => SORT_DESC]);

        $l_list = $loc_list->asArray()->all();
        if ($type == 2) {
            $random_id = 'online001';
            $online_random_val = ['location_enc_id' => $random_id, 'organization_enc_id' => 'online001', 'location_name' => 'Online Interview', 'address' => 'online', 'city_name' => 'skype', 'state_name' => 'phone'];
            array_unshift($l_list, $online_random_val);
            $total = $loc_list->count();
            $l_list[($total)]['total'] = $total + 1;
        } else {
            $total = $loc_list->count();
            $l_list[($total - 1)]['total'] = $total;
        }
        $int_list = ArrayHelper::index($l_list, 'location_enc_id');
        return $int_list;
    }
    public function PlacementLocations($type=1)
    {
        $loc_list = OrganizationLocations::find()
            ->alias('a')
            ->distinct()
            ->select(['a.location_enc_id','CONCAT(a.location_name,", ",b.name,", ",c.name) location'])
            ->where(['like', 'location_for', '"' . $type . '"'])
            ->andWhere(['a.is_deleted' => 0])
            ->andWhere(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->joinWith(['cityEnc b' => function ($b) {
                $b->joinWith(['stateEnc c'], false);
            }], false)
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()->all();

        $int_list = ArrayHelper::map($loc_list, 'location_enc_id','location');
        return $int_list;
    }
    public function getPrimaryFields($type = 'Jobs')
    {
        $primaryfields = Categories::find()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->orderBy([new \yii\db\Expression('FIELD (a.name, "Others") ASC, a.name ASC')])
            ->where(['b.assigned_to' => $type, 'b.parent_enc_id' => NULL])
            ->andWhere(['b.status' => 'Approved'])
            ->asArray()
            ->all();
        $primary_cat = ArrayHelper::map($primaryfields, 'category_enc_id', 'name');
        return $primary_cat;
    }
    public function getApplicationTypes()
    {
        $d = ApplicationTypes::find()
            ->select(['application_type_enc_id','name'])
            ->where(['in','name',['Jobs','Internships']])
            ->asArray()->all();
        $d = ArrayHelper::map($d, 'application_type_enc_id', 'name');
        return $d;
    }

    public function getndustry()
    {
        $industries = Industries::find()
            ->select(['industry_enc_id', 'industry'])
            ->orderBy([new \yii\db\Expression('FIELD (industry, "Same Industry", "No Preference") DESC, FIELD (industry, "Others") ASC, industry ASC')])
            ->asArray()
            ->all();
        $industry = ArrayHelper::map($industries, 'industry_enc_id', 'industry');
        return $industry;
    }

    public function getInterviewProcess()
    {
        $interview_process = OrganizationInterviewProcess::find()
            ->select(['interview_process_enc_id', 'process_name'])
            ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->andWhere(['is_deleted' => 0])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
        $process = ArrayHelper::map($interview_process, 'interview_process_enc_id', 'process_name');
        return $process;
    }

    public function getBenefits()
    {
        $benefit = OrganizationEmployeeBenefits::find()
            ->alias('a')
            ->select(['a.benefit_enc_id', 'b.benefit', 'CASE WHEN b.icon IS NULL OR b.icon = ""  THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg') . '" ELSE CONCAT("' . Yii::$app->params->upload_directories->benefits->icon . '",b.icon_location, "/", b.icon) END icon'])
            ->joinWith(['benefitEnc b'], false)
            ->where([
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.is_deleted' => 0,
            ])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $benefits = ArrayHelper::index($benefit, 'benefit_enc_id');
        return $benefits;
    }

    public function getWorkFromHome()
    {
        $cities = Cities::find()
            ->alias('a')
            ->select(['city_enc_id', 'name'])
            ->where(['city_enc_id' => 'Qk41NU9BbkJHbVZZZEV2YmM5U2J5dz09'])
            ->asArray()
            ->all();
        $getWorkFromCity = ArrayHelper::map($cities, 'city_enc_id', 'name');
        return $getWorkFromCity;
    }

    public function getCloneData($aidk, $application_type)
    {
        $t = (($application_type=="Jobs")?'job':'internship');
        $application = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->where(['a.application_enc_id' => $aidk])
            ->joinWith(['applicationTypeEnc y' => function ($b) use ($application_type) {
                $b->andWhere(['y.name' => $application_type]);
            }], false, 'INNER JOIN')
            ->joinWith(['preferredIndustry x'], false)
            ->select(['a.id', 'a.application_number', 'a.application_enc_id', 'x.industry', 'a.title', 'a.preferred_gender', 'a.description', 'a.designation_enc_id', 'n.designation', 'l.category_enc_id', 'm.category_enc_id as cat_id', 'm.name as cat_name', 'l.name', 'l.icon_png', 'a.type', 'a.slug', 'a.preferred_industry', 'a.interview_process_enc_id', 'a.timings_from', 'a.timings_to', 'a.joining_date', 'a.last_date',
                '(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year"
                WHEN a.experience = "2" THEN "1 Year"
                WHEN a.experience = "3" THEN "2-3 Years"
                WHEN a.experience = "3-5" THEN "3-5 Years"
                WHEN a.experience = "5-10" THEN "5-10 Years"
                WHEN a.experience = "10-20" THEN "10-20 Years"
                WHEN a.experience = "20+" THEN "More Than 20 Years"
                ELSE "No Experience"
                END) as experience', 'b.*','CONCAT("/","' . $t . '","/", a.slug) link'])
            ->joinWith(['applicationOptions b'], false)
            ->joinWith(['applicationEmployeeBenefits c' => function ($b) {
                $b->onCondition(['c.is_deleted' => 0]);
                $b->joinWith(['benefitEnc d'], false);
                $b->select(['c.application_enc_id', 'c.benefit_enc_id', 'c.is_deleted', 'd.benefit', 'd.icon', 'd.icon_location']);
            }])
            ->joinWith(['applicationEducationalRequirements e' => function ($b) {
                $b->onCondition(['e.is_deleted' => 0]);
                $b->joinWith(['educationalRequirementEnc f'], false);
                $b->select(['e.application_enc_id', 'f.educational_requirement_enc_id', 'f.educational_requirement']);
            }])
            ->joinWith(['applicationSkills g' => function ($b) {
                $b->onCondition(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false);
                $b->select(['g.application_enc_id', 'h.skill_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationJobDescriptions i' => function ($b) {
                $b->onCondition(['i.is_deleted' => 0]);
                $b->joinWith(['jobDescriptionEnc j'], false);
                $b->select(['i.application_enc_id', 'j.job_description_enc_id', 'j.job_description']);
            }])
            ->joinwith(['title k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], false)
            ->joinWith(['designationEnc n'], false)
            ->joinWith(['applicationPlacementLocations o' => function ($b) {
                $b->onCondition(['o.is_deleted' => 0]);
                $b->joinWith(['locationEnc s' => function ($b) {
                    $b->joinWith(['cityEnc t'], false);
                }], false);
                $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
                $b->distinct();
            }])
            ->joinWith(['applicationPlacementCities r'=>function($b)
            {
                $b->onCondition(['r.is_deleted' => 0]);
                $b->select(['r.application_enc_id','cn.city_enc_id','cn.name']);
                $b->joinWith(['cityEnc cn'], false);
            }])
            ->joinWith(['applicationInterviewLocations p' => function ($b) {
                $b->onCondition(['p.is_deleted' => 0]);
                $b->joinWith(['locationEnc u' => function ($b) {
                    $b->joinWith(['cityEnc v'], false);
                }], false);
                $b->select(['p.location_enc_id', 'p.application_enc_id', 'v.city_enc_id', 'v.name', 'u.latitude as interview_lat', 'u.longitude as interview_long']);
            }])
            ->joinWith(['applicationInterviewQuestionnaires q' => function ($b) {
                $b->onCondition(['q.is_deleted' => 0]);
                $b->select(['q.field_enc_id', 'q.questionnaire_enc_id', 'q.application_enc_id']);
            }])
            ->asArray()
            ->one();

        return $application;
    }

    public function getCloneUnclaimed($aidk,$application_type)
    {
        $t = (($application_type=="Jobs")?'job':'internship');
        $application = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->where(['a.application_enc_id' => $aidk])
            ->select(['a.application_enc_id','a.preferred_gender','a.description',
                'm.name as cat_name', 'l.name', 'l.icon_png', 'a.type','a.interview_process_enc_id','a.slug','o.*','(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year"
                WHEN a.experience = "2" THEN "1 Year"
                WHEN a.experience = "3" THEN "2-3 Years"
                WHEN a.experience = "3-5" THEN "3-5 Years"
                WHEN a.experience = "5-10" THEN "5-10 Years"
                WHEN a.experience = "10-20" THEN "10-20 Years"
                WHEN a.experience = "20+" THEN "More Than 20 Years"
                ELSE "No Experience"
                END) as experience','CONCAT("/","' . $t . '","/", a.slug) link'])
            ->joinwith(['title k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], false)
            ->joinWith(['applicationUnclaimOptions o'],false)
            ->joinWith(['applicationPlacementCities p'=>function($b)
            {
                $b->select(['p.application_enc_id','q.city_enc_id','name']);
                $b->joinWith(['cityEnc q'],false);
            }])
            ->joinWith(['applicationTypeEnc y' => function ($b) use ($application_type) {
                $b->andWhere(['y.name' => $application_type]);
            }], false, 'INNER JOIN')
            ->joinWith(['applicationSkills z'=>function($b)
            {
                $b->select(['z.application_enc_id','n.skill_enc_id','skill']);
                $b->joinWith(['skillEnc n'],false);
            }])
            ->asArray()
            ->one();
        return $application;

    }

    private function genrateImage($title,$company_name,$icon_path,$output_image,$template)
    {
        $output_image = $output_image;
        $company_name = $company_name;
        $font = Url::to('@rootDirectory/assets/common/images/image_script/GeoSlb712MdBTBold.ttf');
        $font2 = Url::to('@rootDirectory/assets/common/images/image_script/Gelasio-Regular.ttf');
        $font3 = Url::to('@rootDirectory/assets/common/images/image_script/GeoSlb712MdBTBold.ttf');
        $script_path = Url::to('@rootDirectory/assets/common/images/image_script/image_genrate_script.py');
        $job_title = $title;
        $canvas_name = substr(trim($company_name),0,1);
        $icon_path = $icon_path;
        $temp_image = $template;
        $script = 'sudo python "'.$script_path.'" "'.$company_name.'" "'.$job_title.'" "'.$canvas_name.'" "'.$temp_image.'" "'.$font.'" "'.$font2.'" "'.$font3.'" "'.$output_image.'" "'.$icon_path.'" ';
         if (exec($script,$output, $return_var))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}