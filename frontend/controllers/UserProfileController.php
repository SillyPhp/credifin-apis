<?php

namespace frontend\controllers;
use common\models\Categories;
use common\models\Cities;
use common\models\States;
use common\models\Users;

use common\models\UserSkills;
use frontend\models\profile\UserProfilePictureEdit;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\models\profile\UserProfileBasicEdit;
use frontend\models\profile\UserProfileSocialEdit;
class UserProfileController extends Controller
{
    public function actionEdit()
    {
        if (!Yii::$app->user->isGuest && empty(Yii::$app->user->identity->organization))
        {
            $userProfilePicture = new UserProfilePictureEdit();
            $basicDetails = new UserProfileBasicEdit();
            $socialDetails = new UserProfileSocialEdit();
            $statesModel = new States();
            $getName = $basicDetails->getJobFunction();
            $getCurrentCity = $basicDetails->getCurrentCity();
            $getExperience = $basicDetails->getExperience();
            $getSkills = $basicDetails->getUserSkills();
            $getlanguages = $basicDetails->getUserlanguages();
            return $this->render('index',['userProfilePicture'=>$userProfilePicture,'userLanguage'=>$getlanguages,'userSkills'=>$getSkills,'getExperience'=>$getExperience,'getCurrentCity'=>$getCurrentCity,'getName'=>$getName,'basicDetails'=>$basicDetails,'socialDetails'=>$socialDetails,'statesModel'=>$statesModel]);
        }
        else
        {
            return 'You are not Login as candidate login';
        }


    }

    public function actionUpdateBasicDetail()
    {
        $basicDetails = new UserProfileBasicEdit();
        if ($basicDetails->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($basicDetails->update())
            {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            }
            else
            {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }


    public function actionUpdateSocialDetail()
    {
        $socialDetails = new UserProfileSocialEdit();
        if ($socialDetails->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($socialDetails->updateValues())
            {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            }
            else
            {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }


    public function actionUpdateProfilePicture()
    {
        $userProfilePicture = new UserProfilePictureEdit();
        if ($userProfilePicture->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($userProfilePicture->update())
            {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            }
            else
            {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }


}