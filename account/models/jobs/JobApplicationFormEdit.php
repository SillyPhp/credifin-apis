<?php

namespace account\models\jobs;

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
use common\models\Designations;
use common\models\ApplicationEmployeeBenefits;
use common\models\AssignedJobDescription;
use common\models\AssignedEducationalRequirements;
use common\models\AssignedSkills;
use yii\helpers\ArrayHelper;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class JobApplicationFormEdit extends Model {

    public $questionnaire;
    public $jobtitle;
    public $jobtype;
    public $ctc;
    public $salaryinhand;
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

    public function rules() {
        return [
            [['questions',
            'primaryfield',
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

    public function attributeLabels() {
        return[
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

    public function updateValues($aidk) {
        $sal = str_replace(',', '', $this->salaryinhand);
        $ctc_val = str_replace(',', '', $this->ctc);

        $employerApplicationsModel = EmployerApplications::find()
                ->where(['application_enc_id' => $aidk])
                ->one();
        $utilitiesModel = new Utilities();
        $employerApplicationsModel->questionnaire_enc_id = null;
        $employerApplicationsModel->fill_questionnaire_on = null;
        $employerApplicationsModel->interview_process_enc_id = $this->interview_process;
        $employerApplicationsModel->published_on = date('Y-m-d H:i:s');
        $employerApplicationsModel->image = '1';
        $employerApplicationsModel->image_location = '1';
        $chk_cat = Categories::find()
                ->alias('a')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->where(['name' => $this->jobtitle])
                ->asArray()
                ->one();

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

                $assignedCategoryModel = new AssignedCategories();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
                $assignedCategoryModel->category_enc_id = $categoriesModel->category_enc_id;
                $assignedCategoryModel->parent_enc_id = $this->primaryfield;
                $assignedCategoryModel->assigned_to = 'Jobs';
                $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
                $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
                if ($assignedCategoryModel->save()) {
                    $employerApplicationsModel->title = $assignedCategoryModel->assigned_category_enc_id;
                    $utilitiesModel->variables['name'] = $this->custom_job_title . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
                    $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $employerApplicationsModel->slug = $utilitiesModel->create_slug();
                }
            } else {
                print_r($categoriesModel->getErrors());
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $employerApplicationsModel->title = $chk_cat['assigned_category_enc_id'];
            $utilitiesModel->variables['name'] = $chk_cat['name'] . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
            $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $employerApplicationsModel->slug = $utilitiesModel->create_slug();
        }


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
                    print_r($desigModel->getError());
                }
            } else {
                $employerApplicationsModel->designation_enc_id = $chk_d['designation_enc_id'];
            }
        }


        $employerApplicationsModel->description = $this->othrdetail;
        $employerApplicationsModel->type = $this->jobtype;
        $employerApplicationsModel->timings_from = $this->from;
        $employerApplicationsModel->timings_to = $this->to;
        $employerApplicationsModel->experience = $this->min_exp;
        $employerApplicationsModel->preferred_gender = $this->gender;
        $employerApplicationsModel->preferred_industry = $this->pref_inds;
        $employerApplicationsModel->joining_date = date('Y-m-d', strtotime($this->earliestjoiningdate));
        $employerApplicationsModel->last_date = date('Y-m-d', strtotime($this->last_date));
        $employerApplicationsModel->created_on = date('Y-m-d H:i:s');
        $employerApplicationsModel->created_by = Yii::$app->user->identity->user_enc_id;
        $employerApplicationsModel->last_updated_on = date('Y-m-d H:i:s');
        $employerApplicationsModel->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if ($employerApplicationsModel->update()) {

            $benft = ApplicationEmployeeBenefits::find()
                    ->where(['application_enc_id' => $aidk])
                    ->andWhere(['is_deleted' => 0])
                    ->select(['benefit_enc_id'])
                    ->asArray()
                    ->all();

            $bnft_data = ArrayHelper::getColumn($benft, 'benefit_enc_id');
            $new_instrd = array_diff($this->emp_benefit, $bnft_data);
            $b_delt = array_diff($bnft_data, $this->emp_benefit);

            if (!empty($new_instrd)) {
                foreach ($new_instrd as $val) {
                    $benefitModel = new ApplicationEmployeeBenefits();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $benefitModel->application_benefit_enc_id = $utilitiesModel->encrypt();
                    $benefitModel->benefit_enc_id = $val;
                    $benefitModel->application_enc_id = $aidk;
                    $benefitModel->created_on = date('Y-m-d H:i:s');
                    $benefitModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$benefitModel->save()) {
                        print_r($benefitModel->getErrors());
                    }
                }
            }

            if (!empty($b_delt)) {
                foreach ($b_delt as $val) {

                    $update = Yii::$app->db->createCommand()
                            ->update(ApplicationEmployeeBenefits::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['benefit_enc_id' => $val, 'application_enc_id' => $aidk])
                            ->execute();
                    if (!$update) {
                        return false;
                    }
                }
            }
            $pl_loc = ApplicationPlacementLocations::find()
                    ->where(['application_enc_id' => $aidk])
                    ->andWhere(['is_deleted' => 0])
                    ->select(['location_enc_id', 'positions'])
                    ->asArray()
                    ->all();

            $user_pl_loc = ArrayHelper::toArray(json_decode($this->placement_loc));
            $p1 = ArrayHelper::map($user_pl_loc, 'location_enc_id', 'positions');
            $p2 = ArrayHelper::map($pl_loc, 'location_enc_id', 'positions');
            $new_loc = array_diff_key($p1, $p2);
            $ploc_delt = array_diff_key($p2, $p1);

            if (!empty($new_loc)) {
                foreach ($new_loc as $k => $v) {
                    $applicationPlacementLocationsModel = new ApplicationPlacementLocations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationPlacementLocationsModel->placement_location_enc_id = $utilitiesModel->encrypt();
                    $applicationPlacementLocationsModel->positions = $v;
                    $applicationPlacementLocationsModel->location_enc_id = $k;
                    $applicationPlacementLocationsModel->application_enc_id = $aidk;
                    $applicationPlacementLocationsModel->created_on = date('Y-m-d H:i:s');
                    $applicationPlacementLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;

                    if (!$applicationPlacementLocationsModel->save()) {

                        print_r($applicationPlacementLocationsModel->getErrors());
                    }
                }
            }

            if (!empty($ploc_delt)) {
                foreach ($ploc_delt as $k => $v) {
                    $update = Yii::$app->db->createCommand()
                            ->update(ApplicationPlacementLocations::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['positions' => $v, 'location_enc_id' => $k, 'application_enc_id' => $aidk])
                            ->execute();

                    if (!$update) {
                        return false;
                    }
                }
            }

            $in_loc = ApplicationInterviewLocations::find()
                    ->where(['application_enc_id' => $aidk])
                    ->andWhere(['is_deleted' => 0])
                    ->select(['location_enc_id'])
                    ->asArray()
                    ->all();

            $int_data = ArrayHelper::getColumn($in_loc, 'location_enc_id');
            $new_int = array_diff($this->interviewcity, $int_data);
            $int_delt = array_diff($int_data, $this->interviewcity);

            if (!empty($new_int)) {
                foreach ($new_int as $interviewcity) {
                    $applicationInterviewLocationsModel = new ApplicationInterviewLocations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationInterviewLocationsModel->interview_location_enc_id = $utilitiesModel->encrypt();
                    $applicationInterviewLocationsModel->location_enc_id = $interviewcity;
                    $applicationInterviewLocationsModel->application_enc_id = $aidk;
                    $applicationInterviewLocationsModel->created_on = date('Y-m-d H:i:s');
                    $applicationInterviewLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationInterviewLocationsModel->save()) {

                        print_r($applicationInterviewLocationsModel->getErrors());
                    }
                }
            }
            if (!empty($int_delt)) {
                foreach ($int_delt as $k) {
                    $update = Yii::$app->db->createCommand()
                            ->update(ApplicationInterviewLocations::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['location_enc_id' => $k, 'application_enc_id' => $aidk])
                            ->execute();
                    if (!$update) {
                        return false;
                    }
                }
            }

            $que_p = ApplicationInterviewQuestionnaire::find()
                    ->where(['application_enc_id' => $aidk])
                    ->andWhere(['is_deleted' => 0])
                    ->select(['questionnaire_enc_id', 'field_enc_id'])
                    ->asArray()
                    ->all();

            $que_process = ArrayHelper::toArray(json_decode($this->question_process));
            $q1 = ArrayHelper::map($que_process, 'questionnaire_enc_id', 'field_enc_id');
            $q2 = ArrayHelper::map($que_p, 'questionnaire_enc_id', 'field_enc_id');
            $new_que = array_diff_key($q1, $q2);
            $que_delt = array_diff_key($q2, $q1);

            if (!empty($new_que)) {
                foreach ($new_que as $k => $v) {

                    $processModel = new ApplicationInterviewQuestionnaire();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $processModel->interview_questionnaire_enc_id = $utilitiesModel->encrypt();
                    $processModel->application_enc_id = $aidk;
                    $processModel->field_enc_id = $v;
                    $processModel->questionnaire_enc_id = $k;
                    $processModel->created_on = date('Y-m-d H:i:s');
                    $processModel->created_by = Yii::$app->user->identity->user_enc_id;

                    if (!$processModel->save()) {
                        print_r($processModel->getErrors());
                    }
                }
            }

            if (!empty($que_delt)) {
                foreach ($que_delt as $k => $v) {
                    $update = Yii::$app->db->createCommand()
                            ->update(ApplicationInterviewQuestionnaire::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['questionnaire_enc_id' => $k, 'field_enc_id' => $v, 'application_enc_id' => $aidk])
                            ->execute();

                    if (!$update) {
                        return false;
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
                $options = ['working_days' => json_encode($this->weekdays), 'sat_frequency' => $weekoptionsat, 'sund_frequency' => $weekoptionsund, 'salary' => $sal, 'salary_duration' => $this->ctctype, 'ctc' => $ctc_val, 'interview_start_date' => $this->startdate, 'interview_end_date' => $this->enddate, 'interview_start_time' => $this->interviewstarttime, 'interview_end_time' => $this->interviewendtime];
            } else {
                $options = ['working_days' => json_encode($this->weekdays), 'sat_frequency' => $weekoptionsat, 'sund_frequency' => $weekoptionsund, 'salary' => $sal, 'salary_duration' => $this->ctctype, 'ctc' => $ctc_val, 'interview_start_date' => null, 'interview_end_date' => null, 'interview_start_time' => null, 'interview_end_time' => null];
            }
            foreach ($options as $key => $value) {
                $applicationoptionsModel = ApplicationOptions::find()
                        ->where(['application_enc_id' => $aidk])
                        ->andWhere(['option_name' => $key])
                        ->one();
                // $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                // $applicationoptionsModel->option_enc_id = $utilitiesModel->encrypt();

                $applicationoptionsModel->option_name = $key;
                $applicationoptionsModel->value = $value;
                $applicationoptionsModel->created_on = date('Y-m-d H:i:s');
                $applicationoptionsModel->created_by = Yii::$app->user->identity->user_enc_id;
                $applicationoptionsModel->last_updated_on = date('Y-m-d H:i:s');
                $applicationoptionsModel->last_updated_by = Yii::$app->user->identity->user_enc_id;
                if (!$applicationoptionsModel->update()) {
                    print_r($applicationoptionsModel->getErrors());
                }
            }
            return 'ok';
            foreach (json_decode($this->skillsArray) as $skill) {
                if (empty($skill->id)) {
                    $skillsModel = new Skills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                    $skillsModel->skill = $skill->value;
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
                            print_r($applicationSkillsModel->getErrors());
                        }
                        //new skill//
                        $this->assignedSkill($skillsModel->skill_enc_id, $cat_id);
                        //new skill//
                    }
                } else {
                    $applicationSkillsModel = new ApplicationSkills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                    $applicationSkillsModel->skill_enc_id = $skill->id;
                    $applicationSkillsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                    $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationSkillsModel->save()) {

                        print_r($applicationSkillsModel->getErrors());
                    }
                    //new skill//
                    $this->assignedSkill($skill->id, $cat_id);
                    //new skill//
                }
            }

            foreach (json_decode($this->checkboxArray) as $job_description) {
                if (empty($job_description->id)) {
                    $jobDescriptionModel = new JobDescription();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $jobDescriptionModel->job_description_enc_id = $utilitiesModel->encrypt();
                    $jobDescriptionModel->job_description = $job_description->value;
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

                            print_r($applicationJobDescriptionModel->getErrors());
                        }

                        //new code added//
                        $this->assignedJob($jobDescriptionModel->job_description_enc_id, $cat_id);
                        //new code added//
                    }
                } else {
                    $applicationJobDescriptionModel = new ApplicationJobDescription();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationJobDescriptionModel->application_job_description_enc_id = $utilitiesModel->encrypt();
                    $applicationJobDescriptionModel->job_description_enc_id = $job_description->id;
                    $applicationJobDescriptionModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationJobDescriptionModel->created_on = date('Y-m-d H:i:s');
                    $applicationJobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationJobDescriptionModel->save()) {
                        print_r($applicationJobDescriptionModel->getErrors());
                    }

                    //new code added//
                    $this->assignedJob($job_description->id, $cat_id);
                    //new code added//
                }
            }
            foreach (json_decode($this->qualifications_arr) as $qualifications) {
                if (empty($qualifications->id)) {
                    $qualificationsModel = new EducationalRequirements();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $qualificationsModel->educational_requirement_enc_id = $utilitiesModel->encrypt();
                    $qualificationsModel->educational_requirement = $qualifications->value;
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

                            print_r($applicationEducationalModel->getErrors());
                        }
                        //new code//
                        $this->assignedEdu($qualificationsModel->educational_requirement_enc_id, $cat_id);
                        //new code//
                    }
                } else {
                    $applicationEducationalModel = new ApplicationEducationalRequirements();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationEducationalModel->application_educational_requirement_enc_id = $utilitiesModel->encrypt();
                    $applicationEducationalModel->educational_requirement_enc_id = $qualifications->id;
                    $applicationEducationalModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationEducationalModel->created_on = date('Y-m-d H:i:s');
                    $applicationEducationalModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationEducationalModel->save()) {

                        print_r($applicationEducationalModel->getErrors());
                    }
                    //new code//
                    $this->assignedEdu($qualifications->id, $cat_id);
                    //new code//
                }
            }

            return true;
        } else {

            print_r($employerApplicationsModel->getErrors());
        }
    }

    public function assignedJob($j_id, $cat_id) {
        $asignedJobModel = new AssignedJobDescription();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedJobModel->assigned_job_description_enc_id = $utilitiesModel->encrypt();
        $asignedJobModel->job_description_enc_id = $j_id;
        $asignedJobModel->category_enc_id = $cat_id;
        $asignedJobModel->created_on = date('Y-m-d H:i:s');
        $asignedJobModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedJobModel->save()) {

            print_r($asignedJobModel->getErrors());
        }
    }

    public function assignedEdu($e_id, $cat_id) {
        $asignedEduModel = new AssignedEducationalRequirements();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedEduModel->assigned_educational_requirement_enc_id = $utilitiesModel->encrypt();
        $asignedEduModel->educational_requirement_enc_id = $e_id;
        $asignedEduModel->category_enc_id = $cat_id;
        $asignedEduModel->created_on = date('Y-m-d H:i:s');
        $asignedEduModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedEduModel->save()) {

            print_r($asignedEduModel->getErrors());
        }
    }

    public function assignedSkill($s_id, $cat_id) {
        $asignedSkillModel = new AssignedSkills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedSkillModel->assigned_skill_enc_id = $utilitiesModel->encrypt();
        $asignedSkillModel->skill_enc_id = $s_id;
        $asignedSkillModel->category_enc_id = $cat_id;
        $asignedSkillModel->created_on = date('Y-m-d H:i:s');
        $asignedSkillModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$asignedSkillModel->save()) {

            print_r($asignedSkillModel->getErrors());
        }
    }

}
