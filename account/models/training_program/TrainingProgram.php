<?php

namespace account\models\training_program;

use common\models\ApplicationTypes;
use common\models\Categories;
use common\models\TrainingProgramApplication;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Utilities;

class TrainingProgram extends Model
{
    public $title;
    public $fees;
    public $profile;
    public $skills;
    public $cities;
    public $description;
    public $training_duration;
    public $training_duration_type;
    public $fees_type;
    public $business_hours;

    public function rules()
    {
        return [
            [['title','skills', 'cities','business_hours','fees','training_duration','training_duration_type','profile','fees_type','description'],'required'],
            [['title'],'string','max'=>50],
            [['fees'],'integer','max'=>10],
            [['training_duration'],'integer','max'=>12],
            [['title','fees'],'trim'],
        ];
    }

    public function save(){
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $utilitiesModel = new Utilities();
        $trainingProgramApplication = new TrainingProgramApplication();
        $type = ApplicationTypes::findOne(['name' => 'Trainings']);
        $application_type_enc_id = $type;
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $trainingProgramApplication->application_enc_id = $utilitiesModel->encrypt();
        $trainingProgramApplication->profie_enc_id = $this->profile;
        $trainingProgramApplication->assigned_category_id = $this->profile;
        $trainingProgramApplication->application_type_enc_id = $application_type_enc_id->application_type_enc_id;
        $trainingProgramApplication->description = $this->description;
        $trainingProgramApplication->fees = $this->fees;
        $trainingProgramApplication->fees_type = $this->fees_type;
        $trainingProgramApplication->training_duration = $this->training_duration;
        $trainingProgramApplication->training_duration_type = $this->training_duration_type;
        $category_execute = Categories::find()
            ->alias('a')
            ->where(['name' => $this->title]);
        $chk_cat = $category_execute->asArray()->one();
        if (empty($chk_cat)) {
            $categoriesModel = new Categories();
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
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $trainingProgramApplication,$type);
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                ->andWhere(['not', ['b.parent_enc_id' => null]])
                ->andWhere(['b.assigned_to' => $type, 'b.parent_enc_id' => $this->profile])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $trainingProgramApplication, $type);
            } else {
                $trainingProgramApplication->title = $chk_assigned['assigned_category_enc_id'];
                $utilitiesModel->variables['name'] = $chk_assigned['name'] . '-' . $this->designations . '-' . $trainingProgramApplication->application_number;
                $utilitiesModel->variables['table_name'] = TrainingProgramApplication::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $trainingProgramApplication->slug = $utilitiesModel->create_slug();
            }
        }
    }

    private function addNewAssignedCategory($category_id, $trainingProgramApplication, $type)
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