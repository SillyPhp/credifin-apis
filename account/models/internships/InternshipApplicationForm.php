<?php

namespace account\models\internships;

use Yii;
use yii\base\Model;
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
use common\models\ApplicationEmployeeBenefits;
use common\models\AssignedSkills;
use common\models\AssignedJobDescription;
use common\models\AssignedEducationalRequirements;

class InternshipApplicationForm extends Model
{

    public $questionnaire;
    public $pre_sal;
    public $pre_place;
    public $jobtitle;
    public $jobtype;
    public $ctc;
    public $salaryinhand;
    public $is_online_interview;
    public $ctctype;
    public $jobdescription;
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
    public $internshiptype;
    public $cities;
    public $specialskillsrequired;
    public $earliestjoiningdate;
    public $from;
    public $to;
    public $stipendtype;
    public $stipendpaid;
    public $minstip;
    public $maxstip;
    public $stipendur;
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
    public $weekdays;
    public $weekoptsat;
    public $weekoptsund;
    public $custom_job_title;
    public $last_date;
    public $gender;
    public $min_exp;
    public $pref_inds;
    public $fill_quesio_on;
    public $qualifications_arr;
    public $qualifications;
    public $interview_process;
    public $question_process;
    public $designations;
    public $emp_benefit;
    public $clone_desc;
    public $clone_edu;
    public $clone_skills;
    public $benefit_selection;
    public $questionnaire_selection;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['questions',
                'primaryfield',
                'is_online_interview',
                'questionnaire_selection',
                'benefit_selection',
                'pre_sal',
                'pre_place',
                'stipendtype',
                'stipendpaid',
                'minstip',
                'maxstip',
                'stipendur',
                'clone_desc',
                'clone_edu',
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
                'questions',
                'startdate',
                'enddate',
                'ctctype',
                'interviewstarttime',
                'interviewendtime',
                'getinterviewcity',
                'jobposition',
                'placement_loc',
                'checkbox',
                'gender',
                'min_exp',
                'pref_inds',
                'last_date',
                'last_date',
                'designations',
                'placement_locations',
                'fill_quesio_on',
                'salaryinhand', 'weekoptsat', 'custom_job_title', 'weekoptsund', 'jobtitle', 'jobtype', 'interviewdate', 'interviewcity', 'jobdescription', 'ctc', 'interradio', 'quesradio'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('account', 'ID'),
            'employer_enc_id' => Yii::t('account', 'Employer Enc ID'),
            'name' => Yii::t('account', 'Name'),
            'address' => Yii::t('account', 'Address'),
            'contactnumber' => Yii::t('account', 'Contact Number'),
            'typeoforganisation' => Yii::t('account', 'Type Of Organisation'),
            'backgroundoforganisation' => Yii::t('account', 'Industry'),
            'differentdepartments' => Yii::t('account', 'Different Departments'),
            'is_deleted' => Yii::t('account', 'Is Deleted'),
            'headoffice' => Yii::t('account', 'Head Office (Address of the head office)'),
            'firstname' => Yii::t('account', 'First Name'),
            'email' => Yii::t('account', 'Email'),
            'mobilenumber' => Yii::t('account', 'Mobile Number'),
            'addressforinterview' => Yii::t('account', 'Address For Interview'),
            'internshiptitle' => Yii::t('account', 'Internship Title'),
            'fieldofwork' => Yii::t('account', 'Field Of Work'),
            'internshiptype' => Yii::t('account', 'Internship Type'),
            'typeofstipend' => Yii::t('account', 'Type of Stipend'),
            'stipendpaid' => Yii::t('account', 'Stipend Paid During Internship'),
            'internshipduration' => Yii::t('account', ''),
            'internshipduration1' => Yii::t('account', ''),
            'cities' => Yii::t('account', 'Cities'),
            'internshipdescription' => Yii::t('account', 'Internship Description'),
            'islaptoprequired' => Yii::t('account', 'Is Laptop Required?'),
            'specialskillsrequired' => Yii::t('account', 'Special skills Required'),
            'numberofapplicantsrequired' => Yii::t('account', 'Number Of Applicants Required'),
            'earliestjoiningdate' => Yii::t('account', 'Earliest Joining Date'),
            'from' => Yii::t('account', 'From'),
            'to' => Yii::t('account', 'To'),
            'other' => Yii::t('account', 'Other'),
            'questions' => Yii::t('account', 'Question '),
            'jobtitle' => Yii::t('account', 'Job Title'),
            'salaryinhand' => Yii::t('account', 'Salary'),
            'ctc' => Yii::t('account', 'CTC'),
            'ctctype' => Yii::t('account', 'Type'),
            'jobposition' => Yii::t('account', ' No of Job position'),
        ];
    }

    public function saveValues()
    {
        switch ($this->stipendtype) {
            case 1:
                $type = 'Unpaid';
                break;
            case 2:
                $type = 'Performance Based';
                break;
            case 3:
                $type = 'Negotiable';
                break;
            case 4:
                $type = 'Fixed';
                break;
            default:
                $type = 'not found';
        }
        $application_type_enc_id = ApplicationTypes::findOne(['name' => 'Internships']);
        $employerApplicationsModel = new EmployerApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $employerApplicationsModel->application_enc_id = $utilitiesModel->encrypt();
        $employerApplicationsModel->application_number = date('ymd') . time();
        $employerApplicationsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $employerApplicationsModel->application_type_enc_id = $application_type_enc_id->application_type_enc_id;
        $employerApplicationsModel->interview_process_enc_id = $this->interview_process;
        $employerApplicationsModel->published_on = date('Y-m-d H:i:s');
        $employerApplicationsModel->image = '1';
        $employerApplicationsModel->image_location = '1';
        $employerApplicationsModel->status = 'Active';

        $category_execute = Categories::find()
            ->alias('a')
            ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['name' => $this->jobtitle])
            ->andWhere(['b.assigned_to'=>'Internships']);
        $chk_cat = $category_execute->asArray()->one();
        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $cat_id = $categoriesModel->category_enc_id;
            $categoriesModel->name = $this->jobtitle;
            $utilitiesModel->variables['name'] = $this->jobtitle;
            $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->parent_enc_id = null;
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id,$employerApplicationsModel);
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute->andWhere(['not',['b.parent_enc_id'=>null]])->asArray()->one();
            if (empty($chk_assigned))
            {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'],$employerApplicationsModel);
            }
            else{
                $employerApplicationsModel->title = $chk_assigned['assigned_category_enc_id'];
                $utilitiesModel->variables['name'] = $chk_assigned['name'] . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
                $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $employerApplicationsModel->slug = $utilitiesModel->create_slug();
            }
        }
        $employerApplicationsModel->designation_enc_id = null;
        $employerApplicationsModel->description = $this->othrdetail;
        $employerApplicationsModel->type = $this->jobtype;
        $employerApplicationsModel->timings_from = date("H:i:s", strtotime($this->from));
        $employerApplicationsModel->timings_to = date("H:i:s", strtotime($this->to));
        $employerApplicationsModel->experience = null;
        $employerApplicationsModel->preferred_gender = $this->gender;
        $employerApplicationsModel->preferred_industry = null;
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
            } else if (in_array("7", $this->weekdays)) {
                $weekoptionsund = $this->weekoptsund;
            } else {
                $weekoptionsat = null;
                $weekoptionsund = null;
            }

            if ($this->interradio == 1) {
                $interview_strt_date =  date('Y-m-d H:i:s', strtotime($this->startdate . ' ' . $this->interviewstarttime));
                $interview_end_date = date('Y-m-d H:i:s', strtotime($this->enddate . ' ' . $this->interviewendtime));
            } else {
                $interview_strt_date = null;
                $interview_end_date = null;
            }

            $applicationoptionsModel = new ApplicationOptions();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $applicationoptionsModel->option_enc_id = $utilitiesModel->encrypt();
            $applicationoptionsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
            $applicationoptionsModel->wage_type = $type;
            $applicationoptionsModel->fixed_wage = (($this->stipendpaid) ? str_replace(',', '', $this->stipendpaid) : null);
            $applicationoptionsModel->min_wage = (($this->minstip) ? str_replace(',', '', $this->minstip) : null);
            $applicationoptionsModel->max_wage = (($this->maxstip) ? str_replace(',', '', $this->maxstip) : null);
            $applicationoptionsModel->wage_duration = $this->stipendur;
            $applicationoptionsModel->has_placement_offer = null;
            $applicationoptionsModel->has_online_interview = $this->is_online_interview;
            $applicationoptionsModel->has_questionnaire = $this->questionnaire_selection;
            $applicationoptionsModel->has_benefits = $this->benefit_selection;
            $applicationoptionsModel->pre_placement_offer = (($this->pre_sal) ? str_replace(',', '', $this->pre_sal) : null);
            $applicationoptionsModel->has_placement_offer = $this->pre_place;
            $applicationoptionsModel->working_days = json_encode($this->weekdays);
            $applicationoptionsModel->saturday_frequency = $weekoptionsat;
            $applicationoptionsModel->sunday_frequency = $weekoptionsund;
            $applicationoptionsModel->interview_start_date = $interview_strt_date;
            $applicationoptionsModel->interview_end_date = $interview_end_date;
            $applicationoptionsModel->created_on = date('Y-m-d H:i:s');
            $applicationoptionsModel->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$applicationoptionsModel->save())
            {
                return false;
            }
            if ($this->jobtype == "Work From Home"){
                $locations = [];
            }
            else{
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
                $skills_set = Skills::find()
                    ->select(['skill_enc_id'])
                    ->where(['skill' => $skill])
                    ->asArray()
                    ->one();

                if (!empty($skills_set)) {
                    $applicationSkillsModel = new ApplicationSkills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                    $applicationSkillsModel->skill_enc_id = $skills_set['skill_enc_id'];
                    $applicationSkillsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                    $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationSkillsModel->save()) {
                        return false;
                    }
                    //new skill//
                    $this->assignedSkill($skills_set['skill_enc_id'], $cat_id);
                    //new skill//
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
                        //new skill//
                        $this->assignedSkill($skillsModel->skill_enc_id, $cat_id);
                        //new skill//
                    }
                }
            }
            $job_desc_array = array_unique(json_decode($this->checkboxArray, true));
            foreach ($job_desc_array as $jd) {
                $job_desc = JobDescription::find()
                    ->select(['job_description_enc_id'])
                    ->where(['job_description' => $jd])
                    ->asArray()
                    ->one();
                if (!empty($job_desc)) {
                    $applicationJobDescriptionModel = new ApplicationJobDescription();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationJobDescriptionModel->application_job_description_enc_id = $utilitiesModel->encrypt();
                    $applicationJobDescriptionModel->job_description_enc_id = $job_desc['job_description_enc_id'];
                    $applicationJobDescriptionModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationJobDescriptionModel->created_on = date('Y-m-d H:i:s');
                    $applicationJobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationJobDescriptionModel->save()) {
                        return false;
                    }

                    //new code added//
                    $this->assignedJob($job_desc['job_description_enc_id'], $cat_id);
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
                        $this->assignedJob($jobDescriptionModel->job_description_enc_id, $cat_id);
                        //new code added//
                    }
                }
            }


            $job_edu_array = array_unique((json_decode($this->qualifications_arr, true)));
            foreach ($job_edu_array as $edu) {
                $edu_quali = EducationalRequirements::find()
                    ->select(['educational_requirement_enc_id'])
                    ->where(['educational_requirement' => $edu])
                    ->asArray()
                    ->one();

                if (!empty($edu_quali)) {
                    $applicationEducationalModel = new ApplicationEducationalRequirements();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationEducationalModel->application_educational_requirement_enc_id = $utilitiesModel->encrypt();
                    $applicationEducationalModel->educational_requirement_enc_id = $edu_quali['educational_requirement_enc_id'];
                    $applicationEducationalModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationEducationalModel->created_on = date('Y-m-d H:i:s');
                    $applicationEducationalModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationEducationalModel->save()) {

                        return false;
                    }
                    //new code//
                    $this->assignedEdu($edu_quali['educational_requirement_enc_id'], $cat_id);
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
                        $this->assignedEdu($qualificationsModel->educational_requirement_enc_id, $cat_id);
                        //new code//
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }

    private function assignedJob($j_id, $cat_id)
    {
        $asignedJobModel = new AssignedJobDescription();
        $asignedJobModel = new AssignedJobDescription();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedJobModel->assigned_job_description_enc_id = $utilitiesModel->encrypt();
        $asignedJobModel->job_description_enc_id = $j_id;
        $asignedJobModel->category_enc_id = $cat_id;
        $asignedJobModel->created_on = date('Y-m-d H:i:s');
        $asignedJobModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedJobModel->save()) {
            return false;
        }
    }

    private function assignedEdu($e_id, $cat_id)
    {
        $asignedEduModel = new AssignedEducationalRequirements();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedEduModel->assigned_educational_requirement_enc_id = $utilitiesModel->encrypt();
        $asignedEduModel->educational_requirement_enc_id = $e_id;
        $asignedEduModel->category_enc_id = $cat_id;
        $asignedEduModel->created_on = date('Y-m-d H:i:s');
        $asignedEduModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedEduModel->save()) {

            return false;
        }
    }

    private function assignedSkill($s_id, $cat_id)
    {
        $asignedSkillModel = new AssignedSkills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedSkillModel->assigned_skill_enc_id = $utilitiesModel->encrypt();
        $asignedSkillModel->skill_enc_id = $s_id;
        $asignedSkillModel->category_enc_id = $cat_id;
        $asignedSkillModel->created_on = date('Y-m-d H:i:s');
        $asignedSkillModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedSkillModel->save()) {

            return false;
        }
    }
    private function addNewAssignedCategory($category_id,$employerApplicationsModel)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = $this->primaryfield;
        $assignedCategoryModel->assigned_to = 'Internships';
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            $employerApplicationsModel->title = $assignedCategoryModel->assigned_category_enc_id;
            $utilitiesModel->variables['name'] = $this->jobtitle . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
            $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $employerApplicationsModel->slug = $utilitiesModel->create_slug();
        }
        else
        {
            return false;
        }
    }
    private function _createSharingImage()
    {

    }


    public function getCloneData($aidk)
    {
        $application = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->where(['a.application_enc_id' => $aidk])
            ->joinWith(['preferredIndustry x'], false)
            ->select(['a.id', 'a.application_number', 'a.application_enc_id', 'x.industry', 'a.title', 'a.preferred_gender', 'a.description', 'a.designation_enc_id', 'n.designation', 'l.category_enc_id', 'm.category_enc_id as cat_id', 'm.name as cat_name', 'l.name', 'a.type', 'a.slug', 'a.preferred_industry', 'a.interview_process_enc_id', 'a.timings_from', 'a.timings_to', 'a.joining_date', 'a.last_date', 'a.experience'])
            ->joinWith(['applicationOptions b' => function ($b) {
                $b->select(['b.application_enc_id', 'b.option_enc_id', 'b.option_name', 'b.value']);
            }])
            ->joinWith(['applicationEmployeeBenefits c' => function ($b) {
                $b->andWhere(['c.is_deleted' => 0]);
                $b->joinWith(['benefitEnc d'], false);
                $b->select(['c.application_enc_id', 'c.benefit_enc_id', 'c.is_deleted', 'd.benefit']);
            }])
            ->joinWith(['applicationEducationalRequirements e' => function ($b) {
                $b->joinWith(['educationalRequirementEnc f'], false);
                $b->select(['e.application_enc_id', 'f.educational_requirement_enc_id', 'f.educational_requirement']);
            }])
            ->joinWith(['applicationSkills g' => function ($b) {
                $b->joinWith(['skillEnc h'], false);
                $b->select(['g.application_enc_id', 'h.skill_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationJobDescriptions i' => function ($b) {
                $b->joinWith(['jobDescriptionEnc j'], false);
                $b->select(['i.application_enc_id', 'j.job_description_enc_id', 'j.job_description']);
            }])
            ->joinwith(['title k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], false)
            ->joinWith(['designationEnc n'], false)
            ->joinWith(['applicationPlacementLocations o' => function ($b) {
                $b->andWhere(['o.is_deleted' => 0]);
                $b->joinWith(['locationEnc s' => function ($b) {
                    $b->joinWith(['cityEnc t'], false);
                }], false);
                $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 't.city_enc_id', 't.name']);
            }])
            ->joinWith(['applicationInterviewLocations p' => function ($b) {
                $b->andWhere(['p.is_deleted' => 0]);
                $b->joinWith(['locationEnc u' => function ($b) {
                    $b->joinWith(['cityEnc v'], false);
                }], false);
                $b->select(['p.location_enc_id', 'p.application_enc_id', 'v.city_enc_id', 'v.name']);
            }])
            ->joinWith(['applicationInterviewQuestionnaires q' => function ($b) {
                $b->andWhere(['q.is_deleted' => 0]);
                $b->select(['q.field_enc_id', 'q.questionnaire_enc_id', 'q.application_enc_id']);
            }])
            ->asArray()
            ->one();
        return $application;
    }
}
