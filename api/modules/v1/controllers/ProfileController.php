<?php

namespace api\modules\v1\controllers;

use api\modules\v1\controllers\ApiBaseController;
use api\modules\v1\models\Candidates;
use common\models\AppliedApplications;
use common\models\Categories;
use common\models\Cities;
use common\models\Skills;
use common\models\SpokenLanguages;
use common\models\States;
use common\models\User;
use common\models\UserAccessTokens;
use common\models\UserSpokenLanguages;
use yii\filters\auth\HttpBearerAuth;
use common\models\Utilities;
use common\models\Users;
use common\models\UserSkills;
use api\modules\v1\models\CandidateProfile;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;

class ProfileController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'detail' => ['POST'],
                'update-profile' => ['POST'],
                'update-skills' => ['POST'],
                'update-description' => ['POST'],
                'update-languages' => ['POST'],
                'update-social' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionDetail()
    {
        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        $basicDetails = new CandidateProfile();

        $result = [];

        $result['first_name'] = $candidate->first_name;
        $result['last_name'] = $candidate->last_name;
        $result['username'] = $candidate->username;
        $result['color'] = $candidate->initials_color;

        if (!($basicDetails->getJobFunction() == "")) {
            $result['title'] = $basicDetails->getJobFunction()["title"];
        } else {
            $result['title'] = NULL;
        }
        if (!($basicDetails->getProfilePicture() == "")) {
            $result['profile_picture'] = $basicDetails->getProfilePicture();
        } else {
            $result['profile_picture'] = NULL;
        }

        if (!($basicDetails->getCurrentCity() == "")) {
            $result['current_city'] = $basicDetails->getCurrentCity()["city_name"] .','. $basicDetails->getCurrentCity()['city_enc_id'];
            $result['current_state'] = $basicDetails->getCurrentCity()["state_name"].','. $basicDetails->getCurrentCity()['state_enc_id'];
        } else {
            $result['current_city'] = NULL;
            $result['current_state'] = NULL;
        }

        if (!($basicDetails->getJobFunction() == "")) {
            $result['profile'] = $basicDetails->getJobFunction()['profile'].','.$basicDetails->getJobFunction()['category_enc_id'];
        } else {
            $result['profile'] = NULL;
        }

        $result['dob'] = date('d-M-Y', strtotime($candidate->dob));
        $result['description'] = $candidate->description;

        $result['facebook'] = $candidate->facebook;
        $result['twitter'] = $candidate->twitter;
        $result['linkedin'] = $candidate->linkedin;
        $result['google'] = $candidate->google;

        if ($candidate->is_available) {
            $result['availability'] = $candidate->is_available;
        } else {
            $result['availability'] = 5;

        }

        if ($candidate->gender) {
            $result['gender'] = $candidate->gender;
        } else {
            $result['gender'] = 5;
        }

        $result['experience_years'] = $basicDetails->getExperience()[0];
        $result['experience_months'] = $basicDetails->getExperience()[1];

        $result['user_skills'] = $basicDetails->getUserSkills();
        $result['user_languages'] = $basicDetails->getUserLanguages();

        return $this->response(200, $result);
    }

    public function actionUpdateProfile()
    {
        $basicDetails = new CandidateProfile();
        $req = Yii::$app->request->post();
        if (isset($req['exp_month']) && isset($req['gender']) && isset($req['exp_year']) && isset($req['dob']) && isset($req['availability']) && isset($req['state']) && isset($req['city'])) {
            if ($basicDetails->load(Yii::$app->request->post())) {
                if ($basicDetails->validate()) {
                    if ($basicDetails->update()) {
                        return $this->response(202, 'Successfully Updated');
                    }
                    return $this->response(200, 'Already Updated');
                } else {
                    return $this->response(409, $basicDetails->getErrors());
                }
            } else {
                return $this->response(422);
            }
        } else {
            return $this->response(422);
        }
    }

    public function actionUpdateDescription()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $req = Yii::$app->request->post();

        if (isset($req['description'])) {

            $update = Yii::$app->db->createCommand()
                ->update(Users::tableName(), ['description' => $req['description'], 'last_updated_on' => date('Y-m-d H:i:s')], ['user_enc_id' => $token_holder_id->user_enc_id])
                ->execute();

            if ($update) {
                return $this->response(200, 'updated');
            } else {
                return $this->response(500, 'error occured while updating description');
            }

        } else {
            return $this->response(422);
        }
    }

    public function actionUpdateSkills()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $req = Yii::$app->request->post();

        if (isset($req['skills'])) {

            $skills = $req['skills'];
            if ($skills != '') {
                $skills_array = explode(",", $skills);
                foreach ($skills_array as $s) {
                    trim($s);
                }
                $skills_array = array_unique($skills_array);
            } else {
                $skills_array = [];
            }

            if (!empty($skills_array)) {
                $skill_set = [];
                foreach ($skills_array as $val) {
                    $chk_skill = Skills::find()
                        ->distinct()
                        ->select(['skill_enc_id'])
                        ->where(['skill' => $val])
                        ->asArray()
                        ->one();
                    if (!empty($chk_skill)) {
                        $skill_set[] = $chk_skill['skill_enc_id'];
                    } else {
                        $skillsModel = new Skills();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                        $skillsModel->skill = $val;
                        $skillsModel->created_on = date('Y-m-d H:i:s');
                        $skillsModel->created_by = $token_holder_id->user_enc_id;
                        if (!$skillsModel->save()) {
                            return $this->response(500, 'an error occured while saving skills');
                        }
                        $skill_set[] = $skillsModel->skill_enc_id;
                    }
                }
            } else {
                $skill_set = [];
            }
            $userSkills = UserSkills::find()
                ->where(['created_by' => $token_holder_id->user_enc_id])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();
            $skillArray = ArrayHelper::getColumn($userSkills, 'skill_enc_id');
            $new_skill = array_diff($skill_set, $skillArray);
            $delete_skill = array_diff($skillArray, $skill_set);
            if (!empty($new_skill)) {
                foreach ($new_skill as $val) {
                    $skillsModel = new UserSkills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsModel->user_skill_enc_id = $utilitiesModel->encrypt();
                    $skillsModel->skill_enc_id = $val;
                    $skillsModel->created_on = date('Y-m-d H:i:s');
                    $skillsModel->created_by = $token_holder_id->user_enc_id;
                    if (!$skillsModel->save()) {
                        return $this->response(500, 'an error occured add new');
                    }
                }
            }
            if (!empty($delete_skill)) {
                foreach ($delete_skill as $val) {
                    $update = Yii::$app->db->createCommand()
                        ->update(UserSkills::tableName(), [
                            'is_deleted' => 1,
                            'last_updated_on' => date('Y-m-d H:i:s'),
                            'last_updated_by' => $token_holder_id->user_enc_id
                        ], [
                            'created_by' => $token_holder_id->user_enc_id,
                            'skill_enc_id' => $val
                        ])
                        ->execute();
                    if (!$update) {
                        return $this->response(500, 'an error occured delete');
                    }
                }
            }
            return $this->response(200, 'skills added');
        } else {
            return $this->response(422);
        }
    }

    public function actionUpdateLanguages()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $req = Yii::$app->request->post();

        if (isset($req['languages'])) {

            $lang = $req['languages'];
            if ($lang != '') {
                $languages_array = explode(",", $lang);
                foreach ($languages_array as $t) {
                    trim($t);
                }
                $languages_array = array_unique($languages_array);
            } else {
                $languages_array = [];
            }

            if (!empty($languages_array)) {
                $language_set = [];
                foreach ($languages_array as $val) {
                    $chk_language = SpokenLanguages::find()
                        ->distinct()
                        ->select(['language_enc_id'])
                        ->where(['language' => $val])
                        ->asArray()
                        ->one();
                    if (!empty($chk_language)) {
                        $language_set[] = $chk_language['language_enc_id'];
                    } else {
                        $languageModel = new SpokenLanguages();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $languageModel->language_enc_id = $utilitiesModel->encrypt();
                        $languageModel->language = $val;
                        $languageModel->created_on = date('Y-m-d H:i:s');
                        $languageModel->created_by = $token_holder_id->user_enc_id;
                        if (!$languageModel->save()) {
                            return $this->response(500, 'an error occured');
                        }
                        $language_set[] = $languageModel->language_enc_id;
                    }
                }
            } else {
                $language_set = [];
            }
            $userLanguage = UserSpokenLanguages::find()
                ->where(['created_by' => $token_holder_id->user_enc_id])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();
            $languageArray = ArrayHelper::getColumn($userLanguage, 'language_enc_id');
            $new_language = array_diff($language_set, $languageArray);
            $delete_language = array_diff($languageArray, $language_set);
            if (!empty($new_language)) {
                foreach ($new_language as $val) {
                    $languageModel = new UserSpokenLanguages();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $languageModel->user_language_enc_id = $utilitiesModel->encrypt();
                    $languageModel->language_enc_id = $val;
                    $languageModel->created_on = date('Y-m-d H:i:s');
                    $languageModel->created_by = $token_holder_id->user_enc_id;
                    if (!$languageModel->save()) {
                        return $this->response(500, 'an error occured');
                    }
                }
            }
            if (!empty($delete_language)) {
                foreach ($delete_language as $val) {
                    $update = Yii::$app->db->createCommand()
                        ->update(UserSpokenLanguages::tableName(), [
                            'is_deleted' => 1,
                            'last_updated_on' => date('Y-m-d H:i:s'),
                            'last_updated_by' => $token_holder_id->user_enc_id
                        ], [
                            'created_by' => $token_holder_id->user_enc_id,
                            'language_enc_id' => $val
                        ])
                        ->execute();
                    if (!$update) {
                        return $this->response(500, 'an error occured');
                    }
                }
            }
                return $this->response(200, 'languages added');
        } else {
            return $this->response(422);
        }
    }

    public function actionUpdateSocial()
    {
        $socialDetails = new CandidateProfile();
        if ($socialDetails->load(Yii::$app->request->post())) {
            if ($socialDetails->updateValues()) {
                return $this->response(200, 'Successfully Updated');
            }
            return $this->response(200, 'Already Updated');
        } else {
            return $this->response(422);
        }
    }
}
