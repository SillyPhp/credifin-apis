<?php

namespace api\modules\v1\controllers;

use api\modules\v1\controllers\ApiBaseController;
use api\modules\v1\models\Candidates;
use common\models\Categories;
use common\models\Cities;
use common\models\States;
use common\models\UserAccessTokens;
use yii\filters\auth\HttpBearerAuth;
use common\models\Users;
use common\models\UserSkills;
use api\modules\v1\models\CandidateProfile;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;

class ProfileController extends ApiBaseController{
    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'detail' => ['POST'],
                'update-profile' => ['POST'],
                'update-social' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionDetail(){
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

        if(!($basicDetails->getJobFunction() == "")){
            $result['title'] = $basicDetails->getJobFunction()["name"];
        }else{
            $result['title'] = NULL;
        }
        if(!($basicDetails->getProfilePicture() == "")){
            $result['profile_picture'] = $basicDetails->getProfilePicture();
        }else{
            $result['profile_picture'] = NULL;
        }
            
        if(!($basicDetails->getCurrentCity() == "")){
            $result['current_city'] = $basicDetails->getCurrentCity()["city_name"];
            $result['current_state'] = $basicDetails->getCurrentCity()["state_name"];
        }else{
            $result['current_city'] = NULL;
            $result['current_state'] = NULL;
        }

        if(!($basicDetails->getCurrentCategory() == "")){
            $result['profile'] = $basicDetails->getCurrentCategory()['name'];
        }else{
            $result['profile'] = NULL;
        }

        $result['dob'] = $candidate->dob;
        $result['description'] = $candidate->description;

        $result['facebook'] = $candidate->facebook;
        $result['twitter'] = $candidate->twitter;
        $result['linkedin'] = $candidate->linkedin;
        $result['google'] = $candidate->google;

        if($candidate->is_available) {
            $result['availability'] = $candidate->is_available;
        }else{
            $result['availability'] = 5;

        }

        if($candidate->gender) {
            $result['gender'] = $candidate->gender;
        }else{
            $result['gender'] = 5;
        }

        $result['experience_years'] = $basicDetails->getExperience()[0];
        $result['experience_months'] = $basicDetails->getExperience()[1];

        $result['user_skills'] = $basicDetails->getUserSkills();
        $result['user_languages'] = $basicDetails->getUserLanguages();

        return $this->response(200, $result);
    }

    public function actionUpdateProfile(){
        $basicDetails = new CandidateProfile();
        return Yii::$app->request->post();
        if($basicDetails->load(Yii::$app->request->post())){
            if($basicDetails->validate()) {
                if ($basicDetails->update()) {
                    return $this->response(202, 'Successfully Updated');
                }
                return $this->response(200, 'Already Updated');
            }else{
                return $this->response(409, $basicDetails->getErrors());
            }
        }else{
            return $this->response(422);
        }
    }

    public function actionUpdateSocial(){
        $socialDetails = new CandidateProfile();
        if($socialDetails->load(Yii::$app->request->post())){
            if($socialDetails->updateValues()){
                return $this->response(200, 'Successfully Updated');
            }
            return $this->response(200, 'Already Updated');
        }else{
            return $this->response(422);
        }
    }
}
