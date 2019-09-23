<?php

namespace api\modules\v2\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v2\models\PictureUpload;
use api\modules\v2\models\ProfilePicture;
use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\Industries;
use common\models\Skills;
use common\models\User;
use common\models\UserAccessTokens;
use common\models\UserOtherDetails;
use common\models\UserPreferences;
use common\models\UserPreferredIndustries;
use common\models\UserPreferredJobProfile;
use common\models\UserPreferredLocations;
use common\models\UserPreferredSkills;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class CandProfileController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-user-prefs' => ['POST', 'OPTIONS'],
                'get-industry' => ['POST', 'OPTIONS'],
                'get-skills' => ['POST', 'OPTIONS'],
                'get-cities' => ['POST', 'OPTIONS'],
                'save-basic-info' => ['POST', 'OPTIONS'],
                'save-applications' => ['POST', 'OPTIONS'],
                'upload-profile-picture' => ['POST', 'OPTIONS'],
                'profile-picture' => ['POST', 'OPTIONS'],
                'profiles' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['http://127.0.0.1:5500'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionGetUserPrefs()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $result = [];

            $job_prefs = $this->getPrefs($id, 'Jobs');

            $result['job_prefs'] = $job_prefs;

            $intern_prefs = $this->getPrefs($id, 'Internships');

            $result['intern_prefs'] = $intern_prefs;

            return $this->response(200, $result);
        } else {
            return $this->response(401);
        }
    }

    private function getPrefs($id, $type)
    {
        return UserPreferences::find()
            ->alias('a')
            ->where([
                'a.created_by' => $id,
                'a.assigned_to' => $type
            ])
            ->joinWith(['userPreferredJobProfiles b' => function ($x) {
                $x->onCondition(['b.is_deleted' => 0]);
                $x->joinWith(['jobProfileEnc']);
            }])
            ->joinWith(['userPreferredLocations c' => function ($x) {
                $x->onCondition(['c.is_deleted' => 0]);
                $x->joinWith(['cityEnc']);
            }])
            ->joinWith(['userPreferredIndustries d' => function ($y) {
                $y->onCondition(['d.is_deleted' => 0]);
                $y->joinWith(['industryEnc']);
            }])
            ->joinWith(['userPreferredSkills e' => function ($z) {
                $z->onCondition(['e.is_deleted' => 0]);
                $z->joinWith(['skillEnc']);
            }])
            ->asArray()
            ->one();
    }

    public function actionProfiles($type)
    {

        $profiles = Categories::find()
            ->alias('a')
            ->select(['a.name value', 'a.category_enc_id key'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => $type, 'b.status' => 'Approved'])
            ->asArray()
            ->all();

        return $this->response(200, $profiles);
    }

    public function actionGetIndustry()
    {
        $industryModel = new Industries();
        $industry = $industryModel->find()
            ->select(['industry_enc_id AS key', 'industry AS value'])
            ->orderBy(['industry' => SORT_ASC])
            ->asArray()
            ->all();
        return $this->response(200, $industry);
    }

    public function actionGetSkills()
    {
        $skills = Skills::find()
            ->select(['skill as value', 'skill_enc_id as key'])
            ->andWhere([
                'status' => 'Publish'
            ])
            ->andWhere([
                'is_deleted' => 0
            ])
            ->asArray()
            ->all();

        return $this->response(200, $skills);
    }

    public function actionGetCities($q)
    {
        $city = Cities::find()
            ->select(['name as value', 'city_enc_id as key'])
            ->where('name like "%' . $q . '%"')
            ->asArray()
            ->all();

        return $this->response(200, $city);
    }

    public function actionSaveBasicInfo()
    {
        if ($user = $this->isAuthorized()) {
            $city_enc_id = '';
            $req = Yii::$app->request->post();
            if ($req['location']) {
                $city_id = Cities::findone([
                    'name' => $req['location']
                ]);

                $city_enc_id = $city_id->city_enc_id;
            }

            if (!empty($city_enc_id)) {
                $update = Yii::$app->db->createCommand()
                    ->update(Users::tableName(), ['city_enc_id' => $city_enc_id,'last_updated_on'=>Date('Y-m-d H:i:s')], ['user_enc_id' => $user->user_enc_id])
                    ->execute();
                if ($update) {
                    return $this->response(200, ['status' => 200]);
                } else {
                    return false;
                }
            }
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveApplications()
    {
        if ($user = $this->isAuthorized()) {
            $user_id = $user->user_enc_id;

            if ($reqq = Yii::$app->request->post()) {

                foreach ($reqq as $req) {

                    if ($req['for'] == "Jobs") {
                        $user = UserPreferences::find()
                            ->where(['created_by' => $user_id])
                            ->andWhere(['assigned_to' => 'Jobs'])
                            ->one();

                        if ($user) {
                            $a = $this->updateData($req, $user_id);
//                        if ($this->updateData($req, $user_id)) {
//                            return $this->response(200);
//                        }
                        } else {
                            $b = $this->saveData($req, $user_id);
//                        if ($this->saveData($req, $user_id)) {
//                            return $this->response(200);
//                        }
                        }
                    }

                    if ($req['for'] == "Internships") {
                        $user = UserPreferences::find()
                            ->where(['created_by' => $user_id])
                            ->andWhere(['assigned_to' => 'Internships'])
                            ->one();

                        if ($user) {
                            if ($this->updateData($req, $user_id)) {
                                return $this->response(200);
                            }
                        } else {
                            if ($this->saveData($req, $user_id)) {
                                return $this->response(200);
                            }
                        }
                    }
                }
            }
        } else {
            return $this->response(401);
        }
    }

    private function saveData($r, $user_id)
    {
        $user_preference = new UserPreferences();
        $utilities = new Utilities();
        $utilities->variables['string'] = time() . rand(100, 100000);
        $user_preference->preference_enc_id = $utilities->encrypt();
        $user_preference->type = $r['type'];
        $user_preference->assigned_to = $r['for'];
        $user_preference->created_on = date('Y-m-d H:i:s');
        $user_preference->created_by = $user_id;
        if ($user_preference->save()) {
            $location = [];
            foreach ($r['locations'] as $l) {
                array_push($location, $l['key']);
            }

            foreach ($location as $loc) {
                $user_locations_model = new UserPreferredLocations();
                $user_locations_model->preference_enc_id = $user_preference->preference_enc_id;
                $utilities->variables['string'] = time() . rand(100, 100000);
                $user_locations_model->preferred_location_enc_id = $utilities->encrypt();
                $user_locations_model->city_enc_id = $loc;
                $user_locations_model->created_on = date('Y-m-d H:i:s');
                $user_locations_model->created_by = $user_id;
                if (!$user_locations_model->save()) {
                    print_r($user_locations_model->getErrors());
                }
            }

            $industry = [];
            foreach ($r['industry'] as $i) {
                array_push($industry, $i['key']);
            }

            foreach ($industry as $indus) {
                $user_industries_model = new UserPreferredIndustries();
                $user_industries_model->preference_enc_id = $user_preference->preference_enc_id;
                $utilities->variables['string'] = time() . rand(100, 100000);
                $user_industries_model->preferred_industry_enc_id = $utilities->encrypt();
                $user_industries_model->industry_enc_id = $indus;
                $user_industries_model->created_by = $user_id;
                $user_industries_model->created_on = date('Y-m-d H:i:s');
                if (!$user_industries_model->save()) {
                    print_r($user_industries_model->getErrors());
                }
            }

            $skills = [];
            foreach ($r['skills'] as $s) {
                array_push($skills, $s['value']);
            }
            foreach ($skills as $skill) {
                $this->setSkills($skill, $user_preference->preference_enc_id, $user_id);
            }

            $profile = [];
            foreach ($r['profiles'] as $p) {
                array_push($profile, $p['key']);
            }

            foreach ($profile as $p) {
                $user_jobs_profile = new UserPreferredJobProfile();
                $user_jobs_profile->preference_enc_id = $user_preference->preference_enc_id;
                $utilities->variables['string'] = time() . rand(100, 100000);
                $user_jobs_profile->preferred_job_profile_enc_id = $utilities->encrypt();
                $user_jobs_profile->job_profile_enc_id = $p;
                $user_jobs_profile->created_on = date('Y-m-d H:i:s');
                $user_jobs_profile->created_by = $user_id;
                if (!$user_jobs_profile->save()) {
                    print_r($user_jobs_profile->getErrors());
                }
            }
            return true;
        } else {
            print_r($user_preference->getErrors());
        }
    }

    private function updateData($r, $user_id)
    {
        $user_preference = UserPreferences::findOne([
            'created_by' => $user_id,
            'assigned_to' => $r['for'],
        ]);

        $user_preference->type = $r['type'];
        $user_preference->last_updated_on = date('Y-m-d H:i:s');
        $user_preference->last_updated_by = $user_id;

        if ($user_preference->update()) {

            $already_saved_location = UserPreferredLocations::find()
                ->select(['city_enc_id'])
                ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();

            $already_saved_locations = [];
            foreach ($already_saved_location as $loc) {
                array_push($already_saved_locations, $loc['city_enc_id']);
            }


            $location = [];
            foreach ($r['locations'] as $l) {
                array_push($location, $l['key']);
            }
            $new_location_to_update = $location;

            $to_be_added_location = array_diff($new_location_to_update, $already_saved_locations);
            $to_be_deleted_location = array_diff($already_saved_locations, $new_location_to_update);

            if (count($to_be_deleted_location) > 0) {
                foreach ($to_be_deleted_location as $del) {
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

            if (count($to_be_added_location) > 0) {
                foreach ($to_be_added_location as $loc) {
                    $user_locations_model = new UserPreferredLocations();
                    $utilities = new Utilities();
                    $user_locations_model->preference_enc_id = $user_preference['preference_enc_id'];
                    $utilities->variables['string'] = time() . rand(100, 100000);
                    $user_locations_model->preferred_location_enc_id = $utilities->encrypt();
                    $user_locations_model->city_enc_id = $loc;
                    $user_locations_model->created_on = date('Y-m-d H:i:s');
                    $user_locations_model->created_by = $user_id;
                    if (!$user_locations_model->save()) {
                        print_r($user_locations_model->getErrors());
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

            foreach ($already_saved_industrry as $ind) {
                array_push($already_saved_industry, $ind['industry_enc_id']);
            }

            $industry = [];
            foreach ($r['industry'] as $i) {
                array_push($industry, $i['key']);
            }
            $new_industry_to_update = $industry;

            $to_be_added_industry = array_diff($new_industry_to_update, $already_saved_industry);
            $to_be_deleted_industry = array_diff($already_saved_industry, $new_industry_to_update);

            if (count($to_be_deleted_industry) > 0) {
                foreach ($to_be_deleted_industry as $del) {
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

            if (count($to_be_added_industry) > 0) {
                foreach ($to_be_added_industry as $indus) {
                    $user_industries_model = new UserPreferredIndustries();
                    $utilities = new Utilities();
                    $user_industries_model->preference_enc_id = $user_preference['preference_enc_id'];
                    $utilities->variables['string'] = time() . rand(100, 100000);
                    $user_industries_model->preferred_industry_enc_id = $utilities->encrypt();
                    $user_industries_model->industry_enc_id = $indus;
                    $user_industries_model->created_on = date('Y-m-d H:i:s');
                    $user_industries_model->created_by = $user_id;
                    if (!$user_industries_model->save()) {
                        print_r($user_industries_model->getErrors());
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
            foreach ($user_skill as $skill_id) {
                $skill_name = Skills::find()
                    ->select(['skill'])
                    ->where(['skill_enc_id' => $skill_id['skill_enc_id']])
                    ->asArray()
                    ->one();
                array_push($s_name, $skill_name['skill']);
            }

            $skills = [];
            foreach ($r['skills'] as $s) {
                array_push($skills, $s['value']);
            }

            $new_userskill_to_update = $skills;

            $userskill = [];
            foreach ($user_skill as $skill) {
                array_push($userskill, $skill['skill_enc_id']);
            }

            $to_be_added_userskill = array_diff($new_userskill_to_update, $s_name);
            $to_be_deleted_userskill = array_diff($s_name, $new_userskill_to_update);

            if (count($to_be_deleted_userskill) > 0) {
                foreach ($to_be_deleted_userskill as $del) {
                    $this->delSkills($del, $user_preference['preference_enc_id']);
                }
            }

            if (count($to_be_added_userskill) > 0) {
                foreach ($to_be_added_userskill as $skill) {
                    $this->setSkills($skill, $user_preference['preference_enc_id'], $user_id);
                }
            }


            $user_job_profile = UserPreferredJobProfile::find()
                ->select(['job_profile_enc_id'])
                ->where(['preference_enc_id' => $user_preference['preference_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();

            $userjob = [];
            foreach ($user_job_profile as $jobp) {
                array_push($userjob, $jobp['job_profile_enc_id']);
            }

            $profile = [];
            foreach ($r['profiles'] as $p) {
                array_push($profile, $p['key']);
            }

            $to_be_added_userjob = array_diff($profile, $userjob);
            $to_be_deleted_userjob = array_diff($userjob, $profile);

            if (count($to_be_deleted_userjob) > 0) {
                foreach ($to_be_deleted_userjob as $del) {
                    $to_delete_userjob = UserPreferredJobProfile::find()
                        ->where(['job_profile_enc_id' => $del, 'preference_enc_id' => $user_preference['preference_enc_id']])
                        ->andWhere(['is_deleted' => 0])
                        ->one();
                    $to_delete_userjob->is_deleted = 1;
                    $to_delete_userjob->update();
                }
            }

            if (count($to_be_added_userjob) > 0) {
                foreach ($to_be_added_userjob as $job) {
                    $userpreferredJobsModel = new UserPreferredJobProfile();
                    $utilitiesModel = new Utilities();
                    $userpreferredJobsModel->preference_enc_id = $user_preference->preference_enc_id;
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $userpreferredJobsModel->preferred_job_profile_enc_id = $utilitiesModel->encrypt();
                    $userpreferredJobsModel->job_profile_enc_id = $job;
                    $userpreferredJobsModel->created_on = date('Y-m-d h:i:s');
                    $userpreferredJobsModel->created_by = $user_id;
                    if (!$userpreferredJobsModel->save()) {
                        print_r($userpreferredJobsModel->getErrors());
                    }
                }
            }

            return true;
        } else {
            print_r($user_preference->getErrors());
        }
    }

    public function actionUploadProfilePicture()
    {
        if ($user = $this->isAuthorized()) {
            $pictureModel = new ProfilePicture();
            $pictureModel->profile_image = UploadedFile::getInstanceByName('profile_image');
            if ($pictureModel->profile_image && $pictureModel->validate()) {
                if ($pictureModel->update()) {
                    return $this->response(200);
                }
                return $this->response(500);
            } else {
                return $this->response(409);
            }
        } else {
            return $this->response(401);
        }
    }

    private function delSkills($skill, $user_preference)
    {
        $skill_id = Skills::find()
            ->select(['skill_enc_id'])
            ->where(['skill' => $skill])
            ->asArray()
            ->one();

        $to_delete_userskill = UserPreferredSkills::find()
            ->where(['skill_enc_id' => $skill_id['skill_enc_id'], 'preference_enc_id' => $user_preference])
            ->andWhere(['is_deleted' => 0])
            ->one();
        $to_delete_userskill->is_deleted = 1;
        $to_delete_userskill->update();
    }

    private function setSkills($skills, $preference_enc_id, $user_enc_id)
    {
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
                print_r($obj->getErrors());
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
                    print_r($user_obj->getErrors());
                }
            }
        } else {
            $chkk = UserPreferredSkills::find()
                ->where(['skill_enc_id' => $chk['skill_enc_id'], 'is_deleted' => 0])
                ->andWhere(['created_by' => $user_enc_id, 'preference_enc_id' => $preference_enc_id])
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
                    print_r($user_obj->getErrors());
                }
            }
        }
    }

    public function actionProfilePicture()
    {

        if ($user = $this->isAuthorized()) {
            $candidate = Candidates::findOne([
                'user_enc_id' => $user->user_enc_id
            ]);

            if (!empty($candidate->image_location)) {
                return Url::to(Yii::$app->params->upload_directories->users->image . $candidate->image_location . DIRECTORY_SEPARATOR . $candidate->image, 'https');
            } else {
                return '';
            }
        } else {
            return $this->response(401);
        }
    }
}