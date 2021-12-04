<?php

namespace account\controllers;

use account\models\applications\ApplicationForm;
use common\models\DropResumeAppliedApplications;
use common\models\DropResumeAppliedTitles;
use common\models\DropResumeChoiceTitles;
use common\models\DropResumeOrgApplication;
use common\models\DropResumeSelectedLocations;
use common\models\DropResumeSelectedTitles;
use common\models\DropResumeUnclaimOrgApplication;
use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\spaces\Spaces;
use common\models\UserResume;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Categories;
use common\models\AssignedCategories;
use common\models\DropResumeApplicationLocations;
use common\models\DropResumeApplications;
use common\models\DropResumeApplicationTitles;
use common\models\OrganizationAssignedCategories;
use common\models\OrganizationLocations;
use common\models\Utilities;
use yii\web\Response;

class ResumeController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionFirst()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $category_enc_id = Yii::$app->request->post('parent_id');
            $type = Yii::$app->request->post('type');
            $organization_created_titles = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name', 'a.title assigned_category_enc_id'])
                ->distinct()
                ->where(['a.organization_enc_id'=>Yii::$app->user->identity->organization->organization_enc_id])
                ->andWhere(['b.assigned_to'=>$type])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->asArray()->all();
            $pre_selected_choices = DropResumeChoiceTitles::find()
                ->alias('a')
                ->select(['c.name','b.assigned_category_enc_id'])
                ->where(['title_for'=>$type])
                ->andWhere(['b.parent_enc_id'=>$category_enc_id])
                ->andWhere(['a.is_deleted'=>0])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.assigned_category_enc_id')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->asArray()
                ->all();
            $result = array_merge($organization_created_titles, $pre_selected_choices);
            $unique = array_map("unserialize", array_unique(array_map("serialize", $result)));

            //intersect from job unselected titles
            //**
            //intersect from job unselected titles
            $already_selected_categories = $this->savedData($category_enc_id, $type);
            $response = [];
            $response["parent_enc_id"] = $category_enc_id;
            $response["already_selected_categories"] = $already_selected_categories;
            $response["second_modal_categories"] = $unique;
            return json_encode($response);
        }
    }

    public function actionAdd()
    {
        $failure = ['status' => 201];
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $new_value = Yii::$app->request->post('new_value');
            $parent_enc_id = Yii::$app->request->post('parent_enc_id');
            $type = Yii::$app->request->post('type');

            $data = $this->addCategory($new_value);

            if ($this->alreadyHave($data['category_enc_id'], $parent_enc_id)) {
                return json_encode($failure);
            }

            if ($c_e_id = $this->addCategory($new_value)) {
                $assigned_category = new AssignedCategories();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $assigned_category->assigned_category_enc_id = $utilitiesModel->encrypt();
                $assigned_category->category_enc_id = $c_e_id->category_enc_id;
                $assigned_category->parent_enc_id = $parent_enc_id;
                $assigned_category->assigned_to = $type;
                $assigned_category->status = 'Pending';
                $assigned_category->created_on = date('Y-m-d H:i:s');
                $assigned_category->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
                $assigned_category->created_by = Yii::$app->user->identity->user_enc_id;
                if ($assigned_category->save()) {
                    $data = [];
                    $data['category_enc_id'] = $c_e_id->category_enc_id;
                    $data['name'] = $c_e_id->name;
                    return json_encode($data);
                }
            } else {
                return json_encode($failure);
            }

        } else {

            return json_encode($failure);
        }
    }

    private function alreadyHave($category_enc_id, $parent_enc_id)
    {
        $alreadyhave = AssignedCategories::find()
            ->where(['category_enc_id' => $category_enc_id])
            ->andWhere(['parent_enc_id' => $parent_enc_id])
            ->exists();

        return $alreadyhave;
    }

    private function addCategory($new_value)
    {

        $already_exists = Categories::find()
            ->select(['name', 'category_enc_id'])
            ->where(['name' => $new_value])
            ->one();

        if ($already_exists) {
            return $already_exists;
        } else {
            $new_category = new Categories();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $new_category->category_enc_id = $utilitiesModel->encrypt();
            $new_category->name = $new_value;
            $utilitiesModel->variables['name'] = $new_value;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $new_category->slug = $utilitiesModel->create_slug();
            $new_category->created_on = date('Y-m-d H:i:s');
            $new_category->created_by = Yii::$app->user->identity->user_enc_id;
            if ($new_category->save()) {
                return $new_category;
            }
        }

    }

    private function checkParent($parent_id, $type)
    {
        $check_parent = OrganizationAssignedCategories::find()
            ->where(['category_enc_id' => $parent_id])
            ->andWhere(['parent_enc_id' => NULL])
            ->andWhere(['assigned_to' => $type])
            ->andWhere(['organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['is_deleted' => 0])
            ->exists();

        return $check_parent;
    }

    public function actionSave()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $second_category_enc_id = Yii::$app->request->post('checked');
            $parent_enc_id = Yii::$app->request->post('parent_enc_id');
            $type = Yii::$app->request->post('type');

            $selected_values = [];

            $already_selected = $this->savedData($parent_enc_id, $type);
            foreach ($already_selected as $a) {
                array_push($selected_values, $a["category_enc_id"]);
            }

            $to_be_added = array_diff($second_category_enc_id, $selected_values);
            $to_be_deleted = array_diff($selected_values, $second_category_enc_id);

            if (!$this->checkParent($parent_enc_id, $type)) {
                $this->saveFirstCategory($parent_enc_id, $type);
            }

            $num = count($to_be_added);
            if ($num > 0) {
                foreach ($to_be_added as $add) {
                    $this->saveSecondCategory($add, $parent_enc_id, $type);
                }
            }

            $num = count($to_be_deleted);
            if ($num > 0) {
                foreach ($to_be_deleted as $del) {
                    $this->deleteData($del, $parent_enc_id, $type);
                }
            }

            $response = [

                'status' => 200
            ];

            return json_encode($response);
        }
    }

    private function deleteData($second_enc_id, $parent_enc_id, $type)
    {
        $toBeDeleted = OrganizationAssignedCategories::find()
            ->where(['parent_enc_id' => $parent_enc_id])
            ->andWhere(['category_enc_id' => $second_enc_id])
            ->andWhere(['organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['assigned_to' => $type])
            ->one();
        $toBeDeleted->is_deleted = 1;
        $toBeDeleted->update();
    }

    private function savedData($category_enc_id, $type)
    {
        $already_selected = OrganizationAssignedCategories::find()
            ->select(['category_enc_id'])
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['parent_enc_id' => $category_enc_id])
            ->andWhere(['assigned_to' => $type])
            ->andWhere(['is_deleted' => 0])
            ->asArray()
            ->all();
        return $already_selected;
    }

    private function saveFirstCategory($category_enc_id, $type)
    {
        $organization_a_c = new OrganizationAssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $organization_a_c->assigned_category_enc_id = $utilitiesModel->encrypt();
        $organization_a_c->category_enc_id = $category_enc_id;
        $organization_a_c->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
        $organization_a_c->assigned_to = $type;
        $organization_a_c->created_on = date('Y-m-d H:i:s');
        $organization_a_c->created_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->save();
    }

    private function saveSecondCategory($c_enc_id, $p_enc_id, $type)
    {
        $organization_a_c = new OrganizationAssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $organization_a_c->assigned_category_enc_id = $utilitiesModel->encrypt();
        $organization_a_c->category_enc_id = $c_enc_id;
        $organization_a_c->parent_enc_id = $p_enc_id;
        $organization_a_c->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
        $organization_a_c->assigned_to = $type;
        $organization_a_c->created_on = date('Y-m-d H:i:s');
        $organization_a_c->created_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->save();
    }

    public function actionFinalData()
    {
        $type = Yii::$app->request->post('type');
        $selectedfields = DropResumeOrgApplication::find()
            ->alias('a')
            ->select(['a.application_enc_id','e.category_enc_id','e.name','COUNT(e.name) count','CONCAT("' . Url::to('@commonAssets/categories/svg/') . '", e.icon) icon'])
            ->where(['a.organization_enc_id'=>Yii::$app->user->identity->organization_enc_id])
            ->joinWith(['appliedApplicationEnc b'=>function($x) use ($type){
                $x->joinWith(['dropResumeAppliedTitles c'=>function($x) use ($type){
                    $x->joinWith(['assignedCategoryEnc d'=>function($x) use ($type){
                        $x->andWhere(['assigned_to'=>$type]);
                        $x->joinWith(['parentEnc e'],false);
                    }],false);
                }],false);
            }],false)
            ->groupBy(['e.category_enc_id'])
            ->asArray()
            ->all();
        return json_encode($selectedfields);
    }

    private function dropResumeCounts($title_id, $type)
    {

        $parent_id = OrganizationAssignedCategories::find()
            ->select(['category_enc_id'])
            ->where(['assigned_category_enc_id' => $title_id])
            ->asArray()
            ->one();

        $childs = OrganizationAssignedCategories::find()
            ->select(['assigned_category_enc_id'])
            ->where(['parent_enc_id' => $parent_id['category_enc_id']])
            ->andWhere(['organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['assigned_to' => $type])
            ->asArray()
            ->all();

        $titles = [];
        foreach ($childs as $c) {
            array_push($titles, $c["assigned_category_enc_id"]);
        }

        $data = DropResumeApplications::find()
            ->alias('a')
            ->joinWith(['userEnc b' => function ($x) {
                $x->select(['g.city_enc_id', 'g.name city_name', 'f.category_enc_id', 'b.job_function', 'f.name', 'b.user_enc_id', 'b.username', 'b.first_name', 'b.last_name', 'b.image', 'b.image_location', 'c.created_by']);
                $x->joinWith(['userSkills c' => function ($y) {
                    $y->select(['c.created_by', 'd.skill', 'c.skill_enc_id']);
                    $y->onCondition(['c.is_deleted' => 0]);
                    $y->joinWith(['skillEnc d'], false);
                }]);
                $x->joinWith(['jobFunction f'], false);
                $x->joinWith(['cityEnc g'], false);
            }])
            ->joinWith(['dropResumeApplicationTitles h'])
            ->where(['in', 'h.title', $titles])
            ->andWhere([
                'or',
                ['a.status' => 0],
                ['a.status' => 1]
            ])
            ->asArray()
            ->all();

        return $data;
    }

    public function actionResumeType()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $type = Yii::$app->request->post('selected_answer');
            $company_name = Yii::$app->request->post('company_name');
            $link_type = Yii::$app->request->post('link_type');

            if ($link_type === 'company') {
                $company_name = Yii::$app->request->post('company_name');
            } else if ($link_type === 'application') {
                $org = EmployerApplications::find()
                    ->alias('a')
                    ->select(['b.slug'])
                    ->joinWith(['organizationEnc b'])
                    ->where(['a.slug' => $company_name])
                    ->asArray()
                    ->one();

                $company_name = $org['slug'];
            }

            $model = new ApplicationForm();
            $data = $model->getPrimaryFields($type);

            return json_encode($data);
        }
    }

    public function actionJobProfile()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $selected_answer = Yii::$app->request->post('selected_answer');
            $type = Yii::$app->request->post('type');
            $company_name = Yii::$app->request->post('company_name');
            $link_type = Yii::$app->request->post('link_type');

            if ($link_type === 'company') {
                $company_name = Yii::$app->request->post('company_name');
            } else if ($link_type === 'application') {
                $org = EmployerApplications::find()
                    ->alias('a')
                    ->select(['b.slug'])
                    ->joinWith(['organizationEnc b'])
                    ->where(['a.slug' => $company_name])
                    ->asArray()
                    ->one();

                $company_name = $org['slug'];
            }

            $org_id = Organizations::findOne(['slug'=>$company_name])->organization_enc_id;
            $organization_created_titles = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name', 'a.title assigned_category_enc_id'])
                ->distinct()
                ->where(['a.organization_enc_id'=>$org_id])
                ->andWhere(['b.assigned_to'=>$type])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->asArray()->all();

            $pre_selected_choices = DropResumeChoiceTitles::find()
                ->alias('a')
                ->select(['c.name','b.assigned_category_enc_id'])
                ->where(['title_for'=>$type])
                ->andWhere(['b.parent_enc_id'=>$selected_answer])
                ->andWhere(['a.is_deleted'=>0])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.assigned_category_enc_id')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->asArray()
                ->all();
            $result = array_merge($organization_created_titles, $pre_selected_choices);
            $unique = array_map("unserialize", array_unique(array_map("serialize", $result)));

            //intersect from job unselected titles
            //**
            //intersect from job unselected titles
            $location = OrganizationLocations::find()
                ->alias('a')
                ->distinct()
                ->select(['c.name', 'c.city_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->joinWith(['cityEnc c'])
                ->where(['b.slug' => $company_name])
                ->andWhere(['a.is_deleted' => 0])
                ->asArray()
                ->all();
            $username = Yii::$app->user->identity->username;
            $data = [];
            $data['sub_categories'] = $unique;
            $data['location'] = $location;
            $data['username'] = $username;

            return json_encode($data);
        }
    }

    public function actionCandidateApplication()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $experience = $data['experience'];
            $job_title = $data['job_title'];
            $location = $data['locations'];
            $is_claimed = $data['is_claim'];
            $org_id = $data['org_id'];
            $failure = [
                'message' => 201
            ];

            $success = [
                'message' => 200
            ];

            if ($applied_app_enc_id = $this->alreadyApplied($is_claimed,$org_id)) {
                $alreadySelectedLocation = $this->getAlreadyAppliedLocation($applied_app_enc_id['applied_application_enc_id']);
                $selectedLocation = [];
                for ($i = 0; $i < count($alreadySelectedLocation); $i++) {
                    foreach ($alreadySelectedLocation[$i] as $c) {
                        array_push($selectedLocation, $c);
                    }
                }
                $to_be_added_location = array_diff($location, $selectedLocation);


                $alreadySelectedTitle = $this->getAlreadyAppliedTitle($applied_app_enc_id['applied_application_enc_id']);
                $selectedTitle = [];
                for ($i = 0; $i < count($alreadySelectedTitle); $i++) {
                    foreach ($alreadySelectedTitle[$i] as $c) {
                        array_push($selectedTitle, $c);
                    }
                }
                $to_be_added_title = array_diff($job_title, $selectedTitle);

                $updateExp = DropResumeAppliedApplications::find()
                    ->where(['applied_application_enc_id' => $applied_app_enc_id['applied_application_enc_id']])
                    ->one();
                $updateExp->experience = $experience;
                if (!$updateExp->save()){
                    return json_encode($failure);
                }
                if (count($to_be_added_location) > 0) {
                    foreach ($to_be_added_location as $loc) {
                        if (!$this->dropResumeApplicationLocation($loc, $applied_app_enc_id['applied_application_enc_id'])) {
                            return json_encode($failure);
                        }
                    }
                }
                if (count($to_be_added_title) > 0) {
                    foreach ($to_be_added_title as $jt) {
                        if (!$this->dropResumeApplicationTitle($jt, $applied_app_enc_id['applied_application_enc_id'])) {
                            return json_encode($failure);
                        }
                    }
                }

                return json_encode($success);

            } else {
                if ($app_enc_id = $this->dropResumeApplications($experience,$org_id,$is_claimed)) {
                    if (count($location) > 0) {
                        foreach ($location as $loc) {
                            if (!$this->dropResumeApplicationLocation($loc, $app_enc_id)) {
                                return json_encode($failure);
                            }
                        }
                    }
                    foreach ($job_title as $jt) {
                        if (!$this->dropResumeApplicationTitle($jt, $app_enc_id)) {
                            return json_encode($failure);
                        }
                    }

                    return json_encode($success);
                }
            }

        }
    }

    private function alreadyApplied($is_claimed,$org_id)
    {
        if ($is_claimed==1){
            $alreadyApplied = DropResumeAppliedApplications::find()
                    ->alias('a')
                    ->select(['a.applied_application_enc_id'])
                    ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                    ->andWhere(['b.organization_enc_id'=>$org_id])
                    ->innerJoin(DropResumeOrgApplication::tableName().' b','b.applied_application_enc_id = a.applied_application_enc_id')
                    ->andWhere(['status' => 0])
                    ->asArray()
                    ->one();

            return $alreadyApplied;
        }else{
            $alreadyApplied = DropResumeAppliedApplications::find()
                ->alias('a')
                ->select(['a.applied_application_enc_id'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['b.organization_enc_id'=>$org_id])
                ->innerJoin(DropResumeUnclaimOrgApplication::tableName().' b','b.applied_application_enc_id = a.applied_application_enc_id')
                ->andWhere(['status' => 0])
                ->asArray()
                ->one();

            return $alreadyApplied;
        }

    }

    private function getAlreadyAppliedTitle($applied_app_enc_id)
    {
        $titles = DropResumeAppliedTitles::find()
            ->select(['assigned_category_enc_id'])
            ->where(['applied_application_enc_id' => $applied_app_enc_id])
            ->asArray()
            ->all();

        return $titles;
    }

    private function getAlreadyAppliedLocation($applied_app_enc_id)
    {
        $location = DropResumeSelectedLocations::find()
            ->select(['city_enc_id'])
            ->where(['applied_application_enc_id' => $applied_app_enc_id])
            ->asArray()
            ->all();

        return $location;
    }

    private function dropResumeApplications($exp,$org_id,$is_claimed)
    {
        $d_r_applications = new DropResumeAppliedApplications();
        $d_r_applications->applied_application_enc_id = Yii::$app->security->generateRandomString(12);
        $d_r_applications->experience = $exp;
        $d_r_applications->created_on = date('Y-m-d H:i:s');
        $d_r_applications->created_by = Yii::$app->user->identity->user_enc_id;
        if ($d_r_applications->save()) {
            if ($is_claimed==1){
                $model = new DropResumeOrgApplication();
                $model->application_enc_id = Yii::$app->security->generateRandomString(12);
                $model->applied_application_enc_id = $d_r_applications->applied_application_enc_id;
                $model->organization_enc_id = $org_id;
                $model->created_on = date('Y-m-d H:i:s');
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$model->save()){
                    return false;
                }
            }else{
                $model = new DropResumeUnclaimOrgApplication();
                $model->application_enc_id = Yii::$app->security->generateRandomString(12);
                $model->applied_application_enc_id = $d_r_applications->applied_application_enc_id;
                $model->organization_enc_id = $org_id;
                $model->created_on = date('Y-m-d H:i:s');
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$model->save()){
                    return false;
                }
            }
            return $d_r_applications->applied_application_enc_id;
        }else{
            return false;
        }
    }

    private function dropResumeApplicationLocation($location, $applied_app_enc_id)
    {
        $d_r_a_locations = new DropResumeSelectedLocations();
        $d_r_a_locations->selected_location_enc_id = Yii::$app->security->generateRandomString(12);
        $d_r_a_locations->applied_application_enc_id = $applied_app_enc_id;
        $d_r_a_locations->city_enc_id = $location;
        $d_r_a_locations->created_on = date('Y-m-d H:i:s');
        $d_r_a_locations->created_by = Yii::$app->user->identity->user_enc_id;
        $d_r_a_locations->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if ($d_r_a_locations->save()) {
            return true;
        }
    }

    private function dropResumeApplicationTitle($job_title, $applied_app_enc_id)
    {
        $d_r_a_title = new DropResumeAppliedTitles();
        $d_r_a_title->applied_title_enc_id = Yii::$app->security->generateRandomString(12);
        $d_r_a_title->applied_application_enc_id = $applied_app_enc_id;
        $d_r_a_title->assigned_category_enc_id = $job_title;
        $d_r_a_title->created_on = date('Y-m-d H:i:s');
        $d_r_a_title->created_by = Yii::$app->user->identity->user_enc_id;
        if ($d_r_a_title->save()) {
            return true;
        }
    }

    public function actionDownload($resume)
    {
        if (!empty(Yii::$app->user->identity->organization_enc_id)) {
            $resume = UserResume::find()
                ->select(['resume_location', 'resume'])
                ->where(['resume_enc_id' => $resume])
                ->asArray()
                ->one();
            if ($resume) {

                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $cv = $my_space->signedURL(Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->resume->file . $resume['resume_location'] . DIRECTORY_SEPARATOR . $resume['resume'], "5 minutes");

                $file_name = $resume['resume'];
                $file_url = $cv;
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename=\"" . $file_name . "\"");
                echo file_get_contents($file_url);
            }

            return $this->render('download');
        }
    }

}