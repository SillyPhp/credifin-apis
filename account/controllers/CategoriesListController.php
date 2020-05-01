<?php

namespace account\controllers;

use common\models\Qualifications;
use common\models\SpokenLanguages;
use common\models\Users;
use common\models\Utilities;
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

    public function actionLoadStreams($q=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Qualifications::find()
            ->select(['qualification_enc_id id','name'])
            ->where('name LIKE "' . $q . '%"')
            ->limit(20)
            ->asArray()
            ->all();
    }
    public function actionLoadCandidate($q=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Users::find()
            ->select(['first_name','last_name'])
            ->andWhere([
                'or',
                ['like', 'first_name', $q],
                ['like', 'last_name', $q],
            ])
            ->limit(20)
            ->asArray()
            ->all();
    }
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
            ->joinWith(['assignedCategories b'],false)
            ->where('a.name LIKE "%' . $q . '%"')
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
        return json_encode($categories);
    }

    public function actionJobProfiles($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $categories = AssignedCategories::find()
            ->alias('a')
            ->distinct()
            ->select(['a.category_enc_id cat_id', 'b.name value'])
            ->joinWith(['categoryEnc b'], false, 'INNER JOIN')
            ->andWhere('b.name LIKE "%' . $q . '%"')
            ->andWhere(['not', ['a.parent_enc_id' => null]])
            ->asArray()
            ->all();
        return $categories;
    }

    public function actionLanguages($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $languages = SpokenLanguages::find()
            ->select(['language_enc_id id', 'language value'])
            ->where('language LIKE "%' . $q . '%"')
            ->andWhere(['status'=>'Publish'])
            ->asArray()
            ->all();
        return $languages;
    }

    public function actionJobDescription()
    {
        $id = Yii::$app->request->post("data");
        $listvalues = JobDescription::find()
            ->alias('a')
            ->distinct()
            ->select(['a.job_description_enc_id jd_id', 'a.job_description jd'])
            ->joinWith(['assignedJobDescriptions b'], false)
            ->where(['b.category_enc_id' => $id])
            ->andWhere([
                'or',
                ['=', 'a.status', 'Publish'],
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
            ->distinct()
            ->select(['a.educational_requirement_enc_id e_id', 'a.educational_requirement ed_req'])
            ->joinWith(['assignedEducationalRequirements b'], false)
            ->where(['b.category_enc_id' => $id])
            ->andWhere([
                'or',
                ['=', 'a.status', 'Publish'],
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
            ->distinct()
            ->select(['a.skill_enc_id', 'a.skill'])
            ->joinWith(['assignedSkills b'], false)
            ->where(['b.category_enc_id' => $id])
            ->andWhere([
                'or',
                ['=', 'a.status', 'Publish'],
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
            ->alias('a')
            ->select(['a.skill value', 'a.skill_enc_id id'])
            ->where('skill LIKE "%' . $q . '%"')
            ->andWhere([
                'or',
                ['=', 'a.status', 'Publish'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['a.is_deleted' => 0])
            ->groupBy('skill')
            ->asArray()
            ->distinct('skill')
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
                ['=', 'status', 'Publish'],
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
                ['=', 'status', 'Publish'],
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
                ['=', 'status', 'Publish'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['is_deleted' => 0])
            ->limit(50)
            ->all();
        return $list;
    }

    public function actionFetchJd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $list = JobDescription::find()
            ->select(['id', 'job_description_enc_id', 'job_description'])
            ->andWhere([
                'or',
                ['=', 'status', 'Publish'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['is_deleted' => 0])
            ->all();
        return $list;
    }

    public function actionFetchEr()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $list = EducationalRequirements::find()
            ->select(['id', 'educational_requirement_enc_id', 'educational_requirement'])
            ->andWhere([
                'or',
                ['=', 'status', 'Publish'],
                ['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
            ])
            ->andWhere(['is_deleted' => 0])
            ->all();
        return $list;
    }

    public function actionFetchSkills($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $list = Skills::find()
            ->select(['skill', 'skill_enc_id'])
            ->where('skill LIKE "%' . $q . '%"')
            ->where(['is_deleted' => 0])
            ->asArray()
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

    public function actionProfiles($type= 'Jobs')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $primaryfields = Categories::find()
            ->alias('a')
            ->distinct()
            ->select(['a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->orderBy([new \yii\db\Expression('FIELD (a.name, "Others") ASC, a.name ASC')])
            ->where(['b.assigned_to' => $type, 'b.parent_enc_id' => NULL])
            ->andWhere(['b.status'=>'Approved'])
            ->asArray()
            ->all();
        return $primaryfields;
    }

    public function actionGroups($q=null,$type=null,$is_parent=null)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $sql = "SELECT DISTINCT `a`.`name` AS `word`, `a`.`category_enc_id` AS `id` FROM ".Categories::tableName()." `a` INNER JOIN ".AssignedCategories::tableName()." as `b` ON b.category_enc_id = a.category_enc_id WHERE (`b`.`parent_enc_id` IS NULL) AND (name LIKE '{$q}%' OR name LIKE '% {$q}%') AND (`b`.`status`='Approved') LIMIT 10";
            $p = Yii::$app->db->createCommand($sql)
                ->queryAll();
            return $p;
        }
    }

}
