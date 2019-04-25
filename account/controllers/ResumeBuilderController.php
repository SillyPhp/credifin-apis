<?php

namespace account\controllers;


use account\models\resumeBuilder\AddExperienceForm;
use account\models\resumeBuilder\AddQualificationForm;
use account\models\resumeBuilder\ResumeAboutMe;
use account\models\resumeBuilder\ResumeAchievments;
use account\models\resumeBuilder\ResumeCertificates;
use account\models\resumeBuilder\ResumeContactInfo;
use account\models\resumeBuilder\ResumeEducation;
use account\models\resumeBuilder\ResumeHobbies;
use account\models\resumeBuilder\ResumeInterests;
use account\models\resumeBuilder\ResumeOtherInfo;
use account\models\resumeBuilder\ResumeProfilePic;
use account\models\resumeBuilder\ResumeProject;
use account\models\resumeBuilder\ResumeSkills;
use account\models\resumeBuilder\ResumeWorkExperience;
use account\models\resumeBuilder\SocialLinks;
use common\models\Skills;
use common\models\UserAchievements;
use common\models\UserEducation;
use common\models\UserHobbies;
use common\models\UserInterests;
use common\models\Users;
use common\models\UserSkills;
use common\models\UserWorkExperience;
use common\models\Utilities;
use frontend\models\account\Applications;
use frontend\models\account\OrganizationsExtends;
use frontend\models\IndividualImageForm;
use frontend\models\NotesForm;
use frontend\models\OrganizationSignUpForm;
use frontend\models\PersonalProfile;
use TwitterPhp\Connection\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use kartik\mpdf\Pdf;


class ResumeBuilderController extends Controller
{

    public function actionMain()
    {

        $addExperienceForm = new AddExperienceForm();
        $addQualificationForm = new AddQualificationForm();
        $ResumeProfilePic = new ResumeProfilePic();
        $ResumeAboutMe = new ResumeAboutMe();
        $ResumeContactInfo = new ResumeContactInfo();
        $ResumeOtherInfo = new ResumeOtherInfo();
        $ResumeEducation = new ResumeEducation();
        $ResumeWorkExperience = new ResumeWorkExperience();
        $ResumeCertificates = new ResumeCertificates();
        $ResumeSkills = new ResumeSkills();
        $ResumeProject = new ResumeProject();
        $ResumeAchievments = new ResumeAchievments();
        $ResumeHobbies = new ResumeHobbies();

        return $this->render('resume-old', [
            'addExperienceForm' => $addExperienceForm,
            'addQualificationForm' => $addQualificationForm,
            'ResumeProfilePic' => $ResumeProfilePic,
            'ResumeAboutMe' => $ResumeAboutMe,
            'ResumeContactInfo' => $ResumeContactInfo,
            'ResumeEducation' => $ResumeEducation,
            'ResumeWorkExperience' => $ResumeWorkExperience,
            'ResumeCertificates' => $ResumeCertificates,
            'ResumeOtherInfo' => $ResumeOtherInfo,
            'ResumeSkills' => $ResumeSkills,
            'ResumeProject' => $ResumeProject,
            'ResumeAchievments' => $ResumeAchievments,
            'ResumeHobbies' => $ResumeHobbies
        ]);
    }


    public function actionAddEducation()
    {
        $addQualificationForm = new AddQualificationForm();
        return $this->renderAjax('add_education', ['addQualificationForm' => $addQualificationForm]);
    }


    public function actionAddExperience()
    {
        $addExperienceForm = new AddExperienceForm();
        return $this->renderAjax('add_experience', ['addExperienceForm' => $addExperienceForm]);
    }

    public function actionResume()
    {

        $ResumeAboutMe = new ResumeAboutMe();
        $addQualificationForm = new AddQualificationForm();
        $addExperienceForm = new AddExperienceForm();
        $ResumeContactInfo = new ResumeContactInfo();
        $ResumeOtherInfo = new ResumeOtherInfo();
        $ResumeCertificates = new ResumeCertificates();
        $ResumeSkills = new ResumeSkills();
        $ResumeProject = new ResumeProject();
        $ResumeAchievments = new ResumeAchievments();
        $individualImageFormModel = new IndividualImageForm();
        $ResumeHobbies = new ResumeHobbies();
        $sociallinks = new SocialLinks();
        $user = Users::find()
            ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->one();

        $experience = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.experience_enc_id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current', 'b.name city'])
            ->innerJoin(\common\models\Cities::tableName() . 'b', 'b.city_enc_id = a.city_enc_id')
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $education = UserEducation::find()
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        $skillist = UserSkills::find()
            ->alias('a')
            ->select(['a.created_by', 'a.user_skill_enc_id', 'c.skill_enc_id', 'c.skill', 'a.created_on', 'a.is_deleted', 'a.user_skill_enc_id'])
            ->joinWith(['skillEnc c'], false)
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        $achievements = UserAchievements::find()
            ->alias('a')
            ->select(['a.user_achievement_enc_id', 'a.achievement'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        $hobbies = UserHobbies::find()
            ->alias('a')
            ->select(['a.user_hobby_enc_id', 'a.hobby'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        $interests = UserInterests::find()
            ->alias('a')
            ->select(['a.user_interest_enc_id', 'a.interest'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        return $this->render('resume', [
            'user' => $user,
            'ResumeAboutMe' => $ResumeAboutMe,
            'individualImageFormModel' => $individualImageFormModel,
            'addQualificationForm' => $addQualificationForm,
            'addExperienceForm' => $addExperienceForm,
            'ResumeContactInfo' => $ResumeContactInfo,
            'ResumeCertificates' => $ResumeCertificates,
            'ResumeOtherInfo' => $ResumeOtherInfo,
            'ResumeSkills' => $ResumeSkills,
            'ResumeProject' => $ResumeProject,
            'ResumeAchievments' => $ResumeAchievments,
            'ResumeHobbies' => $ResumeHobbies,
            'experience' => $experience,
            'education' => $education,
            'skills' => $skillist,
            'achievements' => $achievements,
            'hobbies' => $hobbies,
            'interests' => $interests,
            'sociallinks' => $sociallinks
        ]);
    }


    public function actionChangeInformation()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $ResumeContactInfo = new ResumeContactInfo();
        if ($ResumeContactInfo->load(Yii::$app->request->post())) {
            $update = Yii::$app->db->createCommand()
                ->update(Users::tableName(), ['address' => $ResumeContactInfo->contact_address, 'city_enc_id' => $ResumeContactInfo->city_id, 'last_updated_on' => date('Y-m-d h:i:s')], ['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->execute();
            if ($update) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Description has been Changed.',
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

    public function actionChangeDescription()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->request->post('des_data');
        $update = Yii::$app->db->createCommand()
            ->update(Users::tableName(), ['description' => $data, 'last_updated_on' => date('Y-m-d h:i:s')], ['user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->execute();
        if ($update) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Description has been Changed.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionResumeProfile()
    {
        $ResumeProfilePic = new ResumeProfilePic();
        return $this->render('resume-profile', ['ResumeProfilePic' => $ResumeProfilePic]);
    }

    public function actionResumeAboutMe()
    {
        $ResumeAboutMe = new ResumeAboutMe();

        if ($ResumeAboutMe->load(Yii::$app->request->post()) && $ResumeAboutMe->validate()) {
            if ($ResumeAboutMe->save()) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            return $this->renderAjax('resume-about-me', ['ResumeAboutMe' => $ResumeAboutMe]);
        }
    }

    public function actionResumeContactInfo()
    {
        $ResumeContactInfo = new ResumeContactInfo();
        if ($ResumeContactInfo->load(Yii::$app->request->post())) {
            if ($ResumeContactInfo->save()) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            return $this->renderAjax('resume-contact-info', ['ResumeContactInfo' => $ResumeContactInfo]);
        }
    }

    public function actionResumeOtherInfo()
    {
        $ResumeOtherInfo = new ResumeOtherInfo();

        if ($ResumeOtherInfo->load(Yii::$app->request->post())) {
            if ($ResumeOtherInfo->save()) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            return $this->renderAjax('resume-other-info', ['ResumeOtherInfo' => $ResumeOtherInfo]);
        }
    }

    public function actionExperience()
    {
        if (Yii::$app->request->isAjax) {
            $title = Yii::$app->request->post('title');
            $company = Yii::$app->request->post('company');
            $city = Yii::$app->request->post('city');
            $from = Yii::$app->request->post('from');
            $to = Yii::$app->request->post('to');
            $checkbox = Yii::$app->request->post('checkbox');
            $description = Yii::$app->request->post('description');


            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $obj = new UserWorkExperience();
            $obj->experience_enc_id = $utilitiesModel->encrypt();
            $obj->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $obj->title = $title;
            $obj->company = $company;
            $obj->city_enc_id = $city;
            $obj->from_date = $from;
            $obj->to_date = $to;
            $obj->is_current = $checkbox;
            $obj->created_on = date('Y-m-d h:i:s');
            $obj->created_by = Yii::$app->user->identity->user_enc_id;
            $obj->description = $description;

            if (!$obj->save()) {
                return json_encode($obj->getErrors());
            } else {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Experience added.',
                ]);
            }

        }
    }

    public function actionSocial()
    {
        $sociallinks = new SocialLinks();

        if ($sociallinks->load(Yii::$app->request->post())) {
            $update = Yii::$app->db->createCommand()
                ->update(Users::tableName(), ['facebook' => $sociallinks->facebook, 'instagram' => $sociallinks->instagram, 'linkedin' => $sociallinks->linkedin, 'google' => $sociallinks->google, 'twitter' => $sociallinks->twitter, 'youtube' => $sociallinks->youtube, 'skype' => $sociallinks->skype, 'last_updated_on' => date('Y-m-d h:i:s')], ['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->execute();

            if ($update) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function actionAchievementRemove()
    {

        if (Yii::$app->request->isAjax) {

            $id = Yii::$app->request->post('id');

            $achievement_rmv = UserAchievements::findOne([
                'user_achievement_enc_id' => $id,
                'is_deleted' => 0,
            ]);

            $achievement_rmv->is_deleted = 1;
            if ($achievement_rmv->update()) {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Achievement has been deleted.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }

        }
    }

    public function actionHobbyRemove()
    {

        if (Yii::$app->request->isAjax) {

            $id = Yii::$app->request->post('id');

            $hobby_rmv = UserHobbies::findOne([
                'user_hobby_enc_id' => $id,
                'is_deleted' => 0,
            ]);

            $hobby_rmv->is_deleted = 1;
            if ($hobby_rmv->update()) {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Hobby has been deleted.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }

        }
    }

    public function actionSkillRemove()
    {

        if (Yii::$app->request->isAjax) {

            $id = Yii::$app->request->post('id');

            $skill_rmv = UserSkills::findOne([
                'user_skill_enc_id' => $id,
                'is_deleted' => 0,
            ]);

            $skill_rmv->is_deleted = 1;
            if ($skill_rmv->update()) {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'skill has been deleted.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }

        }
    }

    public function actionInterestRemove()
    {

        if (Yii::$app->request->isAjax) {

            $id = Yii::$app->request->post('id');

            $interest_rmv = UserInterests::findOne([
                'user_interest_enc_id' => $id,
                'is_deleted' => 0,
            ]);

            $interest_rmv->is_deleted = 1;
            if ($interest_rmv->update()) {
                return json_encode($response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'interest has been deleted.',
                ]);
            } else {
                return json_encode($response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ]);
            }

        }
    }

    public function actionAchievements()
    {

        if (Yii::$app->request->isAjax) {


            $achievement_name = Yii::$app->request->post('achievement_name');
            $model = new ResumeAchievments();
            $already_exits = UserAchievements::findOne([
                'user_enc_id' => Yii::$app->user->identity->user_enc_id,
                'achievement' => $achievement_name,
                'is_deleted' => 0
            ]);

            if ($already_exits) {
                return json_encode($response = [
                    'status' => 203,
                    'title' => 'error',
                    'message' => 'Achievement already exists.',
                ]);
            } else {

                $model->achievments = $achievement_name;

                if (!$model->add()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'Achievement successfully added.',
                    ]);
                }
            }
        }

    }

    public function actionHobbies()
    {

        if (Yii::$app->request->isAjax) {

            $hobby_name = Yii::$app->request->post('hobby_name');
            $model = new ResumeHobbies();
            $already_exits = UserHobbies::findOne([
                'user_enc_id' => Yii::$app->user->identity->user_enc_id,
                'hobby' => $hobby_name,
                'is_deleted' => 0
            ]);

            if ($already_exits) {
                return json_encode($response = [
                    'status' => 203,
                    'title' => 'error',
                    'message' => 'Hobby already exists.',
                ]);
            } else {
                $model->hobbies = $hobby_name;

                if (!$model->hobby_add()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'Hobby successfully added.',
                    ]);
                }
            }
        }

    }

    public function actionInterests()
    {

        if (Yii::$app->request->isAjax) {

            $interest_name = Yii::$app->request->post('interest_name');
            $model = new ResumeInterests();
            $already_exits = UserInterests::findOne([
                'user_enc_id' => Yii::$app->user->identity->user_enc_id,
                'interest' => $interest_name,
                'is_deleted' => 0
            ]);

            if ($already_exits) {
                return json_encode($response = [
                    'status' => 203,
                    'title' => 'error',
                    'message' => 'interest already exists.',
                ]);
            } else {
                $model->interests = $interest_name;

                if (!$model->interest_add()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'interest successfully added.',
                    ]);
                }
            }
        }

    }


    public function actionEducation()
    {
        $model = new AddQualificationForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->save();
            if (!$model->save()) {
                print_r($model->getErrors());
            } else {
                return true;
            }

        }

    }

    public function actionEditEducation()
    {
        $id = Yii::$app->request->post('id');
        $editedu = UserEducation::find()
            ->where(['education_enc_id' => $id])
            ->asArray()
            ->one();
        return json_encode($editedu);
    }

    public function actionEditExperience()
    {
        $id = Yii::$app->request->post('id');
        $editexp = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.title', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current', 'a.experience_enc_id', 'a.description', 'b.name', 'b.city_enc_id'])
            ->joinWith(['cityEnc b'])
            ->where(['a.experience_enc_id' => $id])
            ->asArray()
            ->one();

        return json_encode($editexp);
    }

    public function actionDeleteExperience()
    {
        $id = Yii::$app->request->post('id');
        $deleteexp = UserWorkExperience::findOne(
            [
                'experience_enc_id' => $id,
            ]
        );

        if ($deleteexp->delete()) {
            return json_encode($response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'experience has been deleted.',
            ]);
        } else {
            return json_encode($response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ]);
        }

    }

    public function actionDeleteEducation()
    {
        $id = Yii::$app->request->post('id');
        $deleteedu = UserEducation::findOne(
            [
                'education_enc_id' => $id,
            ]
        );

        if ($deleteedu->delete()) {
            return json_encode($response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'experience has been deleted.',
            ]);
        } else {
            return json_encode($response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ]);
        }

    }

    public function actionUpdateEducation()
    {
        if (Yii::$app->request->isAjax) {

            $id = Yii::$app->request->post('id');

            $model = new AddQualificationForm();

            $model->school = Yii::$app->request->post('school');
            $model->degree = Yii::$app->request->post('degree');
            $model->field = Yii::$app->request->post('field');
            $model->qualification_from = Yii::$app->request->post('from');
            $model->qualification_to = Yii::$app->request->post('to');

            if($model->update($id)) {
                return true;
            }else{
                return false;
            }
        }
    }

    public function actionUpdateExperience()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $title = Yii::$app->request->post('title');
            $company = Yii::$app->request->post('company');
            $city = Yii::$app->request->post('city');
            $from = Yii::$app->request->post('from');
            $to = Yii::$app->request->post('to');
            $check = Yii::$app->request->post('check');
            $description = Yii::$app->request->post('description');


            $model = UserWorkExperience::find()
                ->where(['experience_enc_id' => $id])
                ->one();

            $model->title = $title;
            $model->company = $company;
            $model->city_enc_id = $city;
            $model->from_date = $from;
            $model->to_date = $to;
            $model->is_current = $check;
            $model->description = $description;

            if ($model->update()) {
                return true;
            } else {
                return false;
            }

        }

    }

    public function actionSkills()
    {
        if (Yii::$app->request->isAjax) {

            $skillsinput = Yii::$app->request->post('skill_name');

            $obj = new Skills();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);

            $chk = Skills::find()
                ->where(['skill' => $skillsinput])
                ->asArray()
                ->one();


        }

        if (empty($chk)) {
            $obj->skill_enc_id = $utilitiesModel->encrypt();
            $obj->skill = $skillsinput;
            $obj->created_on = date('Y-m-d h:i:s');
            $obj->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$obj->save()) {
                print_r($obj->getErrors());
            } else {

                $user_obj = new UserSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->user_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $obj->skill_enc_id;
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$user_obj->save()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'skill successfully added.',
                    ]);
                }

            }
        } else {
            $chkk = UserSkills::find()
                ->where(['skill_enc_id' => $chk['skill_enc_id'], 'is_deleted' => 0])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->one();

            if (!$chkk) {
                $user_obj = new UserSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->user_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $chk['skill_enc_id'];
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = Yii::$app->user->identity->user_enc_id;

                if (!$user_obj->save()) {
                    return json_encode($response = [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'There is an error.please try again.',
                    ]);
                } else {
                    return json_encode($response = [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'skill successfully added.',
                    ]);
                }
            } else {
                return json_encode($response = [
                    'status' => 203,
                    'title' => 'error',
                    'message' => 'skill already exists.',
                ]);
            }

        }
    }


    public function actionCertificate()
    {
        if (Yii::$app->request->isAjax) {
            $certificate = Yii::$app->request->post('certificate');
            return $certificate;

        }

    }

    public function actionTestLink()
    {
        $user_obj = UserSkills::find()->asArray()->all();
        print_r($user_obj);
    }

    public function actionResumeEducation()
    {
        $ResumeEducation = new ResumeEducation();

        if ($ResumeEducation->load(Yii::$app->request->post()) && $model->validate()) {
            if ($ResumeEducation->save()) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return $this->renderAjax('resume-education', ['ResumeEducation' => $ResumeEducation]);
        }
    }

    public function actionResumeWorkExperience()
    {
        $ResumeWorkExperience = new ResumeWorkExperience();

        return $this->renderAjax('resume-work-experience', ['ResumeWorkExperience' => $ResumeWorkExperience]);
    }

    public function actionResumeCertificates()
    {
        $ResumeCertificates = new ResumeCertificates();
        return $this->renderAjax('resume-certificates', ['ResumeCertificates' => $ResumeCertificates]);
    }

    public function actionResumeSkills()
    {
        $ResumeSkills = new ResumeSkills();
        return $this->renderAjax('resume-skills', ['ResumeSkills' => $ResumeSkills]);
    }

    public function actionResumeProject()
    {
        $ResumeProject = new ResumeProject();
        return $this->renderAjax('resume-project', ['ResumeProject' => $ResumeProject]);
    }

    public function actionResumeAchievments()
    {
        $ResumeAchievments = new ResumeAchievments();
        return $this->renderAjax('resume-achievments', ['ResumeAchievments' => $ResumeAchievments]);
    }

    public function actionResumeHobbies()
    {
        $ResumeHobbies = new ResumeHobbies();
        return $this->renderAjax('resume-hobbies', ['ResumeHobbies' => $ResumeHobbies]);
    }

    public function actionResumeTestPage()
    {
        $ResumeProfilePic = new ResumeProfilePic();
        return $this->render('resume-test-page', ['ResumeProfilePic' => $ResumeProfilePic]);
    }

    public function actionTemplate($id)
    {
//        Z1diVksxWTVrLzcyVkRaQXA3N2ljUT09//
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            //->joinWith(['cityEnc d'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id' => $id])
            ->asArray()
            ->all();

        if (empty($data)) {
            return 'user data not found';
        }
        return $this->render('template', ['data' => $data]);
    }

    /*  public function actionTemplateOne()
      {
          return $this->render('templateone');
      }*/
    public function actionSecond($id)
    {
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id' => $id])
            ->asArray()
            ->all();

        if (empty($data)) {
            return 'user data not found';
        }
        return $this->render('secondtemplate', ['data' => $data]);
    }

    public function actionThird($id)
    {
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id' => $id])
            ->asArray()
            ->all();
        if (empty($data)) {
            return 'user not found';
        }
        return $this->render('thirdtemplate', ['data' => $data]);
    }

    public function actionFourth($id)
    {
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id' => $id])
            ->asArray()
            ->all();
        if (empty($data)) {
            return 'user not found';
        }

        return $this->render('fourthtemplate', ['data' => $data]);
    }

    public function actionFifth($id)
    {
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id' => $id])
            ->asArray()
            ->all();

        if (empty($data)) {
            return 'user not found';
        }
        return $this->render('fifthtemplate', ['data' => $data]);
    }
}