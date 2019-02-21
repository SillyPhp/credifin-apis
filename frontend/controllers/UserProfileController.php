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
    public function actionView($uidk)
    {
        $user = Users::find()
            ->alias('a')
            ->select(['a.*',
                '(CASE 
                WHEN a.is_available = "0" THEN "Not Available"
                WHEN a.is_available = "1" THEN "Available"
                WHEN a.is_available = "2" THEN "Open"
                WHEN a.is_available = "3" THEN "Actively Looking"
                WHEN a.is_available = "4" THEN "Exploring Possibilities"
                ELSE "Undefined"
                END) as availability', 'ROUND(DATEDIFF(CURDATE(), a.dob)/ 365.25) as age', 'b.name as city', 'c.name as job_profile'])
            ->leftJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
            ->leftJoin(Categories::tableName() . 'as c', 'c.category_enc_id = a.job_function')
            ->where(['username' => $uidk, 'status' => 'Active', 'is_deleted' => 0])
            ->asArray()
            ->one();

        if (!count($user) > 0) {
            return 'No User Found';
        }

        $skills = \common\models\UserSkills::find()
            ->alias('a')
            ->select(['a.skill_enc_id', 'b.skill skills'])
            ->innerJoin(\common\models\Skills::tableName() . 'b', 'b.skill_enc_id = a.skill_enc_id')
            ->where(['a.created_by' => $user['user_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $language = \common\models\UserSpokenLanguages::find()
            ->alias('a')
            ->select(['a.language_enc_id', 'b.language language'])
            ->innerJoin(\common\models\SpokenLanguages::tableName() . 'b', 'b.language_enc_id = a.language_enc_id')
            ->where(['a.created_by' => $user['user_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->all();

        return $this->render('view', [
            'user' => $user,
            'skills' => $skills,
            'language' => $language,
        ]);
    }

    public function actionEdit()
    {
        if (!Yii::$app->user->isGuest && empty(Yii::$app->user->identity->organization)) {
            $userProfilePicture = new UserProfilePictureEdit();
            $basicDetails = new UserProfileBasicEdit();
            $socialDetails = new UserProfileSocialEdit();
            $statesModel = new States();
            $getName = $basicDetails->getJobFunction();
            $getCurrentCity = $basicDetails->getCurrentCity();
            $getExperience = $basicDetails->getExperience();
            $getSkills = $basicDetails->getUserSkills();
            $getlanguages = $basicDetails->getUserlanguages();
            return $this->render('edit', [
                'userProfilePicture' => $userProfilePicture,
                'userLanguage' => $getlanguages,
                'userSkills' => $getSkills,
                'getExperience' => $getExperience,
                'getCurrentCity' => $getCurrentCity,
                'getName' => $getName,
                'basicDetails' => $basicDetails,
                'socialDetails' => $socialDetails,
                'statesModel' => $statesModel,
            ]);
        } else {
            return 'You are not Login as candidate login';
        }


    }

    public function actionUpdateBasicDetail()
    {
        $basicDetails = new UserProfileBasicEdit();
        if ($basicDetails->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($basicDetails->update()) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
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
        if ($socialDetails->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($socialDetails->updateValues()) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
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
        if ($userProfilePicture->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($userProfilePicture->update()) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
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