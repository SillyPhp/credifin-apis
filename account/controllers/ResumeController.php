<?php

namespace account\controllers;


use common\models\AssignedCategories;
use common\models\Categories;
use common\models\DropResumeApplicationLocations;
use common\models\DropResumeApplications;
use common\models\DropResumeApplicationTitles;
use common\models\EmployerApplications;
use common\models\OrganizationAssignedCategories;
use common\models\OrganizationLocations;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use account\models\resume\ResumeProfilePic;

use account\models\resume\ResumeOtherInfo;
use account\models\resume\ResumeEducation;
use account\models\resume\ResumeSkills;
//use frontend\models\ResumeProject;
use account\models\resume\ResumeWorkExperience;
use account\models\resume\ResumeHobbies;
use account\models\resume\ResumeInterests;
use account\models\resume\ResumeAchievments;
//use frontend\models\ResumeCertificates;
//use frontend\models\IndividualImageForm;
use account\models\resume\ResumeAboutMe;
use account\models\resume\ResumeContactInfo;
use account\models\resume\AddExperienceForm;
use account\models\resume\AddQualificationForm;
use common\models\UserWorkExperience;
use common\models\UserEducation;
use common\models\Utilities;
use common\models\Users;
use common\models\UserSkills;
//use frontend\models\SocialLinks;
use common\models\Skills;
use common\models\UserAchievements;
use common\models\UserHobbies;
use common\models\UserInterests;


class ResumeController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'validate' => ['POST'],
                ],
            ],
        ];
    }

//    public $layout = 'backend-main';

    public function actionMain() {

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
        $ResumeInterests = new ResumeInterests();

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
            'ResumeHobbies' => $ResumeHobbies,
            'ResumeInterests'=>$ResumeInterests
        ]);
    }


    public function actionAddEducation() {
        $addQualificationForm = new AddQualificationForm();
        return $this->renderAjax('add_education', ['addQualificationForm' => $addQualificationForm]);
    }


    public function actionAddExperience() {
        $addExperienceForm = new AddExperienceForm();
        return $this->renderAjax('add_experience', ['addExperienceForm' => $addExperienceForm]);
    }

    public function actionResume() {

        $demo = UserSkills::find()
            ->alias('a')
            ->select(['a.created_by','b.skill','a.skill_enc_id'])
            ->joinWith(['skillEnc b'],false)
            ->where(['a.created_by'=>Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();
//        print_r($demo);
//        exit;
        $model =  Users::find()
            ->where(['user_enc_id'=> Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();

       $ResumeAboutMe = new ResumeAboutMe();
        $addQualificationForm = new AddQualificationForm();
        $addExperienceForm = new AddExperienceForm();
       $ResumeContactInfo = new ResumeContactInfo();
       $ResumeOtherInfo = new ResumeOtherInfo();
//        $ResumeCertificates = new ResumeCertificates();
      $ResumeSkills = new ResumeSkills();
//        $ResumeProject = new ResumeProject();
        $ResumeAchievments = new ResumeAchievments();
//        $individualImageFormModel = new IndividualImageForm();
       $ResumeHobbies = new ResumeHobbies();
       $ResumeInterests = new ResumeInterests();
//        $sociallinks = new SocialLinks();
        $user = Users::find()
            ->where(['user_enc_id'=> Yii::$app->user->identity->user_enc_id])
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

        $achieve = UserAchievements::find()
            ->where(['created_by'=>Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();

        $hobbies = UserHobbies::find()
            ->where(['created_by'=>Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();


        $interests = UserInterests::find()
            ->where(['created_by'=>Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();

        $skillist = UserSkills::find()
            ->alias('a')
            ->select(['a.created_by','a.skill_enc_id','c.skill_enc_id','c.skill','a.created_on','a.is_deleted','a.user_skill_enc_id'])
            ->joinWith(['skillEnc c'],false)
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        return $this->render('resume', [
                    'ResumeProfilePic' => $ResumeProfilePic,
            'user' => $user,
           'ResumeAboutMe' => $ResumeAboutMe,
//            'individualImageFormModel' => $individualImageFormModel,
            'addQualificationForm' => $addQualificationForm,
            'addExperienceForm' => $addExperienceForm,
            'ResumeContactInfo' => $ResumeContactInfo,
//                    'ResumeEducation' => $ResumeEducation,
  //                 'ResumeWorkExperience' => $ResumeWorkExperience,
//            'ResumeCertificates' => $ResumeCertificates,
            'ResumeOtherInfo' => $ResumeOtherInfo,
            'ResumeSkills' => $ResumeSkills,
//            'ResumeProject' => $ResumeProject,
           'ResumeAchievments' => $ResumeAchievments,
            'ResumeHobbies' => $ResumeHobbies,
            'ResumeInterests'=>$ResumeInterests,
            'experience' => $experience,
            'education' => $education,
            'skillist' => $skillist,
            'achieve' =>$achieve,
            'hobbies'=>$hobbies,
             'interests'=>$interests
//            'sociallinks'=>$sociallinks
        ]);
    }

    public function actionSkillrmv() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');

        $task = UserSkills::findOne([
            'user_skill_enc_id' => $id,
            'is_deleted' => 0,
        ]);

        $task->is_deleted = 1;
        if ($task->update()) {
            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Skill has been deleted.',
            ];
        } else {
            return $response = [
                'status' => 201,
                'title' => 'Error',
                'message' => 'An error has occurred. Please try again.',
            ];
        }
    }

    public function actionChangeInformation() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $ResumeContactInfo = new ResumeContactInfo();
//        $data_address = Yii::$app->request->post('info_address');
//        $data_state = Yii::$app->request->post('info_state');
//        $data_city = Yii::$app->request->post('info_city');
//        exit();
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

    public function actionChangeDescription() {
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

    public function actionResumeProfile() {
        $ResumeProfilePic = new ResumeProfilePic();
        return $this->render('resume-profile', ['ResumeProfilePic' => $ResumeProfilePic]);
    }

    public function actionResumeAboutMe() {
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

    public function actionResumeContactInfo() {
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

    public function actionResumeOtherInfo() {
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

    public function actionTest() {
        $model = new AddExperienceForm();
        if(Yii::$app->request->isAjax){
            $title = Yii::$app->request->post('title');
            $company = Yii::$app->request->post('company');
            $city  = Yii::$app->request->post('city');
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

            if (!$obj->save())
            {
                print_r($obj->getErrors());
            }
            else
            {
                return true;
            }

        }
    }

    public function actionSocial()
    {
        $sociallinks = new SocialLinks();

        if ($sociallinks->load(Yii::$app->request->post())) {
            $update = Yii::$app->db->createCommand()
                ->update(Users::tableName(), ['facebook' => $sociallinks->facebook, 'instagram' => $sociallinks->instagram, 'linkedin' => $sociallinks->linkedin ,'google' => $sociallinks->google ,'twitter' => $sociallinks->twitter ,'youtube'=>$sociallinks->youtube,'skype'=>$sociallinks->skype,'last_updated_on' => date('Y-m-d h:i:s')], ['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->execute();

            if ($update) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function actionEducation()
    {
        $model = new AddQualificationForm();

        if ($model->load(Yii::$app->request->post())){

            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $obj = new UserEducation();
            $obj->education_enc_id = $utilitiesModel->encrypt();
            $obj->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $obj->institute = $model->school;
            $obj->degree = $model->degree;
            $obj->field = $model->field;
            $obj->from_date = $model->qualification_from;
            $obj->to_date = $model->qualification_to;
            $obj->created_on = date('Y-m-d h:i:s');
            $obj->created_by = Yii::$app->user->identity->user_enc_id;

            if (!$obj->save()) {
                print_r($obj->getErrors());
            }
            else
            {
                return true;
            }

        }

    }

    public function actionAchievements()
    {
        $model = new ResumeAchievments();

        if ($model->load(Yii::$app->request->post())) {


            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $obj = new UserAchievements();
            $obj->user_achievement_enc_id = $utilitiesModel->encrypt();
            $obj->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $obj->achievement = $model->achievments;
            $obj->created_by = Yii::$app->user->identity->user_enc_id;

            if (!$obj->save()) {
                print_r($obj->getErrors());
            }
            else
            {
                return true;
            }

        }
    }

    public function actionHobbies()
    {
        $model = new ResumeHobbies ();
        if($model->load(Yii::$app->request->post()))
        {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $obj = new UserHobbies();
            $obj->user_hobby_enc_id = $utilitiesModel->encrypt();
            $obj->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $obj->hobby = $model->interests_hobbies;
            $obj->created_by = Yii::$app->user->identity->user_enc_id;

            if(!$obj->save())
            {
                print_r($obj->getErrors());
            }
            else{
                return true;
            }
        }

    }

    public function actionInterest()
    {
        $model = new ResumeInterests();
        if($model->load(Yii::$app->request->post()))

        {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $obj = new UserInterests();
            $obj->user_interest_enc_id = $utilitiesModel->encrypt();
            $obj->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $obj->interest = $model->interest;
            $obj->created_by = Yii::$app->user->identity->user_enc_id;

            if(!$obj->save())
            {
                print_r($obj->getErrors());
            }
            else{
                return true;
            }
        }
    }

    public function actionEditEducation(){
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
            ->where(['experience_enc_id' =>$id])
            ->asArray()
            ->one();
        return json_encode($editexp);
    }

    public function actionUpdateEducation(){
        $id = Yii::$app->request->post('id');
        $school = Yii::$app->request->post('school');
        $degree = Yii::$app->request->post('degree');
        $field = Yii::$app->request->post('field');
        $from = Yii::$app->request->post('from');
        $to = Yii::$app->request->post('to');


        if (Yii::$app->request->isAjax){
            $update = Yii::$app->db->createCommand()
                ->update(UserEducation::tableName(), ['institute' => $school, 'degree' => $degree, 'field' => $field ,'from_date' => $from, 'to_date' => $to ,'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['education_enc_id' => $id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionUpdateExperience()
    {
        if(Yii::$app->request->isAjax)
        {
            $id = Yii::$app->request->post('id');
            $title = Yii::$app->request->post('title');
            $company = Yii::$app->request->post('company');
            $city = Yii::$app->request->post('city');
            $from = Yii::$app->request->post('from');
            $to = Yii::$app->request->post('to');
            $check = Yii::$app->request->post('check');
            $description = Yii::$app->request->post('description');


            $model = UserWorkExperience::find()
                ->where(['experience_enc_id'=>$id])
//                    ->asArray()
                ->one();

            $model->title = $title;
            $model->company = $company;
            $model->city_enc_id = $city;
            $model->from_date = $from;
            $model->to_date = $to;
            $model->is_current = $check;
            $model->description  = $description;
            $model->update();

            if($model)
            {
                return true;
            }
            else{
                return false;
            }

//            $update = Yii::$app->db->createCommand()
//                ->update(UserWorkExperience::tableName(),['title'=>$title,'company'=>$company,'city_enc_id'=>$city,'from_date'=>$from,'to_date'=>$to,'is_current'=>$check,'description'=>$description,'created_on'=>date('Y-m-d h:i:s'),'created_by'=>Yii::$app->user->identity->user_enc_id],['experience_enc_id'=>$id])
//                ->execute();
//              return $update;
//            if($update)
//            {
//                return true;
//            }
//            else
//            {
//                return false;
//            }
        }

    }

    public function actionSkills()
    {
        if(Yii::$app->request->isAjax)
        {

            $skill_id = Yii::$app->request->post('skill_id');
            $skillsinput = Yii::$app->request->post('skillsinput');

            $obj = new Skills();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);

            $chk = Skills::find()
                ->where(['skill'=>$skillsinput])
                ->asArray()
                ->one();


        }

        if (empty($chk) )
        {
            $obj->skill_enc_id =  $utilitiesModel->encrypt();
            $obj->skill = $skillsinput;
            $obj->created_on = date('Y-m-d h:i:s');
            $obj->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$obj->save())
            {
                print_r($obj->getErrors());
            }
            else
            {

                $user_obj = new UserSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->user_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id  = $obj->skill_enc_id ;
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$user_obj->save())
                {
                    print_r($user_obj->getErrors());
                }
                else
                {
                    return true;
                }

            }
        }
        else{
            $chkk = UserSkills::find()->where(['skill_enc_id'=>$chk['skill_enc_id']])->andWhere(['created_by'=> Yii::$app->user->identity->user_enc_id])->asArray()->one();
            if(!$chkk) {
                $user_obj = new UserSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user_obj->user_skill_enc_id = $utilitiesModel->encrypt();
                $user_obj->skill_enc_id = $chk['skill_enc_id'];
                $user_obj->created_on = date('Y-m-d h:i:s');
                $user_obj->created_by = Yii::$app->user->identity->user_enc_id;

                if (!$user_obj->save()) {
                    print_r($user_obj->getErrors());
                } else {
                    return true;
                }
            }
            else{
                return 'already exists';

            }

        }
    }

    public function actionCertificate()
    {
        if(Yii::$app->request->isAjax)
        {
            $certificate = Yii::$app->request->post('certificate');
            return $certificate;

        }

    }

    public function actionTestLink()
    {
        $user_obj = UserSkills::find()->asArray()->all();
        print_r($user_obj);
    }

    public function actionResumeEducation() {
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

    public function actionResumeWorkExperience() {
        $ResumeWorkExperience = new ResumeWorkExperience();

        return $this->renderAjax('resume-work-experience', ['ResumeWorkExperience' => $ResumeWorkExperience]);
    }

    public function actionResumeCertificates() {
        $ResumeCertificates = new ResumeCertificates();
        return $this->renderAjax('resume-certificates', ['ResumeCertificates' => $ResumeCertificates]);
    }

    public function actionResumeSkills() {
        $ResumeSkills = new ResumeSkills();
        return $this->renderAjax('resume-skills', ['ResumeSkills' => $ResumeSkills]);
    }

    public function actionResumeProject() {
        $ResumeProject = new ResumeProject();
        return $this->renderAjax('resume-project', ['ResumeProject' => $ResumeProject]);
    }

    public function actionResumeAchievments() {
        $ResumeAchievments = new ResumeAchievments();
        return $this->renderAjax('resume-achievments', ['ResumeAchievments' => $ResumeAchievments]);
    }

    public function actionResumeHobbies() {
        $ResumeHobbies = new ResumeHobbies();
        return $this->renderAjax('resume-hobbies', ['ResumeHobbies' => $ResumeHobbies]);
    }

    public function actionResumeTestPage() {
        $ResumeProfilePic = new ResumeProfilePic();
        return $this->render('resume-test-page', ['ResumeProfilePic' => $ResumeProfilePic]);
    }

    public function actionTemplate($id)
    {
//        Z1diVksxWTVrLzcyVkRaQXA3N2ljUT09//
        $data =  Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            //->joinWith(['cityEnc d'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id'=>$id])
            ->asArray()
            ->all();

        if (empty($data))
        {
            return 'user data not found';
        }
        return $this->render('template',['data'=>$data]);
    }

    public function actionSecond($id)
    {
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id'=>$id])
            ->asArray()
            ->all();

        if(empty($data))
        {
            return 'user data not found';
        }
        return $this->render('secondtemplate',['data'=>$data]);
    }

    public function actionThird($id)
    {
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id'=>$id])
            ->asArray()
            ->all();
        if(empty($data))
        {
            return 'user not found';
        }
        return $this->render('thirdtemplate',['data'=>$data]);
    }

    public function actionFourth($id)
    {
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id'=>$id])
            ->asArray()
            ->all();
        if(empty($data))
        {
            return 'user not found';
        }

        return $this->render('fourthtemplate',['data'=>$data]);
    }

    public function actionFifth($id)
    {
        $data = Users::find()
            ->alias('a')
            ->joinWith(['userEducations b'])
            ->joinWith(['userWorkExperiences c'])
            ->joinWith(['skills d'])
            ->where(['a.user_enc_id'=>$id])
            ->asArray()
            ->all();

        if(empty($data))
        {
            return 'user not found';
        }
        return $this->render('fifthtemplate',['data'=>$data]);
    }

    public function actionAchieve()
    {
        $id = 'p01dY3DbQyRnRMQxvwxNyMg8j9BwrO';
        $data = UserAchievements::find()->alias('a')->where(['a.user_enc_id'=>$id])->asArray()->all();
        print_r($data);
        exit;
    }

    public function actionHobbie()
    {
        $id = 'p01dY3DbQyRnRMQxvwxNyMg8j9BwrO';
        $data = UserHobbies::find()->alias('a')->where(['a.user_enc_id'=>$id])->asArray()->all();
        print_r($data);
        exit;
    }

    public function actionInterestss()
    {
        $id = 'p01dY3DbQyRnRMQxvwxNyMg8j9BwrO';
        $data = UserInterests::find()->alias('a')->where(['a.user_enc_id'=>$id])->asArray()->all();
        print_r($data);
        exit;
    }

    //Drop resume actions

    public function actionFirst()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $category_enc_id = Yii::$app->request->post('parent_id');
            $type = Yii::$app->request->post('type');

            $second_modal_categories = AssignedCategories::find()
                ->alias('a')
                ->select(['b.name', 'b.category_enc_id'])
                ->innerJoin(Categories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->where(['a.assigned_to' => $type, 'a.parent_enc_id' => $category_enc_id,'a.is_deleted' => 0])
                ->andWhere([
                    'or',
                    ['=', 'a.status', 'Approved'],
                    ['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]
                ])
                ->asArray()
                ->all();

            $already_selected_categories = $this->savedData($category_enc_id, $type);

            $response = [];
            $response["parent_enc_id"] = $category_enc_id;
            $response["already_selected_categories"] = $already_selected_categories;
            $response["second_modal_categories"] = $second_modal_categories;


            return json_encode($response);
        }
    }

    public function actionAdd()
    {
        $failure = ['status' => 201];
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $new_value = Yii::$app->request->post('new_value');
            $parent_enc_id = Yii::$app->request->post('parent_enc_id');
            $type = Yii::$app->request->post('type');

            $data = $this->addCategory($new_value);

            if ($this->alreadyHave($data['category_enc_id'], $parent_enc_id)) {
                return json_encode($failure);
            }

            if ($c_e_id = $this->addCategory($new_value)) {
                $assigned_category = new AssignedCategories();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $assigned_category->assigned_category_enc_id = $utilitiesModel->encrypt();
                $assigned_category->category_enc_id = $c_e_id->category_enc_id;
                $assigned_category->parent_enc_id = $parent_enc_id;
                $assigned_category->assigned_to = $type;
                $assigned_category->status = 'Pending';
                $assigned_category->created_on = date('Y-m-d H:i:s');
                $assigned_category->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
                $assigned_category->created_by = Yii::$app->user->identity->user_enc_id;
                if ($assigned_category->save()) {
                    $data = [];
                    $data['category_enc_id'] = $c_e_id->category_enc_id;
                    $data['name'] = $c_e_id->name;
                    return json_encode($data);
                }
            } else {
                return json_encode($failure);
            }

        } else {

            return json_encode($failure);
        }
    }

    private function alreadyHave($category_enc_id, $parent_enc_id)
    {
        $alreadyhave = AssignedCategories::find()
            ->where(['category_enc_id' => $category_enc_id])
            ->andWhere(['parent_enc_id' => $parent_enc_id])
            ->exists();

        return $alreadyhave;
    }

    private function addCategory($new_value)
    {

        $already_exists = Categories::find()
            ->select(['name', 'category_enc_id'])
            ->where(['name' => $new_value])
            ->one();

        if ($already_exists) {
            return $already_exists;
        } else {
            $new_category = new Categories();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $new_category->category_enc_id = $utilitiesModel->encrypt();
            $new_category->name = $new_value;
            $utilitiesModel->variables['name'] = $new_value;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $new_category->slug = $utilitiesModel->create_slug();
            $new_category->created_on = date('Y-m-d H:i:s');
            $new_category->created_by = Yii::$app->user->identity->user_enc_id;
            if ($new_category->save()) {
                return $new_category;
            }
        }

    }

    private function checkParent($parent_id, $type)
    {
        $check_parent = OrganizationAssignedCategories::find()
            ->where(['category_enc_id' => $parent_id])
            ->andWhere(['parent_enc_id' => NULL])
            ->andWhere(['assigned_to' => $type])
            ->andWhere(['organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['is_deleted' => 0])
            ->exists();

        return $check_parent;
    }

    public function actionSave()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $second_category_enc_id = Yii::$app->request->post('checked');
            $parent_enc_id = Yii::$app->request->post('parent_enc_id');
            $type = Yii::$app->request->post('type');

            $selected_values = [];

            $already_selected = $this->savedData($parent_enc_id, $type);
            foreach ($already_selected as $a) {
                array_push($selected_values, $a["category_enc_id"]);
            }

            $to_be_added = array_diff($second_category_enc_id, $selected_values);
            $to_be_deleted = array_diff($selected_values, $second_category_enc_id);

            if (!$this->checkParent($parent_enc_id, $type)) {
                $this->saveFirstCategory($parent_enc_id, $type);
            }

            $num = count($to_be_added);
            if ($num > 0) {
                foreach ($to_be_added as $add) {
                    $this->saveSecondCategory($add, $parent_enc_id, $type);
                }
            }

            $num = count($to_be_deleted);
            if ($num > 0) {
                foreach ($to_be_deleted as $del) {
                    $this->deleteData($del, $parent_enc_id, $type);
                }
            }

            $response = [

                'status' => 200
            ];

            return json_encode($response);
        }
    }

    private function deleteData($second_enc_id, $parent_enc_id, $type)
    {
        $toBeDeleted = OrganizationAssignedCategories::find()
            ->where(['parent_enc_id' => $parent_enc_id])
            ->andWhere(['category_enc_id' => $second_enc_id])
            ->andWhere(['organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['assigned_to' => $type])
            ->one();
        $toBeDeleted->is_deleted = 1;
        $toBeDeleted->update();
    }

    private function savedData($category_enc_id, $type)
    {
        $already_selected = OrganizationAssignedCategories::find()
            ->select(['category_enc_id'])
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['parent_enc_id' => $category_enc_id])
            ->andWhere(['assigned_to' => $type])
            ->andWhere(['is_deleted' => 0])
            ->asArray()
            ->all();
        return $already_selected;
    }

    private function saveFirstCategory($category_enc_id, $type)
    {
        $organization_a_c = new OrganizationAssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $organization_a_c->assigned_category_enc_id = $utilitiesModel->encrypt();
        $organization_a_c->category_enc_id = $category_enc_id;
        $organization_a_c->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
        $organization_a_c->assigned_to = $type;
        $organization_a_c->created_on = date('Y-m-d H:i:s');
        $organization_a_c->created_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->save();
    }

    private function saveSecondCategory($c_enc_id, $p_enc_id, $type)
    {
        $organization_a_c = new OrganizationAssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $organization_a_c->assigned_category_enc_id = $utilitiesModel->encrypt();
        $organization_a_c->category_enc_id = $c_enc_id;
        $organization_a_c->parent_enc_id = $p_enc_id;
        $organization_a_c->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
        $organization_a_c->assigned_to = $type;
        $organization_a_c->created_on = date('Y-m-d H:i:s');
        $organization_a_c->created_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $organization_a_c->save();
    }

    public function actionFinalData()
    {
        $type = Yii::$app->request->post('type');
        $selectedfields = OrganizationAssignedCategories::find()
            ->alias('a')
            ->select(['a.assigned_category_enc_id', 'b.name','b.category_enc_id', 'CONCAT("' . Url::to('@commonAssets/categories/svg/') . '", b.icon) icon'])
            ->joinWith(['categoryEnc b'], false)
            ->where(['a.assigned_to' => $type])
            ->andWhere(['a.organization_enc_id' => Yii::$app->user->identity->organization_enc_id, 'a.created_by' => Yii::$app->user->identity->user_enc_id])
            ->andWhere(['a.parent_enc_id' => NULL])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->all();

        return json_encode($selectedfields);
    }

    public function actionResumeType()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $selected_answer = Yii::$app->request->post('selected_answer');
            $company_name = Yii::$app->request->post('company_name');
            $link_type = Yii::$app->request->post('link_type');

            if ($link_type === 'company') {
                $company_name = Yii::$app->request->post('company_name');
            } else if($link_type === 'application'){
                $org = EmployerApplications::find()
                    ->alias('a')
                    ->select(['b.slug'])
                    ->joinWith(['organizationEnc b'])
                    ->where(['a.slug' => $company_name])
                    ->asArray()
                    ->one();

                $company_name = $org['slug'];
            }

            $data = OrganizationAssignedCategories::find()
                ->alias('a')
                ->select(['a.category_enc_id', 'c.name', 'a.assigned_category_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->where(['b.slug' => $company_name])
                ->andWhere(['a.assigned_to' => $selected_answer])
                ->andWhere(['a.parent_enc_id' => NULL])
                ->andWhere(['a.is_deleted' => 0])
                ->asArray()
                ->all();


            return json_encode($data);
        }
    }

    public function actionJobProfile()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $selected_answer = Yii::$app->request->post('selected_answer');
            $type = Yii::$app->request->post('type');
            $company_name = Yii::$app->request->post('company_name');
            $link_type = Yii::$app->request->post('link_type');

            if ($link_type === 'company') {
                $company_name = Yii::$app->request->post('company_name');
            } else if($link_type === 'application'){
                $org = EmployerApplications::find()
                    ->alias('a')
                    ->select(['b.slug'])
                    ->joinWith(['organizationEnc b'])
                    ->where(['a.slug' => $company_name])
                    ->asArray()
                    ->one();

                $company_name = $org['slug'];
            }

            $assigned_categories = OrganizationAssignedCategories::find()
                ->alias('a')
                ->select(['a.assigned_category_enc_id', 'c.name'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['b.slug' => $company_name])
                ->joinWith(['categoryEnc c'], false)
                ->andWhere(['a.assigned_to' => $type])
                ->andWhere(['a.parent_enc_id' => $selected_answer])
                ->andWhere(['a.is_deleted' => 0])
                ->asArray()
                ->all();
            $location = OrganizationLocations::find()
                ->alias('a')
                ->distinct()
                ->select(['c.name', 'c.city_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->joinWith(['cityEnc c'])
                ->where(['b.slug' => $company_name])
                ->andWhere(['a.is_deleted' => 0])
                ->asArray()
                ->all();
            $username = Yii::$app->user->identity->username;
            $data = [];
            $data['sub_categories'] = $assigned_categories;
            $data['location'] = $location;
            $data['username'] = $username;

            return json_encode($data);
        }
    }

    public function actionCandidateApplication()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $experience = $data['experience'];
            $job_title = $data['job_title'];
            $location = $data['locations'];

            switch ($experience) {

                case 'no':
                    $exp = 0;
                    break;

                case 'less than one':
                    $exp = 1;
                    break;

                case 'one':
                    $exp = 2;
                    break;

                case 'two to three':
                    $exp = 3;
                    break;

                case 'three to five':
                    $exp = 4;
                    break;

                case 'five to ten':
                    $exp = 5;
                    break;

                case 'ten to twenty':
                    $exp = 6;
                    break;

                case 'twenty above':
                    $exp = 7;
                    break;
            };

            $failure = [
                'message' => 201
            ];

            $success = [
                'message' => 200
            ];

            if ($applied_app_enc_id = $this->alreadyApplied()) {

                $alreadySelectedLocation = $this->getAlreadyAppliedLocation($applied_app_enc_id['applied_application_enc_id']);
                $selectedLocation = [];
                for ($i = 0; $i < count($alreadySelectedLocation); $i++) {
                    foreach ($alreadySelectedLocation[$i] as $c) {
                        array_push($selectedLocation, $c);
                    }
                }
                $to_be_added_location = array_diff($location, $selectedLocation);


                $alreadySelectedTitle = $this->getAlreadyAppliedTitle($applied_app_enc_id['applied_application_enc_id']);
                $selectedTitle = [];
                for ($i = 0; $i < count($alreadySelectedTitle); $i++) {
                    foreach ($alreadySelectedTitle[$i] as $c) {
                        array_push($selectedTitle, $c);
                    }
                }
                $to_be_added_title = array_diff($job_title, $selectedTitle);

                $updateExp = DropResumeApplications::find()
                    ->where(['applied_application_enc_id' => $applied_app_enc_id['applied_application_enc_id']])
                    ->one();
                $updateExp->experience = $exp;
                $updateExp->save();


                if (count($to_be_added_location) > 0) {
                    foreach ($to_be_added_location as $loc) {
                        if (!$this->dropResumeApplicationLocation($loc, $applied_app_enc_id['applied_application_enc_id'])) {
                            return json_encode($failure);
                        }
                    }
                }
                if (count($to_be_added_title) > 0) {
                    foreach ($to_be_added_title as $jt) {
                        if (!$this->dropResumeApplicationTitle($jt, $applied_app_enc_id['applied_application_enc_id'])) {
                            return json_encode($failure);
                        }
                    }
                }

                return json_encode($success);

            } else {

                if ($app_enc_id = $this->dropResumeApplications($exp)) {

                    if (count($location) > 0) {
                        foreach ($location as $loc) {
                            if (!$this->dropResumeApplicationLocation($loc, $app_enc_id)) {
                                return json_encode($failure);
                            }
                        }
                    }
                    foreach ($job_title as $jt) {
                        if (!$this->dropResumeApplicationTitle($jt, $app_enc_id)) {
                            return json_encode($failure);
                        }
                    }

                    return json_encode($success);
                }
            }

        }
    }

    private function alreadyApplied()
    {
        $user = Yii::$app->user->identity->user_enc_id;

        $alreadyApplied = DropResumeApplications::find()
            ->alias('a')
            ->select(['a.applied_application_enc_id'])
            ->where(['a.user_enc_id' => $user])
            ->andWhere(['a.status' => 0])
            ->asArray()
            ->one();

        return $alreadyApplied;
    }

    private function getAlreadyAppliedTitle($applied_app_enc_id)
    {
        $titles = DropResumeApplicationTitles::find()
            ->alias('a')
            ->select(['a.title'])
            ->where(['a.applied_application_enc_id' => $applied_app_enc_id])
            ->asArray()
            ->all();

        return $titles;
    }

    private function getAlreadyAppliedLocation($applied_app_enc_id)
    {
        $location = DropResumeApplicationLocations::find()
            ->alias('a')
            ->select(['a.city_enc_id'])
            ->where(['a.applied_application_enc_id' => $applied_app_enc_id])
            ->asArray()
            ->all();

        return $location;
    }

    private function dropResumeApplications($exp)
    {
        $d_r_applications = new DropResumeApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $d_r_applications->applied_application_enc_id = $utilitiesModel->encrypt();
        $d_r_applications->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $d_r_applications->experience = $exp;
        $d_r_applications->created_on = date('Y-m-d H:i:s');
        $d_r_applications->created_by = Yii::$app->user->identity->user_enc_id;
        $d_r_applications->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if ($d_r_applications->save()) {
            return $d_r_applications->applied_application_enc_id;
        }
    }

    private function dropResumeApplicationLocation($location, $applied_app_enc_id)
    {
        $d_r_a_locations = new DropResumeApplicationLocations();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $d_r_a_locations->applied_location_enc_id = $utilitiesModel->encrypt();
        $d_r_a_locations->applied_application_enc_id = $applied_app_enc_id;
        $d_r_a_locations->city_enc_id = $location;
        $d_r_a_locations->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $d_r_a_locations->created_on = date('Y-m-d H:i:s');
        $d_r_a_locations->created_by = Yii::$app->user->identity->user_enc_id;
        $d_r_a_locations->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if ($d_r_a_locations->save()) {
            return true;
        }
    }

    private function dropResumeApplicationTitle($job_title, $applied_app_enc_id)
    {
        $d_r_a_title = new DropResumeApplicationTitles();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $d_r_a_title->applied_title_enc_id = $utilitiesModel->encrypt();
        $d_r_a_title->applied_application_enc_id = $applied_app_enc_id;
        $d_r_a_title->title = $job_title;
        $d_r_a_title->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $d_r_a_title->created_on = date('Y-m-d H:i:s');
        $d_r_a_title->created_by = Yii::$app->user->identity->user_enc_id;
        $d_r_a_title->last_updated_by = Yii::$app->user->identity->user_enc_id;

        if ($d_r_a_title->save()) {
            return true;
        }
    }



}
