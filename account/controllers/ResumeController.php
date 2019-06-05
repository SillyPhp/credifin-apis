<?php

namespace account\controllers;



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
use account\models\resume\ResumeAddress;
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
        $ResumeAddress = new ResumeAddress();

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
            'ResumeInterests'=>$ResumeInterests,
            'ResumeAddress'=>$ResumeAddress
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
       $ResumeAddress = new ResumeAddress();
//        $sociallinks = new SocialLinks();
        $user = Users::find()
            ->where(['user_enc_id'=> Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->one();


        $resumeaddress= Users::find()
            ->where(['user_enc_id'=>Yii::$app->user->identity->user_enc_id])
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
            ->where(['created_by'=>Yii::$app->user->identity->user_enc_id,'is_deleted'=>0])
            ->asArray()
            ->all();

        $hobbies = UserHobbies::find()
            ->where(['created_by'=>Yii::$app->user->identity->user_enc_id,'is_deleted'=>0])
            ->asArray()
            ->all();

        $interests = UserInterests::find()
            ->where(['created_by'=>Yii::$app->user->identity->user_enc_id,'is_deleted'=>0])
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
            'ResumeAddress'=>$ResumeAddress,
            'experience' => $experience,
            'education' => $education,
            'skillist' => $skillist,
            'achieve' =>$achieve,
            'hobbies'=>$hobbies,
             'interests'=>$interests,
             'resumeaddress'=>$resumeaddress
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

    public function actionAchievermv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');

            $task = UserAchievements::find()
                ->where(['user_achievement_enc_id' => $id,'is_deleted'=>0])
                ->one();

            $task->is_deleted = 1;
            if ($task->update()) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function actionHobbiesrmv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

      if(Yii::$app->request->isAjax) {
          $id = Yii::$app->request->post('id');
          $task = UserHobbies::find()
              ->where(['user_hobby_enc_id' => $id])
              ->one();

          $task->is_deleted = 1;
          if ($task->update()) {
              return true;
          } else {
              return false;
          }
      }
    }

    public function actionInterestsrmv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if(Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');

            $task = UserInterests::find()
                ->where(['user_interest_enc_id' => $id, 'is_deleted' => 0])
                ->one();

            $task->is_deleted = 1;
            if ($task->update()) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Hobbies has been deleted.',
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

    public function actionAddress()
    {
        $model =  new ResumeAddress();
        if($model->load(Yii::$app->request->post()))
        {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $obj =  Users::find()->alias('a')->where([user_enc_id=>Yii::$app->user->identity->user_enc_id])->one();

           /* print_r($obj);
            exit;*/

           $obj->address = $model->address;

            if(!$obj->save())
            {
                print_r($obj->getErrors());
            }
            else{
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
            $obj->created_on = date('Y-m-d h:i:s');
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
            $obj->created_on = date('Y-m-d h:i:s');
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

   /* public function actionExperiences()
    {
        $id = 'p01dY3DbQyRnRMQxvwxNyMg8j9BwrO';
        $data = UserSkills::find()->alias('a')->where(['a.user_enc_id'=>$id])->asArray()->all();
        print_r($data);
        exit;
    }*/
}
