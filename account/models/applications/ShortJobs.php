<?php

namespace account\models\applications;

use common\models\ApplicationOptions;
use common\models\ApplicationPlacementCities;
use common\models\ApplicationSkills;
use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\AssignedSkills;
use common\models\Categories;
use common\models\EmployerApplications;
use common\models\Skills;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Utilities;

class ShortJobs extends Model
{
    public $job_title;
    public $location;
    public $job_profile;
    public $job_type;
    public $description;
    public $positions;
    public $email;
    public $wage_duration;
    public $wage_type = 1;
    public $fixed_wage;
    public $min_salary;
    public $max_salary;
    public $gender;
    public $exp;
    public $skills;
    public $country = 'India';
    public $currency;

    public function rules()
    {
        return [
            [['job_title', 'skills', 'wage_duration', 'positions', 'description', 'exp', 'location', 'currency', 'country', 'gender', 'job_profile', 'wage_type', 'job_type'], 'required'],
            [['email'], 'safe'],
            ['fixed_wage', 'required', 'when' => function ($model) {
                return $model->wage_type == 1;
            }, 'whenClient' => "function (attribute, value) {
            return $(\"input[name='wage_type']:checked\").val() == 1;
            }"],
            ['min_salary', 'required', 'when' => function ($model) {
                return $model->wage_type == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $(\"input[name='wage_type']:checked\").val() == 2;
            }"],
            ['max_salary', 'required', 'when' => function ($model) {
                return $model->wage_type == 2;
            }, 'whenClient' => "function (attribute, value) {
            return $(\"input[name='wage_type']:checked\").val() == 2;
            }"],
            [['job_title'], 'string', 'max' => 50],
            [['job_title', 'fixed_wage', 'min_salary', 'max_salary', 'positions', 'email'], 'trim'],
            [['positions'], 'integer', 'max' => 100000],
            [['fixed_wage'], 'string', 'min' => 4, 'max' => 15],
            ['email', 'email'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function update($editid, $typ)
    {
        $employerApplicationsModel = EmployerApplications::find()
            ->where(['application_enc_id' => $editid])
            ->one();
        $employerApplicationsModel->experience = $this->exp;
        $employerApplicationsModel->type = $this->job_type;
        $employerApplicationsModel->preferred_gender = $this->gender;
        $employerApplicationsModel->last_updated_on = date('Y-m-d H:i:s');
        $employerApplicationsModel->last_updated_by = Yii::$app->user->identity->user_enc_id;
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
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $employerApplicationsModel, $typ);
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
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $employerApplicationsModel, $typ);
            } else {
                $employerApplicationsModel->title = $chk_assigned['assigned_category_enc_id'];
            }
        }
        $employerApplicationsModel->description = $this->description;
        if ($employerApplicationsModel->save()) {
            $getSkills = $this->skills;
            if (!empty($this->skills)) {
                $skill_set = [];
                foreach ($getSkills as $val) {
                    $chk_skill = Skills::find()
                        ->distinct()
                        ->alias('a')
                        ->select(['a.skill_enc_id'])
                        ->where(['a.skill' => $val])
                        ->asArray()
                        ->one();
                    if (!empty($chk_skill)) {
                        $skill_set[] = $chk_skill['skill_enc_id'];
                    } else {
                        $skillsModel = new Skills();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                        $skillsModel->skill = $val;
                        $skillsModel->created_on = date('Y-m-d H:i:s');
                        $skillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$skillsModel->save()) {
                            return false;
                        }
                        $skill_set[] = $skillsModel->skill_enc_id;
                    }
                }
            } else {
                $skill_set = [];
            }
            $userSkills = ApplicationSkills::find()
                ->where(['application_enc_id' => $editid])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();
            $skillArray = ArrayHelper::getColumn($userSkills, 'skill_enc_id');
            $new_skill = array_diff($skill_set, $skillArray);
            $delet_skill = array_diff($skillArray, $skill_set);
            if (!empty($new_skill)) {
                foreach ($new_skill as $val) {
                    $applicationSkillsModel = new ApplicationSkills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                    $applicationSkillsModel->skill_enc_id = $val;
                    $applicationSkillsModel->application_enc_id = $editid;
                    $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                    $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$applicationSkillsModel->save()) {
                        return false;
                    } else {
                        $this->assignedSkill($applicationSkillsModel->skill_enc_id, $cat_id, $typ);
                    }
                }
            }
            if (!empty($delet_skill)) {
                foreach ($delet_skill as $val) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ApplicationSkills::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $editid, 'skill_enc_id' => $val])
                        ->execute();
                    if (!$update) {
                        return false;
                    }
                }
            }
            $applicationoptionsModel = ApplicationOptions::find()
                ->where(['application_enc_id' => $editid])
                ->one();
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
            $applicationoptionsModel->wage_type = $wage_type;
            $applicationoptionsModel->fixed_wage = (($this->fixed_wage) ? str_replace(',', '', $this->fixed_wage) : null);
            $applicationoptionsModel->min_wage = (($this->min_salary) ? str_replace(',', '', $this->min_salary) : null);
            $applicationoptionsModel->max_wage = (($this->max_salary) ? str_replace(',', '', $this->max_salary) : null);
            $applicationoptionsModel->ctc = null;
            $applicationoptionsModel->wage_duration = $this->wage_duration;
            $applicationoptionsModel->currency_enc_id = $this->currency;
            $applicationoptionsModel->has_online_interview = 0;
            $applicationoptionsModel->has_questionnaire = 0;
            $applicationoptionsModel->positions = $this->positions;
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

            if (!$applicationoptionsModel->save()) {
                return false;
            }

            if (!empty($this->location)) {
                $pl_loc = ApplicationPlacementCities::find()
                    ->where(['application_enc_id' => $editid])
                    ->andWhere(['is_deleted' => 0])
                    ->select(['city_enc_id'])
                    ->asArray()
                    ->all();
                $p = ArrayHelper::getColumn($pl_loc, 'city_enc_id');
                $ploc_delt = array_diff($p, $this->location);
                $new_loc = array_diff($this->location, $p);
                if (!empty($new_loc)) {
                    foreach ($new_loc as $v) {
                        $placementCity = new ApplicationPlacementCities();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $placementCity->placement_cities_enc_id = $utilitiesModel->encrypt();
                        $placementCity->application_enc_id = $employerApplicationsModel->application_enc_id;
                        $placementCity->city_enc_id = $v;
                        $placementCity->created_on = date('Y-m-d H:i:s');
                        $placementCity->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$placementCity->save()) {
                            return false;
                        }
                    }
                }
                if (!empty($ploc_delt)) {
                    foreach ($ploc_delt as $v) {
                        $update = ApplicationPlacementCities::find()
                            ->where(['application_enc_id' => $editid])
                            ->andWhere(['city_enc_id' => $v])
                            ->one();
                        $update->is_deleted = 1;
                        if (!$update) {
                            return false;
                        }

                    }
                }
            }

        }
        return true;
    }

    public function save($t)
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
        $application_type_enc_id = ApplicationTypes::findOne(['name' => $t]);
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
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $employerApplication, $type = 'Jobs');
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                ->andWhere(['not', ['b.parent_enc_id' => null]])
                ->andWhere(['b.assigned_to' => $type = 'Jobs', 'b.parent_enc_id' => $this->job_profile])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $employerApplication, $type = 'Jobs');
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
        $employerApplication->last_date = date('Y-m-d', strtotime(' + 56 days'));
        $employerApplication->created_on = date('Y-m-d H:i:s');
        $employerApplication->created_by = Yii::$app->user->identity->user_enc_id;
        $employerApplication->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        if ($employerApplication->save()) {
            $applicationoptionsModel = new ApplicationOptions();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $applicationoptionsModel->option_enc_id = $utilitiesModel->encrypt();
            $applicationoptionsModel->application_enc_id = $employerApplication->application_enc_id;
            $applicationoptionsModel->wage_type = $wage_type;
            $applicationoptionsModel->fixed_wage = (($this->fixed_wage) ? str_replace(',', '', $this->fixed_wage) : null);
            $applicationoptionsModel->min_wage = (($this->min_salary) ? str_replace(',', '', $this->min_salary) : null);
            $applicationoptionsModel->max_wage = (($this->max_salary) ? str_replace(',', '', $this->max_salary) : null);
            $applicationoptionsModel->ctc = null;
            $applicationoptionsModel->wage_duration = $this->wage_duration;
            $applicationoptionsModel->currency_enc_id = $this->currency;
            $applicationoptionsModel->has_online_interview = 0;
            $applicationoptionsModel->has_questionnaire = 0;
            $applicationoptionsModel->positions = $this->positions;
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

            if (!empty($this->location)) {
                foreach ($this->location as $city) {
                    $placementCity = new ApplicationPlacementCities();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $placementCity->placement_cities_enc_id = $utilitiesModel->encrypt();
                    $placementCity->application_enc_id = $employerApplication->application_enc_id;
                    $placementCity->city_enc_id = $city;
                    $placementCity->created_on = date('Y-m-d H:i:s');
                    $placementCity->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$placementCity->save()) {
                        return false;
                    }
                }
            }
            if (!empty($this->skills)) {
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
        } else {
            return false;
        }
        return true;
    }

    public function setData($editid, $typ)
    {
        $modelData = EmployerApplications::find()
            ->alias('a')
            ->select(['title', 'type', 'h.name country_name', 'positions', 'application_type_enc_id', 'description', 'experience', 'a.application_enc_id', 'preferred_gender', 'fixed_wage', 'min_wage', 'max_wage', 'wage_type', 'wage_duration', 'currency_enc_id'])
            ->where(['a.application_enc_id' => $editid])
            ->joinWith(['applicationOptions b'], false)
            ->joinWith(['applicationPlacementCities d' => function ($b) {
                $b->select(['e.city_enc_id', 'd.application_enc_id', 'e.name']);
                $b->onCondition(['d.is_deleted' => 0]);
                $b->joinWith(['cityEnc e' => function ($b) {
                    $b->joinWith(['stateEnc i' => function ($b) {
                        $b->joinWith(['countryEnc h']);
                    }]);
                }], false);
            }])
            ->joinWith(['applicationSkills f' => function ($b) {
                $b->select(['f.application_enc_id', 'g.skill']);
                $b->onCondition(['f.is_deleted' => 0]);
                $b->joinWith(['skillEnc g'], false);
            }])
            ->asArray()
            ->one();

        $profile = AssignedCategories::find()
            ->alias('a')
            ->select(['a.assigned_category_enc_id', 'b.name', 'b.category_enc_id', 'a.parent_enc_id'])
            ->joinWith(['categoryEnc b'], false)
            ->where(['not', ['a.parent_enc_id' => null]])
            ->andWhere(['assigned_to' => $typ, 'assigned_category_enc_id' => $modelData['title']])->asArray()->one();
        switch ($modelData['wage_type']) {
            case 'Fixed':
                $wage_type = 1;
                break;
            case 'Negotiable':
                $wage_type = 2;
                break;
            case 'Performance Based':
                $wage_type = 3;
                break;
            case 'Unpaid':
                $wage_type = 0;
                break;
            default:
                $wage_type = 2;
        }
        $this->wage_type = $wage_type;
        $this->wage_duration = $modelData['wage_duration'];
        $this->currency = $modelData['currency_enc_id'];
        $this->wage_type = $wage_type;
        $this->job_type = $modelData['type'];
        $this->job_profile = $profile['parent_enc_id'];
        $this->job_title = $profile['name'];
        $this->gender = $modelData['preferred_gender'];
        $this->country = $modelData['country_name'];
        $this->max_salary = utf8_encode(money_format('%!.0n', $modelData['max_wage']));
        $this->min_salary = utf8_encode(money_format('%!.0n', $modelData['min_wage']));
        $this->fixed_wage = utf8_encode(money_format('%!.0n', $modelData['fixed_wage']));
        $this->exp = $modelData['experience'];
        $this->description = $modelData['description'];
        $this->email = $modelData['email'];
        $this->positions = $modelData['positions'];;
        if (!empty($modelData['applicationPlacementCities'])):
            $cities = ArrayHelper::getColumn($modelData['applicationPlacementCities'], 'city_enc_id');
            $cities_list = ArrayHelper::map($modelData['applicationPlacementCities'], 'city_enc_id', 'name');
        endif;
        $this->location = $cities;
        return
            [
                'mod' => $this,
                'list' => $cities_list,
                'skill' => ArrayHelper::getColumn($modelData['applicationSkills'], 'skill')
            ];
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