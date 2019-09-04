<?php

namespace api\modules\v2\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v2\models\PictureUpload;
use api\modules\v2\models\ProfilePicture;
use common\models\Skills;
use common\models\User;
use common\models\UserAccessTokens;
use common\models\UserOtherDetails;
use common\models\UserPreferences;
use common\models\UserPreferredIndustries;
use common\models\UserPreferredJobProfile;
use common\models\UserPreferredLocations;
use common\models\UserPreferredSkills;
use Yii;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;

class CandProfileController extends ApiBaseController{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'get-user-prefs',
                'get-industry',
                'get-skills',
                'save-basic-info',
                'save-applications',
                'upload-profile-picture',
                'profile-picture'
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'get-user-prefs' => ['POST','OPTIONS'],
                'get-industry' => ['GET'],
                'get-skills' => ['GET'],
                'save-basic-info' => ['POST'],
                'save-applications' => ['POST'],
                'upload-profile-picture' => ['POST','OPTIONS'],
                'profile-picture' => ['POST','OPTIONS']
            ]
        ];
        return $behaviors;
    }

    public function actionGetUserPrefs(){

        if( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )
        {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);

        $id = $token_holder_id->user_enc_id;

        $result = [];

        $job_prefs = $this->getPrefs($id, 'Jobs');

        $result['job_prefs'] = $job_prefs;

        $intern_prefs = $this->getPrefs($id, 'Internships');

        $result['intern_prefs'] = $intern_prefs;

        return $this->response(200, $result);
    }

    private function getPrefs($id, $type){
        return UserPreferences::find()
            ->alias('a')
            ->where([
                'a.created_by' => $id,
                'a.assigned_to' => $type
            ])
            ->joinWith(['userPreferredJobProfiles b' => function($x){
                $x->onCondition(['b.is_deleted' => 0]);
            }])
            ->joinWith(['userPreferredLocations c' => function($x){
                $x->onCondition(['c.is_deleted' => 0]);
                $x->joinWith(['cityEnc']);
            }])
            ->joinWith(['userPreferredIndustries d' => function($y){
                $y->onCondition(['d.is_deleted' => 0]);
                $y->joinWith(['industryEnc']);
            }])
            ->joinWith(['userPreferredSkills e'=> function($z){
                $z->onCondition(['e.is_deleted' => 0]);
                $z->joinWith(['skillEnc']);
            }])
            ->asArray()
            ->one();
    }

    public function actionGetIndustry($q = null)
    {
            $industryModel = new Industries();
            $industry = $industryModel->find()
                ->select(['industry_enc_id AS id', 'industry AS text'])
                ->where('industry LIKE "%' . $q . '%"')
                ->orderBy(['industry' => SORT_ASC])
                ->asArray()
                ->all();
            return $industry;
    }

    public function actionGetSkills($q){
        return Skills::find()
            ->select(['skill as value', 'skill_enc_id as id'])
            ->where('skill like "%' . $q . '%"')
            ->andWhere([
                'status' => 'Publish'
            ])
            ->andWhere([
                'is_deleted' => 0
            ])
            ->asArray()
            ->limit(20)
            ->all();
    }

    public function actionSaveBasicInfo(){
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $req = Yii::$app->request->post();
        $candidate->first_name = $req['firstName'];
        $candidate->last_name = $req['lastName'];
        $candidate->phone = $req['phone'];
        $candidate->email = $req['email'];
        if($candidate->update()){
            $candidate_options = UserOtherDetails::findOne([
                'user_enc_id' => $token_holder_id->user_enc_id
            ]);
            if($candidate_options){
                $candidate_options->organization_enc_id = $req['organization_enc_id'];
                $candidate_options->update();
            }else{
                return $this->response(404);
            }

        }

    }

    public function actionSaveApplications(){
        if($req = Yii::$app->request->post()){
            $user_id = $req['user_id'];

            if($req['type'] == "Jobs") {
                $user = UserPreferences::find()
                    ->where(['created_by' => $user_id])
                    ->andWhere(['assigned_to' => 'Jobs'])
                    ->one();

                if ($user) {
                    if ($this->updateData($req)) {
                        return $this->response(200);
                    }
                } else {
                    if ($this->saveData($req)) {
                        return $this->response(200);
                    }
                }
            }

            if($req['type'] == "Internships"){
                $user = UserPreferences::find()
                    ->where(['created_by' => $user_id])
                    ->andWhere(['assigned_to' => 'Internships'])
                    ->one();

                if ($user) {
                    if ($this->updateData($req)) {
                        return $this->response(200);
                    }
                } else {
                    if ($this->saveData($req)) {
                        return $this->response(200);
                    }
                }
            }
        }
    }

    private function saveData($r){
        $user_preference = new UserPreferences();
        $utilities = new Utilities();
        $utilities->variables['string'] = time() . rand(100,100000);
        $user_preference->preference_enc_id = $utilities->encrypt();
        $user_preference->type = $r['type'];
        $user_preference->assigned_to = $r['for'];
        $user_preference->created_on = date('Y-m-d H:i:s');
        $user_preference->created_by = $r['user_enc_id'];
        if($user_preference->save()){
            foreach(explode(',', $r['locations']) as $loc){
                $user_locations_model = new UserPreferredLocations();
                $user_locations_model->preference_enc_id =  $user_preference->preference_enc_id;
                $utilities->variables['string'] = time() . rand(100, 100000);
                $user_locations_model->city_enc_id = $loc;
                $user_locations_model->created_on = date('Y-m-d H:i:s');
                $user_locations_model->created_by = $r['user_enc_id'];
                if(!$user_locations_model->save()){
                    return false;
                }
            }

            foreach(explode(',', $r['industry']) as $indus){
                $user_industries_model = new UserPreferredIndustries();
                $user_industries_model->preference_enc_id = $user_preference->preference_enc_id;
                $utilities->variables['string'] = time() . rand(100, 100000);
                $user_industries_model->preferred_industry_enc_id = $utilities->encrypt();
                $user_industries_model->industry_enc_id = $indus;
                $user_industries_model->created_by = $r['user_enc_id'];
                $user_industries_model->created_on = date('Y-m-d H:i:s');
                if(!$user_industries_model->save()){
                    return false;
                }
            }
            foreach($r['skills'] as $skill){
                $this->setSkill($skill, $user_preference->preference_enc_id);
            }

            foreach($r['job_profile'] as $p){
                $user_jobs_profile = new UserPreferredJobProfile();
                $user_jobs_profile->preference_enc_id = $user_preference->preference_enc_id;
                $utilities->variables['string'] = time() . rand(100, 100000);
                $user_jobs_profile->preferred_job_profile_enc_id = $utilities->encrypt();
                $user_jobs_profile->job_profile_enc_id = $p;
                $user_jobs_profile->created_on = date('Y-m-d H:i:s');
                $user_jobs_profile->created_by = $r['user_enc_id'];
                if(!$user_jobs_profile->save()){
                    return false;
                }
            }
            return true;
        }else{
            return false;
        }
    }

    private function updateData($r){
        $user_preference = UserPreferences::findOne([
            'created_by' => $r['user_enc_id'],
            'assigned_to' => 'Jobs'
        ]);

        $user_preference->type = $r['type'];
        $user_preference->last_updated_on = date('Y-m-d H:i:s');
        $user_preference->last_updated_by = $r['user_enc_id'];

        if($user_preference->update()){

                $already_saved_location = UserPreferredLocations::find()
                    ->select(['city_enc_id'])
                    ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();

                $already_saved_locations = [];
                foreach($already_saved_location as $loc){
                    array_push($already_saved_locations, $loc['city_enc_id']);
                }

                $new_location_to_update = explode(',',$r['location']);

                $to_be_added_location = array_diff($new_location_to_update, $already_saved_locations);
                $to_be_deleted_location = array_diff($already_saved_locations, $new_location_to_update);

                if(count($to_be_deleted_location) > 0){
                    foreach($to_be_deleted_location as $del){
                        $to_delete = UserPreferredLocations::find()
                            ->where([
                                'city_enc_id' => $del,
                                'preference_enc_id' => $user_preference['preference_enc_id']
                            ])
                            ->andWhere(['is_deleted' => 0])
                            ->one();
                        $to_delete->is_deleted = 1;
                        $to_delete->update();

                    }
                }

                if(count($to_be_added_location) > 0){
                    foreach($to_be_added_location as $loc){
                        $user_locations_model = new UserPreferredLocations();
                        $utilities = new Utilities();
                        $user_locations_model->preference_enc_id = $user_preference['preference_enc_id'];
                        $utilities->variables['string'] = time() . rand(100, 100000);
                        $user_locations_model->preferred_location_enc_id = $utilities->encrypt();
                        $user_locations_model->city_enc_id = $loc;
                        $user_locations_model->created_on = date('Y-m-d H:i:s');
                        $user_locations_model->created_by = $r['user_enc_id'];
                        if(!$user_locations_model->save()){
                            return false;
                        }
                    }
                }

                $already_saved_industrry = UserPreferredIndustries::find()
                    ->select(['industry_enc_id'])
                    ->where([
                        'preference_enc_id' => $user_preference['preference_enc_id']
                    ])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();

                $already_saved_industry = [];

                foreach($already_saved_industrry as $ind){
                    array_push($already_saved_industry, $ind['industry_enc_id']);
                }

                $new_industry_to_update = explode(',', $r['industry']);

                $to_be_added_industry = array_diff($new_industry_to_update, $already_saved_industry);
                $to_be_deleted_industry = array_diff($already_saved_industry, $new_industry_to_update);

                if(count($to_be_deleted_industry) > 0){
                    foreach($to_be_deleted_industry as $del){
                        $to_delete_indus = UserPreferredIndustries::find()
                            ->where([
                                'industry_enc_id' => $del,
                                'preference_enc_id' => $user_preference['preference_enc_id']
                            ])
                            ->andWhere(['is_deleted' => 0])
                            ->one();

                        $to_delete_indus->is_deleted = 1;
                        $to_delete_indus->update();
                    }
                }

                if(count($to_be_added_industry) > 0){
                    foreach($to_be_added_industry as $indus){
                        $user_industries_model = new UserPreferredIndustries();
                        $utilities = new Utilities();
                        $user_industries_model->preference_enc_id = $user_preference['preference_enc_id'];
                        $utilities->variables['string'] = time() . rand(100, 100000);
                        $user_industries_model->preferred_industry_enc_id = $utilities->encrypt();
                        $user_industries_model->industry_enc_id = $indus;
                        $user_industries_model->created_on = date('Y-m-d H:i:s');
                        $user_industries_model->created_by = $r['user_enc_id'];
                        if(!$user_industries_model->save()){
                            return false;
                        }
                    }
                }

                $user_skill = UserPreferredSkills::find()
                    ->select(['skill_enc_id'])
                    ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();

                $s_name = [];
                foreach ($user_skill as $skill_id){
                    $skill_name = Skills::find()
                        ->select(['skill'])
                        ->where(['skill_enc_id'=>$skill_id])
                        ->asArray()
                        ->one();
                    array_push($s_name,$skill_name['skill']);
                }

                $new_userskill_to_update = $r['skills'];

                $userskill = [];
                foreach($user_skill as $skill){
                    array_push($userskill, $skill['skill_enc_id']);
                }

                $to_be_added_userskill = array_diff($new_userskill_to_update, $s_name);
                $to_be_deleted_userskill = array_diff($s_name, $new_userskill_to_update);

                if(count($to_be_deleted_userskill) > 0){
                    foreach($to_be_deleted_userskill as $del){
                        $this->delSkills($del, $user_preference['preference_enc_id']);
                    }
                }

                if(count($to_be_added_userskill) > 0){
                    foreach($to_be_added_userskill as $skill){
                        $this->setSkills($skill, $user_preference['preference_enc_id'], $r['user_enc_id']);
                    }
                }

                $user_job_profile = UserPreferredJobProfile::find()
                    ->select(['job_profile_enc_id'])
                    ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();

                $userjob = [];
                foreach($user_job_profile as $jobp){
                    array_push($userjob, $jobp['job_profile_enc_id']);
                }

                $to_be_added_userjob = array_diff($r['job_categories'], $userjob);
                $to_be_deleted_userjob = array_diff($userjob, $r['job_categories']);

                if(count($to_be_deleted_userjob) > 0){
                    foreach($to_be_deleted_userjob as $del){
                        $to_delete_userjob = UserPreferredJobProfile::find()
                            ->where(['job_profile_enc_id' => $del, 'preference_enc_id' => $user_preference['preference_enc_id']])
                            ->andWhere(['is_deleted' => 0])
                            ->one();
                        $to_delete_userjob->is_deleted = 1;
                        $to_delete_userjob->update();
                    }
                }

                if(count($to_be_added_userjob) > 0){
                    foreach($to_be_added_userjob as $job){
                        $userpreferredJobsModel = new UserPreferredJobProfile();
                        $utilitiesModel = new Utilities();
                        $userpreferredJobsModel->preference_enc_id = $user_preference->preference_enc_id;
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $userpreferredJobsModel->preferred_job_profile_enc_id = $utilitiesModel->encrypt();
                        $userpreferredJobsModel->job_profile_enc_id = $job;
                        $userpreferredJobsModel->created_on = date('Y-m-d h:i:s');
                        $userpreferredJobsModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if(!$userpreferredJobsModel->save()){
                            return false;
                        }
                    }
                }

                return true;
        }else{
            return false;
        }
    }

    public function actionUploadProfilePicture(){
        if( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )
        {
            header("HTTP/1.1 202 Accepted");
            exit;
        }
        $pictureModel = new ProfilePicture();
        $pictureModel->profile_image = UploadedFile::getInstanceByName('profile_image');
        if($pictureModel->profile_image && $pictureModel->validate()){
            if($pictureModel->update()){
                return $this->response(200);
            }
            return $this->response(500);
        }else{
            return $this->response(409);
        }
    }

    private function delSkills($skill,$user_preference){
        $skill_id = Skills::find()
            ->select(['skill_enc_id'])
            ->where(['skill'=>$skill])
            ->asArray()
            ->one();

        $to_delete_userskill = UserPreferredSkills::find()
            ->where(['skill_enc_id' => $skill_id['skill_enc_id'], 'preference_enc_id' => $user_preference])
            ->andWhere(['is_deleted' => 0])
            ->one();
        $to_delete_userskill->is_deleted = 1;
        $to_delete_userskill->update();
    }

    private function setSkills($skills,$preference_enc_id, $user_enc_id){
        $obj = new Skills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $chk = Skills::find()
            ->where(['skill' => $skills])
            ->asArray()
            ->one();
        if (empty($chk)) {
            $obj->skill_enc_id = $utilitiesModel->encrypt();
            $obj->skill = $skills;
            $obj->created_on = date('Y-m-d h:i:s');
            $obj->created_by = $user_enc_id;
            if (!$obj->save()) {
                return false;
            } else {
                $user_obj = new UserPreferredSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->preferred_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $obj->skill_enc_id;
                $user_obj->preference_enc_id = $preference_enc_id;
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = $user_enc_id;
                if (!$user_obj->save()) {
                    return false;
                }
            }
        } else {
            $chkk = UserPreferredSkills::find()
                ->where(['skill_enc_id' => $chk['skill_enc_id'],'is_deleted'=>0])
                ->andWhere(['created_by' => $user_enc_id,'preference_enc_id'=>$preference_enc_id])
                ->asArray()
                ->one();
            if (!$chkk) {
                $user_obj = new UserPreferredSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->preferred_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $chk['skill_enc_id'];
                $user_obj->preference_enc_id = $preference_enc_id;
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = $user_enc_id;
                if (!$user_obj->save()) {
                    return false;
                }
            }
        }
    }

    public function actionProfilePicture()
    {

        if( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )
        {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        if(!empty($candidate->image_location)){
            return Url::to(Yii::$app->params->upload_directories->users->image . $candidate->image_location . DIRECTORY_SEPARATOR . $candidate->image, 'https');
        }else {
            return '';
        }
    }
}