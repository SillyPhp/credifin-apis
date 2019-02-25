<?php

namespace api\modules\v1\controllers;

use api\modules\v1\controllers\ApiBaseController;
use api\modules\v1\models\CandidateUpload;
use common\models\AssignedCategories;
use common\models\Categories;
use yii\filters\auth\HttpBearerAuth;
use common\models\Cities;
use common\models\Countries;
use common\models\PartnershipData;
use common\models\States;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;


class UploadController extends ApiBaseController{
    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'profile-picture' => ['POST'],
                'resume' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionProfilePicture(){
        $userProfilePicture = new CandidateUpload();
        $userProfilePicture->profile_image = UploadedFile::getInstanceByName('profile_image');
            if($userProfilePicture->update()){
                return $this->response(200, 'Successfully Updated');
            }
            return $this->response(200, 'Update Failed');
    }

    public function actionResume(){
        $userResume = new CandidateUpload();
        $userResume->resume_file = UploadedFile::getInstanceByName('resume_file');
        if ($res = $userResume->upload()) {
            return $this->response(200, $res);
        } else {
            return $this->response(204);
        }
    }
}
