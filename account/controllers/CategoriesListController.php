<?php

namespace account\controllers;

use Yii;
use common\models\CategoriesList;
use yii\web\Controller;
use yii\web\Response;
use common\models\JobDescription;
use common\models\Skills;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\EducationalRequirements;
use common\models\InterviewProcessFields;
use common\models\Designations;

class CategoriesListController extends Controller
{

    public function actionCategories($q = null, $id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'name' => '']];
        if (!is_null($q)) {
            $categories = CategoriesList::find()
                ->select(['category_enc_id AS id', 'name'])
                ->where(['like', 'name', $q])
                ->limit(20)
                ->asArray()
                ->all();
            $out['results'] = array_values($categories);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'name' => CategoriesList::find(['category_enc_id' => $id])->name];
        }
        return $out;
    }

    public function actionCategoriesData($q, $id, $type = 'Jobs')
    {
        $categories = Categories::find()
            ->alias('a')
            ->select(['a.name as value', 'a.category_enc_id as id', 'b.assigned_category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where('a.name LIKE "%' . $q . '%"')
            ->andWhere(['assigned_to' => $type, 'b.parent_enc_id' => $id])
            ->asArray()
            ->all();

        return json_encode($categories);
    }

    public function actionJobDescription()
    {
        $id = Yii::$app->request->post("data");
        $listvalues = JobDescription::find()
            ->alias('a')
            ->select(['a.id', 'a.job_description_enc_id', 'a.job_description'])
            ->joinWith(['assignedJobDescriptions b'], false)
            ->where(['b.category_enc_id' => $id])
            ->andWhere([
                'or',
                ['!=', 'a.status', 'a.Pending'],
                ['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['a.is_deleted' => 0])
            ->limit(20)
            ->asArray()
            ->all();
        return json_encode($listvalues);
    }

    public function actionJobQualifications()
    {
        $id = Yii::$app->request->post("data");
        $listvalues = EducationalRequirements::find()
            ->alias('a')
            ->select(['a.id', 'a.educational_requirement_enc_id', 'a.educational_requirement'])
            ->joinWith(['assignedEducationalRequirements b'], false)
            ->where(['b.category_enc_id' => $id])
            ->andWhere([
                'or',
                ['!=', 'a.status', 'a.Pending'],
                ['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['a.is_deleted' => 0])
            ->limit(20)
            ->asArray()
            ->all();

        return json_encode($listvalues);
    }

    public function actionJobSkills()
    {
        $id = Yii::$app->request->post("data");
        $skillvalues = Skills::find()
            ->alias('a')
            ->select(['a.id', 'a.skill_enc_id', 'a.skill'])
            ->joinWith(['assignedSkills b'], false)
            ->where(['b.category_enc_id' => $id])
            ->andWhere([
                'or',
                ['!=', 'a.status', 'a.Pending'],
                ['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['a.is_deleted' => 0])
            ->limit(6)
            ->asArray()
            ->all();
        return json_encode($skillvalues);
    }

    public function actionSkillsData($q)
    {

        $categories = Skills::find()
            ->select(['skill as value', 'skill_enc_id as id'])
            ->where('skill LIKE "%' . $q . '%"')
            ->andWhere([
                'or',
                ['!=', 'status', 'Pending'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['is_deleted' => 0])
            ->asArray()
            ->limit(20)
            ->all();
        return json_encode($categories);
    }

    public function actionEducations($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $list = EducationalRequirements::find()
            ->select(['id', 'educational_requirement_enc_id', 'educational_requirement'])
            ->where('educational_requirement LIKE "%' . $q . '%"')
            ->andWhere([
                'or',
                ['!=', 'status', 'Pending'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['is_deleted' => 0])
            ->limit(50)
            ->all();
        return $list;
    }

    public function actionDesignations($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $list = Designations::find()
            ->select(['id', 'designation_enc_id', 'designation'])
            ->where('designation LIKE "%' . $q . '%"')
            ->andWhere([
                'or',
                ['!=', 'status', 'Pending'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['is_deleted' => 0])
            ->limit(50)
            ->all();
        return $list;
    }

    public function actionDescription($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $list = JobDescription::find()
            ->select(['id', 'job_description_enc_id', 'job_description'])
            ->where('job_description LIKE "%' . $q . '%"')
            ->andWhere([
                'or',
                ['!=', 'status', 'Pending'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['is_deleted' => 0])
            ->limit(50)
            ->all();
        return $list;
    }

    public function actionProcessList()
    {

        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $list = InterviewProcessFields::find()
                ->select(['field_enc_id', 'field_name'])
                ->where(['interview_process_enc_id' => $id])
                ->asArray()
                ->all();

            return json_encode($list);
        }
    }

}
