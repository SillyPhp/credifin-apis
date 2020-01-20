<?php

namespace frontend\models\applications;

use common\models\ApplicationPlacementCities;
use common\models\AssignedCategories;
use common\models\ApplicationSkills;
use common\models\ApplicationTypes;
use common\models\ApplicationUnclaimOptions;
use common\models\AssignedSkills;
use common\models\Categories;
use common\models\EmployerApplications;
use common\models\Skills;
use common\models\UnclaimedOrganizations;
use common\models\Usernames;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
//use common\models\RandomColors;
use common\models\Utilities;

class QuickJob extends Model
{
    public $job_title;
    public $city;
    public $job_profile;
    public $job_type;
    public $typ;
    public $url;
    public $description;
    public $company_name;
    public $email;
    public $wage_type = 1;
    public $fixed_wage;
    public $min_salary;
    public $max_salary;
    public $gender;
    public $exp;
    public $skills;
    public $positions;
    public $country = 'India';
    public $currency;
    public $wage_duration;

    public function rules()
    {
        return [
            [['job_title', 'skills','positions','wage_duration','exp','description','city','currency','country','email','gender', 'job_profile', 'wage_type', 'job_type', 'url', 'company_name'], 'required'],
            [['fixed_wage', 'min_salary', 'max_salary'], 'safe'],
            [['url'], 'url', 'defaultScheme' => 'http'],
            [['job_title', 'company_name'], 'string', 'max' => 50],
            [['positions'], 'integer', 'max' => 100000],
            [['job_title','url','company_name','email','positions','fixed_wage','min_salary','max_salary'], 'trim'],
            ['email', 'email'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function save($typ)
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
        $application_type_enc_id = ApplicationTypes::findOne(['name' => $typ]);
        $employerApplication = new EmployerApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $employerApplication->application_enc_id = $utilitiesModel->encrypt();
        $employerApplication->application_number = rand(1000, 10000) . time();
        $employerApplication->application_type_enc_id = $application_type_enc_id->application_type_enc_id;
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
            $categoriesModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $employerApplication, $typ);
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                ->andWhere(['not', ['b.parent_enc_id' => null]])
                ->andWhere(['b.assigned_to' => $typ, 'b.parent_enc_id' => $this->job_profile])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $employerApplication, $typ);
            } else {
                $employerApplication->title = $chk_assigned['assigned_category_enc_id'];
                $utilitiesModel->variables['name'] = $this->company_name . '-' . $chk_assigned['name'] . '-' . $employerApplication->application_number;
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
        $employerApplication->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
        $chk_com = UnclaimedOrganizations::find()
            ->select(['organization_enc_id'])
            ->where(['name' => $this->company_name])
            ->one();
        if (!empty($chk_com)) :
            $employerApplication->unclaimed_organization_enc_id = $chk_com->organization_enc_id;
        else:
            $model = new UnclaimedOrganizations();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->organization_enc_id = $utilitiesModel->encrypt();
            $model->organization_type_enc_id = null;
            $utilitiesModel->variables['name'] = $this->company_name . rand(1000, 100000);
            $utilitiesModel->variables['table_name'] = UnclaimedOrganizations::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $slug = $utilitiesModel->create_slug();
            $slug_replace_str = str_replace("-", "", $slug);
            $model->slug = $slug_replace_str;
            $model->website = null;
            $model->name = $this->company_name;
            $model->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
            $model->initials_color = '#73ef9c';
            $model->status = 1;
            if ($model->save()) {
                $username = new Usernames();
                $username->username = $slug_replace_str;
                $username->assigned_to = 3;
                if (!$username->save()) {
                    return false;
                }
                $employerApplication->unclaimed_organization_enc_id = $model->organization_enc_id;
            }
        endif;
        if ($employerApplication->save()) {
            $unclaimOptions = new ApplicationUnclaimOptions();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $unclaimOptions->unclaim_options_enc_id = $utilitiesModel->encrypt();
            $unclaimOptions->application_enc_id = $employerApplication->application_enc_id;
            $unclaimOptions->email = $this->email;
            $unclaimOptions->currency_enc_id = $this->currency;
            $unclaimOptions->positions = $this->positions;
            $unclaimOptions->wage_duration = $this->wage_duration;
            $unclaimOptions->job_url = $this->url;
            $unclaimOptions->wage_type = $wage_type;
            $unclaimOptions->fixed_wage = (($this->fixed_wage) ? str_replace(',', '', $this->fixed_wage) : null);
            $unclaimOptions->min_wage = (($this->min_salary) ? str_replace(',', '', $this->min_salary) : null);
            $unclaimOptions->max_wage = (($this->max_salary) ? str_replace(',', '', $this->max_salary) : null);
            $unclaimOptions->created_on = date('Y-m-d H:i:s');;
            $unclaimOptions->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
            if (!$unclaimOptions->save()) {
                return false;
            }

            if (!empty($this->city)) {
                foreach ($this->city as $city) {
                    $placementCity = new ApplicationPlacementCities();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $placementCity->placement_cities_enc_id = $utilitiesModel->encrypt();
                    $placementCity->application_enc_id = $employerApplication->application_enc_id;
                    $placementCity->city_enc_id = $city;
                    $placementCity->created_on = date('Y-m-d H:i:s');
                    $placementCity->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
                    if (!$placementCity->save()) {
                        return false;
                    }
                }
            }
            if (!empty($this->skills)) {
                foreach ($this->skills as $skill) {
                    $data_skill = Skills::find()
                        ->alias('a')
                        ->select(['a.skill_enc_id'])
                        ->where(['skill' => $skill]);

                    $skills_set = $data_skill->asArray()->one();
                    if (!empty($skills_set)) {
                        $applicationSkillsModel = new ApplicationSkills();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                        $applicationSkillsModel->skill_enc_id = $skills_set['skill_enc_id'];
                        $applicationSkillsModel->application_enc_id = $employerApplication->application_enc_id;
                        $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                        $applicationSkillsModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
                        if ($applicationSkillsModel->save()) {
                            $chk_skill = $data_skill
                                ->innerJoin(AssignedSkills::tableName().'as b','b.skill_enc_id = a.skill_enc_id')
                                ->andWhere(['b.assigned_to'=>$typ,'category_enc_id'=>$cat_id])
                                ->asArray()
                                ->one();
                            if (empty($chk_skill)):
                            $this->assignedSkill($skills_set['skill_enc_id'], $cat_id,$typ);
                            endif;
                        }
                    } else {
                        $skillsModel = new Skills();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                        $skillsModel->skill = $skill;
                        $skillsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                        $skillsModel->created_on = date('Y-m-d H:i:s');
                        $skillsModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
                        if ($skillsModel->save()) {
                            $applicationSkillsModel = new ApplicationSkills();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                            $applicationSkillsModel->skill_enc_id = $skillsModel->skill_enc_id;
                            $applicationSkillsModel->application_enc_id = $employerApplication->application_enc_id;
                            $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                            $applicationSkillsModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
                            if ($applicationSkillsModel->save()) {
                                $this->assignedSkill($skillsModel->skill_enc_id, $cat_id,$typ);
                            }
                        }
                    }
                }
            }
        } else {
            return false;
        }
        return true;
    }

    private function assignedSkill($s_id, $cat_id,$typ)
    {
        $asignedSkillModel = new AssignedSkills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $asignedSkillModel->assigned_skill_enc_id = $utilitiesModel->encrypt();
        $asignedSkillModel->skill_enc_id = $s_id;
        $asignedSkillModel->assigned_to = $typ;
        $asignedSkillModel->category_enc_id = $cat_id;
        $asignedSkillModel->created_on = date('Y-m-d H:i:s');
        $asignedSkillModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
        if (!$asignedSkillModel->save()) {
            return false;
        }
    }

    private function addNewAssignedCategory($category_id, $employerApplication, $typ)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = $this->job_profile;
        $assignedCategoryModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $assignedCategoryModel->assigned_to = $typ;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
        if ($assignedCategoryModel->save()) {
            $utilitiesModel->variables['name'] = $this->company_name . '-' . $this->job_title . '-' . $employerApplication->application_number;
            $utilitiesModel->variables['table_name'] = EmployerApplications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $employerApplication->slug = $utilitiesModel->create_slug();
            $employerApplication->title = $assignedCategoryModel->assigned_category_enc_id;
        } else {
            return false;
        }
    }

}