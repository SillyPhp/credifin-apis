<?php
namespace frontend\controllers;
use common\models\Categories;
use common\models\Skills;
use common\models\Tags;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CategoriesListController extends Controller
{
    public function actionLoadTitles($id='', $type = 'Jobs')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $categories = Categories::find()
            ->alias('a')
            ->select(['a.name as value', 'a.category_enc_id as id', 'b.assigned_category_enc_id'])
            ->joinWith(['assignedCategories b'],false)
            ->andWhere([
                'b.assigned_to' => $type,
                'b.parent_enc_id' => $id,
            ])
            ->andWhere([
                'or',
                ['=', 'b.status', 'Approved'],
                ['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->asArray()
            ->all();

        return $categories;
    }

    public function actionTagsData($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $categories = Tags::find()
            ->select(['name as value', 'tag_enc_id as id'])
            ->where('name LIKE "%' . $q . '%"')
            ->asArray()
            ->limit(20)
            ->all();
        return $categories;
    }
   
    public function actionLoadTopics($type = 'Videos')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $categories = Categories::find()
            ->alias('a')
            ->select(['a.name as value', 'a.category_enc_id as id'])
            ->joinWith(['assignedCategories b'],false)
            ->andWhere([
                'b.assigned_to' => $type,
            ])
            ->andWhere(['=', 'b.status', 'Approved'])
            ->asArray()
            ->all();

        return $categories;
    }
    public function actionSkillsData($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $categories = Skills::find()
            ->select(['skill as value', 'skill_enc_id as id'])
            ->where('skill LIKE "%' . $q . '%"')
            ->andWhere([
                'or',
                ['=', 'status', 'Publish'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['is_deleted' => 0])
            ->asArray()
            ->limit(20)
            ->all();
        return $categories;
    }
}