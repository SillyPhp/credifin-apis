<?php

namespace account\models\training_program;

use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\AssignedSkills;
use common\models\Categories;
use common\models\Skills;
use common\models\TrainingProgramApplication;
use common\models\TrainingProgramBatches;
use common\models\TrainingProgramSkills;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Utilities;

class TrainingProgram extends Model
{
    public $profile;
    public $title;
    public $training_duration;
    public $training_duration_type;
    public $batch_details;
    public $description;
    public $skills;

    public function rules()
    {
        return [
            [['title','skills','batch_details','training_duration','training_duration_type','profile','description'],'required'],
            [['title'],'string','max'=>50],
            [['training_duration'],'integer','max'=>12],
            [['title'],'trim'],
        ];
    }
    public function formName()
    {
        return '';
    }
    public function save(){
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $utilitiesModel = new Utilities();
        $trainingProgramApplication = new TrainingProgramApplication();
        $type = ApplicationTypes::findOne(['name' => 'Trainings'])->application_type_enc_id;
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $trainingProgramApplication->application_enc_id = $utilitiesModel->encrypt();
        $trainingProgramApplication->application_number = rand(1000, 10000) . time();
        $trainingProgramApplication->application_type_enc_id = $type;
        $trainingProgramApplication->profile_enc_id = $this->profile;
        $trainingProgramApplication->description = $this->description;
        $trainingProgramApplication->training_duration = $this->training_duration;
        $trainingProgramApplication->training_duration_type = $this->training_duration_type;
        $trainingProgramApplication->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $trainingProgramApplication->created_by = Yii::$app->user->identity->user_enc_id;
        $category_execute = Categories::find()
            ->alias('a')
            ->where(['name' => $this->title]);
        $chk_cat = $category_execute->asArray()->one();

        if (empty($chk_cat)) {
            $categoriesModel = new Categories();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $cat_id = $categoriesModel->category_enc_id;
            $categoriesModel->name = $this->title;
            $utilitiesModel->variables['name'] = $this->title;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $trainingProgramApplication, 'Training');
            } else {
                return  false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                ->andWhere(['not', ['b.parent_enc_id' => null]])
                ->andWhere(['b.assigned_to' => 'Training', 'b.parent_enc_id' => $this->profile])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $trainingProgramApplication, 'Training');
            } else {
                $utilitiesModel->variables['name'] = $this->title . '-' . $trainingProgramApplication->application_number;
                $utilitiesModel->variables['table_name'] = TrainingProgramApplication::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $trainingProgramApplication->slug = $utilitiesModel->create_slug();
                $trainingProgramApplication->title = $chk_assigned['assigned_category_enc_id'];
            }
        }
        if ($trainingProgramApplication->save())
        {
            if (!empty($this->skills)){
                foreach ($this->skills as $skill) {
                    $skills_set = Skills::find()
                        ->select(['skill_enc_id'])
                        ->where(['skill' => $skill])
                        ->asArray()
                        ->one();

                    if (!empty($skills_set)) {
                        $applicationSkillsModel = new TrainingProgramSkills();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                        $applicationSkillsModel->skill_enc_id = $skills_set['skill_enc_id'];
                        $applicationSkillsModel->application_enc_id = $trainingProgramApplication->application_enc_id;
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
                            $applicationSkillsModel = new TrainingProgramSkills();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                            $applicationSkillsModel->skill_enc_id = $skillsModel->skill_enc_id;
                            $applicationSkillsModel->application_enc_id = $trainingProgramApplication->application_enc_id;
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

            if (!empty($this->batch_details))
            {
                $arr = json_decode($this->batch_details,true);
                foreach ($arr as $a)
                {
                    $trainingProgramBatches = new TrainingProgramBatches();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $trainingProgramBatches->batch_enc_id = $utilitiesModel->encrypt();
                    $trainingProgramBatches->created_by = Yii::$app->user->identity->user_enc_id;
                    $trainingProgramBatches->created_on = date('Y-m-d H:i:s');
                    $trainingProgramBatches->application_enc_id = $trainingProgramApplication->application_enc_id;
                    $trainingProgramBatches->fees_methods = $a['method'];
                    $trainingProgramBatches->fees = $a['fees'];
                    $trainingProgramBatches->city_enc_id = $a['city'];
                    $trainingProgramBatches->seats = $a['seat'];
                    $trainingProgramBatches->start_time = $a['from'];
                    $trainingProgramBatches->end_time = $a['to'];
                    $trainingProgramBatches->days = json_encode($a['days']);
                    if (!$trainingProgramBatches->save())
                    {
                       return false;
                    }

                }
            }
            return true;
        }
        else
        {
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
    private function addNewAssignedCategory($category_id, $trainingProgramApplication, $typ)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = $this->profile;
        $assignedCategoryModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $assignedCategoryModel->assigned_to = $typ;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            $trainingProgramApplication->title = $assignedCategoryModel->assigned_category_enc_id;
            $utilitiesModel->variables['name'] = $this->title . '-' . $trainingProgramApplication->application_number;
            $utilitiesModel->variables['table_name'] = TrainingProgramApplication::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $trainingProgramApplication->slug = $utilitiesModel->create_slug();
        } else {
            return false;
        }
    }
}