<?php

namespace frontend\controllers;
use common\models\Categories;
use common\models\Cities;
use common\models\States;
use common\models\Users;

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
        if (!Yii::$app->user->isGuest)
        {
            $userProfilePicture = new UserProfilePictureEdit();
            $basicDetails = new UserProfileBasicEdit();
            $socialDetails = new UserProfileSocialEdit();
            $statesModel = new States();
            $getName = $basicDetails->getJobFunction();
            $getCurrentCity = $basicDetails->getCurrentCity();
            $getExperience = $basicDetails->getExperience();
            return $this->render('index',['userProfilePicture'=>$userProfilePicture,'getExperience'=>$getExperience,'getCurrentCity'=>$getCurrentCity,'getName'=>$getName,'basicDetails'=>$basicDetails,'socialDetails'=>$socialDetails,'statesModel'=>$statesModel]);
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
                    'title' => 'failed',
                    'message' => 'Failed To Update.'
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
            return 2;
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
                    'title' => 'failed',
                    'message' => 'Failed To Update.'
                ];
                return $response;
            }
        }
    }

}