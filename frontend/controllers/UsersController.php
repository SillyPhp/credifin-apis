<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\models\IndividualImageForm;
use frontend\models\IndividualCoverImageForm;
use frontend\models\AddExperienceForm;
use frontend\models\AddQualificationForm;
use frontend\models\AddSkillForm;
use common\models\Users;
use common\models\UserWorkExperience;
use common\models\UserEducation;
use yii\web\UploadedFile;

class UsersController extends Controller {

    public function actionProfile($uidk) {
        $user = Users::find()
                ->where(['username' => $uidk, 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();
        $experience = UserWorkExperience::find()
                ->alias('a')
                ->select(['a.experience_enc_id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current', 'b.name city'])
                ->innerJoin(\common\models\Cities::tableName() . 'b', 'b.city_enc_id = a.city_enc_id')
                ->where(['a.created_by' => $user['user_enc_id']])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->one();
        $education = UserEducation::find()
                ->where(['created_by' => $user['user_enc_id']])
                ->orderBy(['id' => SORT_DESC])
                ->asArray()
                ->limit(2)
                ->all();
//        print_r($education);
//        exit();
        if ($user['user_enc_id'] == Yii::$app->user->identity->user_enc_id) {
            $AddExperienceForm = new AddExperienceForm();
            $addQualificationForm = new AddQualificationForm();
            $addSkillForm = new AddSkillForm();
            $individualImageFormModel = new IndividualImageForm();
            $individualCoverImageFormModel = new IndividualCoverImageForm();
            return $this->render('candidate-profile-edit-new', [
                        'user' => $user,
                        'experience' => $experience,
                        'education' => $education,
                        'individualImageFormModel' => $individualImageFormModel,
                        'individualCoverImageFormModel' => $individualCoverImageFormModel,
                        'addQualificationForm' => $addQualificationForm,
                        'AddExperienceForm' => $AddExperienceForm,
                        'addSkillForm' => $addSkillForm,
            ]);
        }

        return $this->render('candidate-profile-new', [
                    'user' => $user,
                    'experience' => $experience,
                    'education' => $education,
                    'addSkillForm' => $addSkillForm,
        ]);
    }

//
//    public function actionProfile($uidk) {
//        $user = Users::find()
//                ->where(['username' => $uidk, 'status' => 'Active', 'is_deleted' => 0])
//                ->asArray()
//                ->one();
//        
//        $experience = UserWorkExperience::find()
//                ->where(['created_by' => $user['user_enc_id']])
//                ->asArray()
//                ->limit(3)
//                ->all();
//        if ($user['user_enc_id'] == Yii::$app->user->identity->user_enc_id) {
//            $AddExperienceForm = new AddExperienceForm();
//            $individualImageFormModel = new IndividualImageForm();
//            $individualCoverImageFormModel = new IndividualCoverImageForm();
//            return $this->render('candidate-profile', [
//                        'user' => $user,
//                        'experience' => $experience,
//                        'individualImageFormModel' => $individualImageFormModel,
//                        'individualCoverImageFormModel' => $individualCoverImageFormModel,
//                        'AddExperienceForm' => $AddExperienceForm,
//            ]);
//        }
//        return $this->render('candidate-profile2', [
//                    'user' => $user,
//        ]);
//    }
//    public function actionAddExperience() {
//        $userWorkExperience = new UserWorkExperience();
//        if ($userWorkExperience->load(Yii::$app->request->post()) && $model->save()) {
//            return $response = [
//                'status' => 200,
//                'message' => Yii::t('frontend', 'You are successfully subscribed.'),
//            ];
//        }
//    }
    public function actionAddExperience() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $AddExperienceForm = new AddExperienceForm();
        if ($AddExperienceForm->load(Yii::$app->request->post())) {
//            return $AddExperienceForm;
//            exit;
            if ($AddExperienceForm->save()) {

                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Your Experience has been added.',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

    public function actionAddQualification() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $addQualificationForm = new AddQualificationForm();
//        if(Yii::$app->request->post()){
//            return 1;
//        }
//        else{
//            return 0;
//        }
        if ($addQualificationForm->load(Yii::$app->request->post())) {
            if ($addQualificationForm->save()) {

                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Your Experience has been added.',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        } else{
            return 'nothing';
        }
    }

    public function actionUpdateProfile() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->post()) {
            $userData = Yii::$app->request->post();
            $user = Users::findOne([
                        'user_enc_id' => Yii::$app->user->identity->user_enc_id,
                        'status' => 'Active',
                        'is_deleted' => 0,
            ]);
            $field = $userData['name'];
            $user->$field = $userData['value'];
            if ($user->validate()) {
                if ($user->save()) {
                    $response = [
                        'status' => 200,
                        'message' => Yii::t('frontend', 'You are successfully subscribed.'),
                    ];
                    return true;
                } else {
                    $response = [
                        'status' => 201,
                        'message' => Yii::t('frontend', 'An error has occurred. Please try again.'),
                    ];
                    return false;
                }
            } else {
                $response = [
                    'status' => 0,
                    'message' => Yii::t('frontend', 'Please enter all the information correctly'),
                ];
            }
            return $response;
        }
    }

    public function actionUpdateProfileImage() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $individualImageFormModel = new IndividualImageForm();
        if (Yii::$app->request->post()) {
            $individualImageFormModel->image = UploadedFile::getInstance($individualImageFormModel, 'image');

            if ($individualImageFormModel->save()) {

                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Profile image has been changed.',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

    public function actionUpdateCoverImage() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $individualCoverImageFormModel = new IndividualCoverImageForm();
        if (Yii::$app->request->post()) {
            $individualCoverImageFormModel->cover_image = UploadedFile::getInstance($individualCoverImageFormModel, 'cover_image');
            if ($individualCoverImageFormModel->save()) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Cover image has been changed.',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

    public function actionRemoveImage() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = Yii::$app->request->post('type');
        if ($type == 'image') {
            $update = Yii::$app->db->createCommand()
                    ->update(Users::tableName(), ['image' => null, 'image_location' => null], ['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                    ->execute();
        } elseif ($type == 'cover') {
            $update = Yii::$app->db->createCommand()
                    ->update(Users::tableName(), ['cover_image' => null, 'cover_image_location' => null], ['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                    ->execute();
        }
        if ($update) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Image has been Removed.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionCpNew() {
        $user = Users::find()
                ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id, 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();
        return $this->render('candidate-profile-new', [
                    'user' => $user,
        ]);
    }

}
