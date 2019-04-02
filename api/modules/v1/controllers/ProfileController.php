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

        if(!($basicDetails->getJobFunction() == "")){
            $result['title'] = $basicDetails->getJobFunction()["name"];
        }else{
            $result['title'] = NULL;
        }

        $result['profile_picture'] = $basicDetails->getProfilePicture();

        if(!($basicDetails->getCurrentCity() == "")){
            $result['current_location'] = $basicDetails->getCurrentCity()["city_name"] . ", " . $basicDetails->getCurrentCity()["state_name"];
        }else{
            $result['current_location'] = NULL;
        }

        if(!($basicDetails->getCurrentCategory() == "")){
            $result['profile'] = $basicDetails->getCurrentCategory()["name"];
        }else{
            $result['profile'] = NULL;
        }

        $result['dob'] = $candidate->dob;
        $result['description'] = $candidate->description;

        $result['facebook'] = $candidate->facebook;
        $result['twitter'] = $candidate->twitter;
        $result['linkedin'] = $candidate->linkedin;
        $result['google'] = $candidate->google;

        switch($candidate->is_available){
            case 1:
                $result['availability'] = 'Available';
                break;
            case 2:
                $result['availability'] = 'Open';
                break;
            case 3:
                $result['availability'] = 'Actively Looking';
                break;
            case 4:
                $result['availability'] = 'Exploring Possibilites';
                break;
            case 0:
                $result['availability'] = 'Not Available';
                break;
            default:
                $result['availability'] = 'NA';
                break;
        }

        switch($candidate->gender){
            case 1:
                $result['gender'] = 'Male';
                break;
            case 2:
                $result['gender'] = 'Female';
                break;
            case 3:
                $result['gender'] = 'Transgender';
                break;
            case 4:
                $result['gender'] = 'Rather not to say';
                break;
            default:
                $result['availability'] = 'NA';
                break;
        }

        $result['experience'] = $basicDetails->getExperience()[0] . ' Years '. $basicDetails->getExperience()[1] . ' Months';

        $result['user_skills'] = $basicDetails->getUserSkills();
        $result['user_languages'] = $basicDetails->getUserLanguages();

        return $this->response(200, $result);
    }

    public function actionUpdateProfile(){
        $basicDetails = new CandidateProfile();
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
