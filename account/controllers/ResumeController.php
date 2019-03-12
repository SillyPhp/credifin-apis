<?php

namespace account\controllers;
use common\models\DropResumeApplicationLocations;
use common\models\DropResumeApplications;
use common\models\DropResumeApplicationTitiles;
use common\models\DropResumeApplicationTitles;
use common\models\OrganizationAssignedCategories;
use common\models\OrganizationLocations;
use frontend\controllers\DropResumeController;
use http\Env\Response;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Categories;
use common\models\AssignedCategories;

class ResumeController extends Controller {


    public function actionFirst(){

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $category_enc_id = Yii::$app->request->post('parent_id');
            $type = Yii::$app->request->post('type');

            $second_modal_categories = AssignedCategories::find()
                ->alias('a')
                ->select(['b.name', 'b.category_enc_id'])
                ->innerJoin(Categories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->where(['a.assigned_to' => $type, 'a.parent_enc_id' => $category_enc_id])
                ->asArray()
                ->all();

            $already_selected_categories = $this->savedData($category_enc_id,$type);

            $response = [];
            $response["parent_enc_id"] = $category_enc_id;
            $response["already_selected_categories"]=$already_selected_categories;
            $response["second_modal_categories"] = $second_modal_categories;


            return json_encode($response);
        }
    }

    private function checkParent($parent_id,$type){
        $check_parent = OrganizationAssignedCategories::find()
            ->where(['category_enc_id'=>$parent_id])
            ->andWhere(['parent_enc_id'=> NULL])
            ->andWhere(['assigned_to'=>$type])
            ->andWhere(['organization_enc_id'=>Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['is_deleted'=>0])
            ->exists();

        return $check_parent;
    }


    public function actionSave(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $second_category_enc_id = Yii::$app->request->post('checked');
            $parent_enc_id = Yii::$app->request->post('parent_enc_id');
            $type = Yii::$app->request->post('type');

            $selected_values = [];

            $already_selected = $this->savedData($parent_enc_id,$type);
            foreach($already_selected as $a){
                array_push($selected_values, $a["category_enc_id"]);
            }

            $to_be_added = array_diff($second_category_enc_id, $selected_values);
            $to_be_deleted = array_diff($selected_values, $second_category_enc_id);

            if(!$this->checkParent($parent_enc_id, $type)) {
                $this->saveFirstCategory($parent_enc_id, $type);
            }

            $num = count($to_be_added);
            if($num > 0) {
                foreach ($to_be_added as $add) {
                    $this->saveSecondCategory($add, $parent_enc_id, $type);
                }
            }

            $num = count($to_be_deleted);
            if($num > 0) {
                foreach ($to_be_deleted as $del) {
                    $this->deleteData($del, $parent_enc_id, $type);
                }
            }

            $response =  [

                'status' => 200
            ];

            return json_encode($response);
        }
    }

    private function deleteData($second_enc_id, $parent_enc_id, $type){
        $toBeDeleted = OrganizationAssignedCategories::find()
            ->where(['parent_enc_id' => $parent_enc_id])
            ->andWhere(['category_enc_id' => $second_enc_id])
            ->andWhere(['organization_enc_id'=>Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['assigned_to' => $type])
            ->one();
        $toBeDeleted->is_deleted = 1;
        $toBeDeleted->update();

    }

    private function savedData($category_enc_id,$type){
        $already_selected = OrganizationAssignedCategories::find()
            ->select(['category_enc_id'])
            ->where(['created_by'=> Yii::$app->user->identity->user_enc_id, 'organization_enc_id'=> Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['parent_enc_id'=> $category_enc_id])
            ->andWhere(['assigned_to'=>$type])
            ->andWhere(['is_deleted'=>0])
            ->asArray()
            ->all();
        return $already_selected;
    }

    private function saveFirstCategory($category_enc_id, $type){
        $organization_a_c = new OrganizationAssignedCategories();
        $organization_a_c->assigned_category_enc_id = Yii::$app->security->generateRandomString(12);
        $organization_a_c->category_enc_id = $category_enc_id;
        $organization_a_c->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
        $organization_a_c->assigned_to = $type;
        $organization_a_c->created_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->save();
    }

    private function saveSecondCategory($c_enc_id,$p_enc_id, $type){
        $organization_a_c = new OrganizationAssignedCategories();
        $organization_a_c->assigned_category_enc_id = Yii::$app->security->generateRandomString(12);
        $organization_a_c->category_enc_id = $c_enc_id;
        $organization_a_c->parent_enc_id = $p_enc_id;
        $organization_a_c->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
        $organization_a_c->assigned_to = $type;
        $organization_a_c->created_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->save();
    }

    public function actionFinalData(){
        $type = Yii::$app->request->post('type');
        $selectedfields = OrganizationAssignedCategories::find()
            ->alias('a')
            ->select(['a.assigned_category_enc_id'])
//            ->joinWith(['categoryEnc b'], false)
            ->where(['a.assigned_to' => $type])
            ->andWhere(['a.organization_enc_id' => Yii::$app->user->identity->organization_enc_id,'a.created_by'=>Yii::$app->user->identity->user_enc_id])
            ->andWhere(['not', ['a.parent_enc_id' => NULL]])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->all();
        $i = 0;
        foreach ($selectedfields as $s){
            $unique_id = OrganizationAssignedCategories::findOne([
                    'assigned_category_enc_id' => $s['assigned_category_enc_id'],
                ]);

            if(!empty($unique_id->parent_enc_id)) {
                $parent_name = Categories::find()
                    ->select('name')
                    ->where(['category_enc_id' => $unique_id->parent_enc_id])
                    ->asArray()
                    ->one();
            }
            $child_name = Categories::find()
                ->select('name')
                ->where(['category_enc_id' => $unique_id->category_enc_id])
                ->asArray()
                ->one();

            $selectedfields[$i]['parent_name'] = $parent_name["name"];
            $selectedfields[$i]['child_name'] = $child_name["name"];
            $i++;
        }
        return json_encode($selectedfields);
    }

    public function actionResumeType()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $selected_answer = Yii::$app->request->post('selected_answer');
            $company_name = Yii::$app->request->post('company_name');

            $data = OrganizationAssignedCategories::find()
                ->alias('a')
                ->select(['a.category_enc_id','c.name','a.assigned_category_enc_id'])
                ->joinWith(['organizationEnc b'],false)
                ->joinWith(['categoryEnc c'],false)
                ->where(['b.slug'=>$company_name])
                ->andWhere(['a.assigned_to'=>$selected_answer])
                ->andWhere(['a.parent_enc_id'=>NULL])
                ->andWhere(['a.is_deleted'=>0])
                ->asArray()
                ->all();
            return json_encode($data);
        }
    }

    public function actionJobProfile(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $selected_answer = Yii::$app->request->post('selected_answer');
            $type = Yii::$app->request->post('type');
            $company_name = Yii::$app->request->post('company_name');
            $assigned_categories = OrganizationAssignedCategories::find()
                ->alias('a')
                ->select(['a.assigned_category_enc_id','c.name'])
                ->joinWith(['organizationEnc b'],false)
                ->where(['b.slug'=>$company_name])
                ->joinWith(['categoryEnc c'],false)
                ->andWhere(['a.assigned_to'=>$type])
                ->andWhere(['a.parent_enc_id'=>$selected_answer])
                ->andWhere(['a.is_deleted'=>0])
                ->asArray()
                ->all();
            $location = OrganizationLocations::find()
                        ->alias('a')
                ->select(['c.name','c.city_enc_id'])
                ->joinWith(['organizationEnc b'],false)
                ->joinWith(['cityEnc c'])
                ->where(['b.slug'=>$company_name])
                ->andWhere(['a.is_deleted'=>0])
                ->asArray()
                ->all();
            $username = Yii::$app->user->identity->username;
            $data = [];
            $data['sub_categories'] = $assigned_categories;
            $data['location'] = $location;
            $data['username'] = $username;

            return json_encode($data);
        }
    }

    public function actionCandidateApplication(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $experience = $data['experience'];
            $job_title = $data['job_title'];
            $location = $data['locations'];

            switch ($experience){

                case 'no':
                   $exp = 0;
                   break;

                case 'less than one':
                    $exp = 1;
                    break;

                case 'one':
                    $exp = 2;
                    break;

                case 'two to three':
                    $exp = 3;
                    break;

                case 'three to five':
                    $exp = 4;
                    break;

                case 'five to ten':
                    $exp = 5;
                    break;

                case 'ten to twenty':
                    $exp = 6;
                    break;

                case 'twenty above':
                    $exp = 7;
                    break;
            };



            if($app_enc_id = $this->dropResumeApplications($exp)){

                $failure = [
                    'message' => 201
                ];

                $success = [
                    'message' => 200
                ];

                if(count($location) > 0) {
                    foreach ($location as $loc) {
                        if (!$this->dropResumeApplicationLocation($loc, $app_enc_id)) {
                            return json_encode($failure);
                        }
                    }
                }
                foreach ($job_title as $jt) {
                    if(!$this->dropResumeApplicationTitle($jt, $app_enc_id)){
                        return json_encode($failure);
                    }
                }

                return json_encode($success);
            }

        }
    }

    private function dropResumeApplications($exp){
        $d_r_applications = new DropResumeApplications();
        $d_r_applications->applied_application_enc_id = Yii::$app->security->generateRandomString(12);
        $d_r_applications->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $d_r_applications->experience = $exp;
        $d_r_applications->created_by = Yii::$app->user->identity->user_enc_id;
        $d_r_applications->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if($d_r_applications->save()){
            return $d_r_applications->applied_application_enc_id;
        }
    }

    private function dropResumeApplicationLocation($location,$applied_app_enc_id){
        $d_r_a_locations = new DropResumeApplicationLocations();
        $d_r_a_locations->applied_location_enc_id = Yii::$app->security->generateRandomString(12);
        $d_r_a_locations->applied_application_enc_id = $applied_app_enc_id;
        $d_r_a_locations->city_enc_id = $location;
        $d_r_a_locations->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $d_r_a_locations->created_by = Yii::$app->user->identity->user_enc_id;
        $d_r_a_locations->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if($d_r_a_locations->save()){
            return true;
        }
    }

    private function dropResumeApplicationTitle($job_title,$applied_app_enc_id){
        $d_r_a_title = new DropResumeApplicationTitles();
        $d_r_a_title->applied_title_enc_id = Yii::$app->security->generateRandomString(12);
        $d_r_a_title->applied_application_enc_id = $applied_app_enc_id;
        $d_r_a_title->title = $job_title;
        $d_r_a_title->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $d_r_a_title->created_by = Yii::$app->user->identity->user_enc_id;
        $d_r_a_title->last_updated_by = Yii::$app->user->identity->user_enc_id;

        if($d_r_a_title->save()){
            return true;
        }
    }

    public function actionCheckResume(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $company_name = Yii::$app->request->post('company_name');

            $cv_exists = OrganizationAssignedCategories::find()
                        ->alias('a')
                        ->select(['a.assigned_category_enc_id'])
                        ->joinWith(['organizationEnc b'], false)
                        ->where(['b.slug' => $company_name])
                        ->exists();

            if($cv_exists){
                return 'yes';
            }else{
                return 'no';
            }

        }
    }
}