<?php

namespace api\modules\v1\controllers;

use api\modules\v1\controllers\ApiBaseController;
use api\modules\v1\models\CandidateUpload;
use api\modules\v1\models\PictureUpload;
use api\modules\v1\models\ResumeUpload;
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


class UploadController extends ApiBaseController
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
                'profile-picture' => ['POST'],
                'resume' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionProfilePicture()
    {

        $req = Yii::$app->request->post();
        $image = base64_decode($req['image_string']);

        $userProfilePicture = new PictureUpload();
        if ($a = $userProfilePicture->update($image)) {
            return $this->response(200, $a);
        }
        return $this->response(500);
    }

    public function actionResume()
    {
        $userResume = new ResumeUpload();
        $userResume->resume_file = UploadedFile::getInstanceByName('resume_file');
        if ($userResume->resume_file && $userResume->validate()) {
            if ($res = $userResume->upload()) {
                return $this->response(202, $res);
            } else {
                return $this->response(500);
            }
        } else {
            return $this->response(409);
        }
    }
}
