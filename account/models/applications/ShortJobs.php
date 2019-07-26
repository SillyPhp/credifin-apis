<?php
namespace account\models\applications;
use common\models\ApplicationOptions;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationSkills;
use common\models\AssignedCategories;
use common\models\AssignedSkills;
use common\models\Categories;
use common\models\EmployerApplications;
use common\models\Skills;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Utilities;

class ShortJobs extends Model
{
    public $job_title;
    public $location;
    public $job_profile;
    public $job_type;
    public $type;
    public $description;
    public $email;
    public $wage_type = 1;
    public $fixed_wage;
    public $min_salary;
    public $max_salary;
    public $gender;
    public $exp;
    public $skills;

    public function rules()
    {
        return [
            [['job_title','skills','exp','location','gender','type','job_profile','wage_type','job_type'],'required'],
            [['email','description','fixed_wage','min_salary','max_salary'],'safe'],
            [['job_title'],'string','max'=>50],
            [['job_title','fixed_wage','min_salary','max_salary','email'],'trim'],
            [['fixed_wage'],'string','min'=>4,'max'=>15],
            ['email','email'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function save()
    {
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
       $employerApplication = new EmployerApplications();
       $utilitiesModel = new Utilities();
       $utilitiesModel->variables['string'] = time() . rand(100, 100000);
       $employerApplication->application_enc_id = $utilitiesModel->encrypt();
       $employerApplication->application_number = rand(1000,10000).time();
       $employerApplication->application_type_enc_id = $this->type;
       $employerApplication->experience = $this->exp;
       $employerApplication->published_on = date('Y-m-d H:i:s');
       $employerApplication->image = '1';
       $employerApplication->image_location = '1';
       $employerApplication->status = 'Active';
        $category_execute = Categories::find()
            ->alias('a')
            ->where(['name' => $this->job_title]);
        $chk_cat = $category_execute->asArray()->one();

        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $cat_id = $categoriesModel->category_enc_id;
            $categoriesModel->name = $this->job_title;
            $utilitiesModel->variables['name'] = $this->job_title;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $employerApplication,$type='Jobs');
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                ->andWhere(['not', ['b.parent_enc_id' => null]])
                ->andWhere(['b.assigned_to' => $type='Jobs', 'b.parent_enc_id' => $this->job_profile])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $employerApplication, $type='Jobs');
            } else {
                $employerApplication->title = $chk_assigned['assigned_category_enc_id'];
                $utilitiesModel->variables['name'] = $chk_assigned['name'] . '-' . $employerApplication->application_number;
                $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $employerApplication->slug = $utilitiesModel->create_slug();
            }
        }
        $employerApplication->description = $this->description;
        $employerApplication->type = $this->job_type;
        $employerApplication->preferred_gender = $this->gender;
        $employerApplication->timings_from = date("H:i:s", strtotime("9:00"));
        $employerApplication->timings_to = date("H:i:s", strtotime("5:00"));
        $employerApplication->joining_date = date('Y-m-d H:i:s');
        $employerApplication->last_date = date('Y-m-d H:i:s');
        $employerApplication->created_on = date('Y-m-d H:i:s');
        $employerApplication->created_by = Yii::$app->user->identity->user_enc_id;
        $employerApplication->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        if ($employerApplication->save())
        {
            $applicationoptionsModel = new ApplicationOptions();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $applicationoptionsModel->option_enc_id = $utilitiesModel->encrypt();
            $applicationoptionsModel->application_enc_id = $employerApplication->application_enc_id;
            $applicationoptionsModel->wage_type = $wage_type;
            $applicationoptionsModel->fixed_wage = (($this->fixed_wage) ? str_replace(',', '', $this->fixed_wage) : null);
            $applicationoptionsModel->min_wage = (($this->min_salary) ? str_replace(',', '', $this->min_wage) : null);
            $applicationoptionsModel->max_wage = (($this->max_salary) ? str_replace(',', '', $this->max_wage) : null);
            $applicationoptionsModel->ctc = null;
            $applicationoptionsModel->wage_duration = 'Annually';
            $applicationoptionsModel->has_online_interview = 0;
            $applicationoptionsModel->has_questionnaire = 0;
            $applicationoptionsModel->pre_placement_offer = null;
            $applicationoptionsModel->has_placement_offer = null;
            $applicationoptionsModel->has_benefits = 0;
            $applicationoptionsModel->internship_duration = null;
            $applicationoptionsModel->internship_duration_type = null;
            $applicationoptionsModel->working_days = null;
            $applicationoptionsModel->saturday_frequency = null;
            $applicationoptionsModel->sunday_frequency = null;
            $applicationoptionsModel->interview_start_date = null;
            $applicationoptionsModel->interview_end_date = null;
            $applicationoptionsModel->created_on = date('Y-m-d H:i:s');
            $applicationoptionsModel->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$applicationoptionsModel->save()) {
                return false;
            }

            if (!empty($this->location)){
                foreach ($this->location as $val) {
                    $applicationPlacementLocationsModel = new ApplicationPlacementLocations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationPlacementLocationsModel->placement_location_enc_id = $utilitiesModel->encrypt();
                    $applicationPlacementLocationsModel->positions = 0;
                    $applicationPlacementLocationsModel->location_enc_id = $val;
                    $applicationPlacementLocationsModel->application_enc_id = $employerApplication->application_enc_id;
                    $applicationPlacementLocationsModel->created_on = date('Y-m-d H:i:s');
                    $applicationPlacementLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationPlacementLocationsModel->save()) {
                        return false;
                    }
                }
            }
            if (!empty($this->skills)){
                foreach ($this->skills as $skill) {
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
                        $applicationSkillsModel->application_enc_id = $employerApplication->application_enc_id;
                        $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                        $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$applicationSkillsModel->save()) {
                            return false;
                        }
                        $this->assignedSkill($skills_set['skill_enc_id'], $cat_id);
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
                            $applicationSkillsModel->application_enc_id = $employerApplication->application_enc_id;
                            $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                            $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                            if (!$applicationSkillsModel->save()) {
                                return false;
                            }
                            $this->assignedSkill($skillsModel->skill_enc_id, $cat_id);
                        }
                    }
                }
            }
        }
        else
        {
           return false;
        }
      return true;
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
    private function addNewAssignedCategory($category_id, $employerApplication, $type)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = $this->job_profile;
        $assignedCategoryModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $assignedCategoryModel->assigned_to = $type;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            $employerApplication->title = $assignedCategoryModel->assigned_category_enc_id;
            $utilitiesModel->variables['name'] = $this->job_title . '-' . $employerApplication->application_number;
            $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $employerApplication->slug = $utilitiesModel->create_slug();
        } else {
            return false;
        }
    }
}