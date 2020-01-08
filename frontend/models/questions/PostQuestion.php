<?php

namespace frontend\models\questions;
use common\models\AssignedCategories;
use common\models\AssignedTags;
use common\models\Categories;
use common\models\QuestionPoolTags;
use common\models\QuestionsPool;
use common\models\Tags;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class PostQuestion extends Model {

    public $question;
    public $tags;
    public $topic;
    public $privacy;

    public function rules()
    {
        return [
            [['question','topic','privacy'],'required'],
            [['tags'],'safe'],
            [['question','tags','topic','privacy'], 'trim'],
            [['question'], 'string','length' => [6, 200]],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function save()
    {
        $questionModel = new QuestionsPool();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $questionModel->question_pool_enc_id = $utilitiesModel->encrypt();
        $questionModel->questaion_number = rand(1000, 10000) . time();
        $questionModel->question = $this->question;
        $questionModel->difficulty = 'easy';
        $questionModel->privacy = $this->privacy;
        $utilitiesModel->variables['name'] = $this->question;
        $utilitiesModel->variables['table_name'] = QuestionsPool::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $questionModel->slug = $utilitiesModel->create_slug();
        $questionModel->created_by = Yii::$app->user->identity->user_enc_id;
        $category_execute = Categories::find()
            ->alias('a')
            ->where(['name' => $this->topic]);
        $chk_cat = $category_execute->select(['category_enc_id'])->asArray()->one();
        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $categoriesModel->name = $this->topic;
            $utilitiesModel->variables['name'] = $this->topic;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                $this->addNewAssignedCategory($categoriesModel->category_enc_id, $questionModel,'Videos');
            } else {
                return false;
            }
        } else {
            $chk_assigned = $category_execute
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                ->andWhere(['b.assigned_to' => 'Videos', 'b.parent_enc_id' => null])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                $this->addNewAssignedCategory($chk_cat['category_enc_id'], $questionModel, 'Videos');
            } else {
                $questionModel->topic_enc_id = $chk_assigned['assigned_category_enc_id'];
            }
        }
        if ($questionModel->save()) {
            if (!empty($this->tags)) {
            foreach ($this->tags as $tag) {
                $tags = Tags::find()
                    ->alias('a')
                    ->select(['a.tag_enc_id'])
                    ->where(['name' => $tag]);
                $chk_tags = $tags->asArray()->one();
                if (empty($chk_tags)) {
                    $tagsModal = new Tags();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $tagsModal->tag_enc_id = $utilitiesModel->encrypt();
                    $tagsModal->name = $tag;
                    $utilitiesModel->variables['name'] = $tag;
                    $utilitiesModel->variables['table_name'] = Tags::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $tagsModal->slug = $utilitiesModel->create_slug();
                    $tagsModal->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($tagsModal->save()) {
                        $this->assignTags($tagsModal->tag_enc_id, $questionModel->question_pool_enc_id);
                    } else {
                        return false;
                    }
                } else {
                    $chk_assign_tag = $tags
                        ->innerJoin(AssignedTags::tableName() . 'as b', 'b.tag_enc_id = a.tag_enc_id')
                        ->andWhere(['b.assigned_to' => 6])
                        ->asArray()
                        ->one();
                    if (empty($chk_assign_tag)) {
                        $this->assignTags($chk_tags['tag_enc_id'], $questionModel->question_pool_enc_id);
                    } else {
                        $this->QuestionPool($chk_assign_tag['tag_enc_id'], $questionModel->question_pool_enc_id);
                    }
                }

            }
        }
            return [
                'status'=>true,
                'slug'=>$questionModel->slug,
            ];
        }
        else
        {
            return false;
        }

    }

    private function QuestionPool($tag_id,$question_id)
    {
        $questionTags = new QuestionPoolTags();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $questionTags->question_tag_enc_id = $utilitiesModel->encrypt();
        $questionTags->question_pool_enc_id = $question_id;
        $questionTags->tag_enc_id = $tag_id;
        $questionTags->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$questionTags->save())
        {
            return false;
        }
    }

    private function assignTags($tag_id,$question_id)
    {
        $assignedTagsModel = new AssignedTags();
        $utilitesModel = new Utilities();
        $utilitesModel->variables['string'] = time() . rand(100, 100000);
        $assignedTagsModel->assigned_tag_enc_id = $utilitesModel->encrypt();
        $assignedTagsModel->tag_enc_id = $tag_id;
        $assignedTagsModel->assigned_to = 6;
        $assignedTagsModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedTagsModel->save())
        {
            $this->QuestionPool($assignedTagsModel->tag_enc_id,$question_id);
        }
        else
        {
            return false;
        }
    }

    private function addNewAssignedCategory($category_id, $questionModel, $type)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = null;
        $assignedCategoryModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $assignedCategoryModel->assigned_to = $type;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            $questionModel->topic_enc_id = $assignedCategoryModel->assigned_category_enc_id;
        } else {
            return false;
        }
    }
}
