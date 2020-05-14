<?php
namespace account\models\quiz;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\EmployerApplications;
use Yii;
use yii\base\Model;
use common\models\Utilities; 

class QuizModel extends Model
{
    public $formbuilderdata;
    public function rules()
    {
        return [
            [['formbuilderdata'], 'required']
        ];
    }

    public function formName()
    {
        return '';
    }

    public function addGrp($d)
    {
        $category_execute = Categories::find()
            ->alias('a')
            ->select(['a.id'])
            ->where(['a.name' => $d]);
        $chk_cat = $category_execute->asArray()->one();
        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $cat_id = $categoriesModel->category_enc_id;
            $categoriesModel->name = $d;
            $utilitiesModel->variables['name'] = $d;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
              return $this->addNewAssignedCategory($categoriesModel->category_enc_id,'Groups');
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->andWhere(['b.assigned_to' => 'Groups', 'b.parent_enc_id' => null])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
               return $this->addNewAssignedCategory($chk_cat['category_enc_id'], 'Groups');
            } else {
               return true;
            }
        }
    }
    public function addSub($d)
    {
        $category_execute = Categories::find()
            ->alias('a')
            ->select(['a.id'])
            ->where(['a.name' => $d]);
        $chk_cat = $category_execute->asArray()->one();
        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $cat_id = $categoriesModel->category_enc_id;
            $categoriesModel->name = $d;
            $utilitiesModel->variables['name'] = $d;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                return $this->addNewAssignedCategory($categoriesModel->category_enc_id,'Subject');
            } else {
                return false;
            }
        } else {
            $cat_id = $chk_cat['category_enc_id'];
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->andWhere(['b.assigned_to' => 'Subject', 'b.parent_enc_id' => null])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                return $this->addNewAssignedCategory($chk_cat['category_enc_id'], 'Subject');
            } else {
                return true;
            }
        }
    }
    private function addNewAssignedCategory($category_id, $type)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = null;
        $assignedCategoryModel->assigned_to = $type;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            return true;
        } else {
            return false;
        }
    }
}