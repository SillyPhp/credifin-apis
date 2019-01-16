<?php

namespace frontend\models;

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

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class InternshipApplicationForm extends Model {

    public $mainfield;
    public $questionnaire;
    public $jobtitle;
    public $jobtype;
    public $salaryinhand;
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
    public $stipendpaid;
    public $minstip;
    public $maxstip;
    public $stipendtype;
    public $stipendur;
    public function rules() {
        return [
            [['questions', 
            'primaryfield',
            'stipendtype',
            'question_process',
            'interview_process',
            'questionnaire',
            'maxstip',
            'minstip',
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
            'interviewstarttime',
            'interviewendtime',
            'getinterviewcity',
            'jobposition',
            'placement_loc',
            'mainfield',
            'checkbox',
            'stipendpaid',
            'gender',
            'min_exp',
            'pref_inds',
            'last_date',
            'last_date',
            'designations',
            'fill_quesio_on',
            'salaryinhand','weekoptsat','custom_job_title','weekoptsund', 'jobtitle', 'jobtype', 'interviewdate', 'interviewcity', 'jobdescription', 'interradio', 'quesradio'], 'required'],
        ];
    }

    public function attributeLabels() {
        return[
            'id' => Yii::t('frontend', 'ID'),
            'employer_enc_id' => Yii::t('frontend', 'Employer Enc ID'),
            'name' => Yii::t('frontend', 'Name'),
            'address' => Yii::t('frontend', 'Address'),
            'contactnumber' => Yii::t('frontend', 'Contact Number'),
            'typeoforganisation' => Yii::t('frontend', 'Type Of Organisation'),
            'backgroundoforganisation' => Yii::t('frontend', 'Industry'),
            'differentdepartments' => Yii::t('frontend', 'Different Departments'),
            'is_deleted' => Yii::t('frontend', 'Is Deleted'),
            'headoffice' => Yii::t('frontend', 'Head Office (Address of the head office)'),
            'firstname' => Yii::t('frontend', 'First Name'),
            'email' => Yii::t('frontend', 'Email'),
            'mobilenumber' => Yii::t('frontend', 'Mobile Number'),
            'addressforinterview' => Yii::t('frontend', 'Address For Interview'),
            'internshiptitle' => Yii::t('frontend', 'Internship Title'),
            'fieldofwork' => Yii::t('frontend', 'Field Of Work'),
            'internshiptype' => Yii::t('frontend', 'Internship Type'),
            'typeofstipend' => Yii::t('frontend', 'Type of Stipend'),
            'stipendpaid' => Yii::t('frontend', 'Stipend Paid During Internship'),
            'internshipduration' => Yii::t('frontend', ''),
            'internshipduration1' => Yii::t('frontend', ''),
            'cities' => Yii::t('frontend', 'Cities'),
            'internshipdescription' => Yii::t('frontend', 'Internship Description'),
            'islaptoprequired' => Yii::t('frontend', 'Is Laptop Required?'),
            'specialskillsrequired' => Yii::t('frontend', 'Special skills Required'),
            'numberofapplicantsrequired' => Yii::t('frontend', 'Number Of Applicants Required'),
            'earliestjoiningdate' => Yii::t('frontend', 'Earliest Joining Date'),
            'from' => Yii::t('frontend', 'From'),
            'to' => Yii::t('frontend', 'To'),
            'other' => Yii::t('frontend', 'Other'),
            'questions' => Yii::t('frontend', 'Question '),
            'jobtitle' => Yii::t('frontend', 'Job Title'),
            'jobposition' => Yii::t('frontend', ' No of Job position'),
        ];
    }

    public function saveValues() {
        $data = json_decode($this->mainfield);
        if(!empty($this->minstip && $this->maxstip))
        {
         $min =  str_replace( ',', '', $this->minstip);   
         $max =  str_replace( ',', '', $this->maxstip);   
        }
        if(!empty($this->stipendpaid))
        {
         $stipend =  str_replace( ',', '', $this->stipendpaid);
        }
        
        $application_type_enc_id = ApplicationTypes::findOne(['name' => 'internships']);
        $employerApplicationsModel = new EmployerApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $employerApplicationsModel->application_enc_id = $utilitiesModel->encrypt();
        $employerApplicationsModel->application_number = date('ymd').time();
        $employerApplicationsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $employerApplicationsModel->application_type_enc_id = $application_type_enc_id->application_type_enc_id;
        $employerApplicationsModel->questionnaire_enc_id = null;
        $employerApplicationsModel->fill_questionnaire_on = null;
        $employerApplicationsModel->interview_process_enc_id = $this->interview_process;
        $employerApplicationsModel->published_on = date('Y-m-d h:i:s');
        $employerApplicationsModel->image = '1';
        $employerApplicationsModel->image_location = '1';
        
        if(!empty($this->custom_job_title))
        {
             $chk = Categories::find()
                 ->alias('a')
                 ->select(['b.assigned_category_enc_id','a.name'])
                 ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                 ->where(['name'=>$this->custom_job_title])
                 ->asArray()
                 ->one();
             if(empty($chk)){
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $categoriesModel->name = $this->custom_job_title;
            $utilitiesModel->variables['name'] = $this->custom_job_title;
            $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';        
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->parent_enc_id = null;
            $categoriesModel->created_on = date('Y-m-d h:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if($categoriesModel->save())
            {
              $assignedCategoryModel = new AssignedCategories();  
              $utilitiesModel = new Utilities();
              $utilitiesModel->variables['string'] = time() . rand(100, 100000);
              $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
              $assignedCategoryModel->category_enc_id = $categoriesModel->category_enc_id;
              $assignedCategoryModel->parent_enc_id = $this->primaryfield;
              $assignedCategoryModel->assigned_to = 'Jobs';
              $assignedCategoryModel->created_on = date('Y-m-d h:i:s');
              $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
              if($assignedCategoryModel->save()){
                $employerApplicationsModel->title = $assignedCategoryModel->assigned_category_enc_id;
                $utilitiesModel->variables['name'] = $this->custom_job_title . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
                $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $employerApplicationsModel->slug = $utilitiesModel->create_slug();
              }
            }
            else
            {
                print_r($categoriesModel->getErrors());
            }
          }
            else
            {
        $employerApplicationsModel->title = $chk['assigned_category_enc_id'];
        $utilitiesModel->variables['name'] = $chk['name'] . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
        $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $employerApplicationsModel->slug = $utilitiesModel->create_slug();
            }
        }
        else
        {
        $employerApplicationsModel->title = $data->id;
        $utilitiesModel->variables['name'] = $data->value . '-' . $this->designations . '-' . $employerApplicationsModel->application_number;
        $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $employerApplicationsModel->slug = $utilitiesModel->create_slug();
        }
        
        if(!empty($this->designations))
        {
             $chk_d = Designations::find()
                 ->select(['designation_enc_id','designation'])
                 ->where(['designation'=>$this->designations])
                 ->asArray()
                 ->one();
               if(empty($chk_d)){
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
            $desigModel->created_on = date('Y-m-d h:i:s');
            $desigModel->created_by = Yii::$app->user->identity->user_enc_id;
            if($desigModel->save())
            {
                $employerApplicationsModel->designation_enc_id = $desigModel->designation_enc_id;
            }
            else
            {
                return false;
            }
           }
           
           else
           {
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
        $employerApplicationsModel->created_on = date('Y-m-d h:i:s');
        $employerApplicationsModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($employerApplicationsModel->save()) {
            
            foreach(json_decode($this->question_process) as $process)
            {
                
                $processModel = new ApplicationInterviewQuestionnaire();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $processModel->interview_questionnaire_enc_id = $utilitiesModel->encrypt();
                $processModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                $processModel->field_enc_id = $process->process_id;
                $processModel->questionnaire_enc_id = $process->id;
                $processModel->created_on = date('Y-m-d h:i:s');
                $processModel->created_by = Yii::$app->user->identity->user_enc_id;
                 if (!$processModel->save()) {
                    print_r($processModel->getErrors());
                }
            }
            
        
        
            
        if (in_array("6", $this->weekdays))
        {
            $weekoptionsat = $this->weekoptsat;
            
        }
        else if(in_array("7", $this->weekdays))
        {
            $weekoptionsund = $this->weekoptsund;
        }
        else
        {
            $weekoptionsat = null;
            $weekoptionsund = null;
        }
           if($this->interradio == 1)
            { 
           $options = ['working_days'=>json_encode($this->weekdays),'sat_frequency'=>$weekoptionsat,'sund_frequency'=>$weekoptionsund,'stipen_paid'=>$stipend,'min_stipend'=>$min,'duration'=> $this->stipendtype,'stipend_type'=> $this->stipendur, 'interview_start_date' => $this->startdate, 'interview_end_date' => $this->enddate, 'interview_start_time' => $this->interviewstarttime, 'interview_end_time' => $this->interviewendtime];
            }
        else {
            $options = ['working_days'=>json_encode($this->weekdays),'sat_frequency'=>$weekoptionsat,'sund_frequency'=>$weekoptionsund,'stipen_paid'=>$stipend,'max_stipend'=>$max,'duration'=> $this->stipendtype,'stipend_type'=> $this->stipendur, 'interview_start_date' => null, 'interview_end_date' => null, 'interview_start_time' => null, 'interview_end_time' => null];
        }
            foreach ($options as $key => $value) {
                $applicationoptionsModel = new ApplicationOptions();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $applicationoptionsModel->option_enc_id = $utilitiesModel->encrypt();
                $applicationoptionsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                $applicationoptionsModel->option_name = $key;
                $applicationoptionsModel->value = $value;
                $applicationoptionsModel->created_on = date('Y-m-d h:i:s');
                $applicationoptionsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$applicationoptionsModel->save()) {
                   
                    print_r($applicationoptionsModel->getErrors());
                }
            }
            foreach (json_decode($this->placement_loc) as $array) {
                $applicationPlacementLocationsModel = new ApplicationPlacementLocations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $applicationPlacementLocationsModel->placement_location_enc_id = $utilitiesModel->encrypt();
                $applicationPlacementLocationsModel->positions = $array->value;
                $applicationPlacementLocationsModel->location_enc_id = $array->id;
                $applicationPlacementLocationsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                $applicationPlacementLocationsModel->created_on = date('Y-m-d h:i:s');
                $applicationPlacementLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$applicationPlacementLocationsModel->save()) {
                    
                    print_r($applicationPlacementLocationsModel->getErrors());
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
                    $applicationInterviewLocationsModel->created_on = date('Y-m-d h:i:s');
                    $applicationInterviewLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationInterviewLocationsModel->save()) {
                        
                        print_r($applicationInterviewLocationsModel->getErrors());
                    }
                }
            }
            
            
            foreach (json_decode($this->skillsArray) as $skill) {
                if (empty($skill->id)) {
                    $skillsModel = new Skills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                    $skillsModel->skill = $skill->value;
                    $skillsModel->category_enc_id = $employerApplicationsModel->title;
                    $skillsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                    $skillsModel->created_on = date('Y-m-d h:i:s');
                    $skillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($skillsModel->save()) {
                        $applicationSkillsModel = new ApplicationSkills();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                        $applicationSkillsModel->skill_enc_id = $skillsModel->skill_enc_id;
                        $applicationSkillsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $applicationSkillsModel->created_on = date('Y-m-d h:i:s');
                        $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$applicationSkillsModel->save()) {
                            
                            print_r($applicationSkillsModel->getErrors());
                        }
                    }
                } else {
                    $applicationSkillsModel = new ApplicationSkills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                    $applicationSkillsModel->skill_enc_id = $skill->id;
                    $applicationSkillsModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationSkillsModel->created_on = date('Y-m-d h:i:s');
                    $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationSkillsModel->save()) {
                       
                        print_r($applicationSkillsModel->getErrors());
                    }
                }
            }
            foreach (json_decode($this->checkboxArray) as $job_description) {
                if (empty($job_description->id)) {
                    $jobDescriptionModel = new JobDescription();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $jobDescriptionModel->job_description_enc_id = $utilitiesModel->encrypt();
                    $jobDescriptionModel->job_description = $job_description->value;
                    $jobDescriptionModel->category_enc_id = $employerApplicationsModel->title;
                    $jobDescriptionModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                    $jobDescriptionModel->created_on = date('Y-m-d h:i:s');
                    $jobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($jobDescriptionModel->save()) {
                        $applicationJobDescriptionModel = new ApplicationJobDescription();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationJobDescriptionModel->application_job_description_enc_id = $utilitiesModel->encrypt();
                        $applicationJobDescriptionModel->job_description_enc_id = $jobDescriptionModel->job_description_enc_id;
                        $applicationJobDescriptionModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $applicationJobDescriptionModel->created_on = date('Y-m-d h:i:s');
                        $applicationJobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$applicationJobDescriptionModel->save()) {
                           
                            print_r($applicationJobDescriptionModel->getErrors());
                        }
                    }
                } else {
                    $applicationJobDescriptionModel = new ApplicationJobDescription();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationJobDescriptionModel->application_job_description_enc_id = $utilitiesModel->encrypt();
                    $applicationJobDescriptionModel->job_description_enc_id = $job_description->id;
                    $applicationJobDescriptionModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                    $applicationJobDescriptionModel->created_on = date('Y-m-d h:i:s');
                    $applicationJobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationJobDescriptionModel->save()) {
                        print_r($applicationJobDescriptionModel->getErrors());
                    }
                }
            }
            foreach (json_decode($this->qualifications_arr) as $qualifications)
            {
                if (empty($qualifications->id)) {
                    $qualificationsModel = new EducationalRequirements();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $qualificationsModel->educational_requirement_enc_id = $utilitiesModel->encrypt();
                    $qualificationsModel->educational_requirement = $qualifications->value;
                    $qualificationsModel->category_enc_id = $employerApplicationsModel->title;
                    $qualificationsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                    $qualificationsModel->created_on = date('Y-m-d h:i:s');
                    $qualificationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($qualificationsModel->save()) {
                        $applicationEducationalModel = new ApplicationEducationalRequirements();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationEducationalModel->application_educational_requirement_enc_id = $utilitiesModel->encrypt();
                        $applicationEducationalModel->educational_requirement_enc_id = $qualificationsModel->educational_requirement_enc_id;
                        $applicationEducationalModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $applicationEducationalModel->created_on = date('Y-m-d h:i:s');
                        $applicationEducationalModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$applicationEducationalModel->save()) {
                           
                            print_r($applicationEducationalModel->getErrors());
                        }
                        
                    }
                    
                }
                else
                    {
                        $applicationEducationalModel = new ApplicationEducationalRequirements();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationEducationalModel->application_educational_requirement_enc_id = $utilitiesModel->encrypt();
                        $applicationEducationalModel->educational_requirement_enc_id = $qualifications->id;
                        $applicationEducationalModel->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $applicationEducationalModel->created_on = date('Y-m-d h:i:s');
                        $applicationEducationalModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$applicationEducationalModel->save()) {
                           
                            print_r($applicationEducationalModel->getErrors());
                        }
                    }
            }
            
            return true;
        } else {
            
            print_r($employerApplicationsModel->getErrors());
        }
    }

}
