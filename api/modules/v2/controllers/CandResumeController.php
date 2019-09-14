<?php

namespace api\modules\v2\controllers;

use common\models\Cities;
use common\models\Skills;
use common\models\User;
use common\models\UserAccessTokens;
use common\models\UserEducation;
use common\models\Users;
use common\models\UserSkills;
use common\models\UserWorkExperience;
use Yii;
use common\models\Utilities;
use yii\filters\auth\HttpBearerAuth;

class CandResumeController extends ApiBaseController
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'fetch-details',
                'save-about',
                'save-qualification',
                'save-experience',
                'save-skills',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'fetch-details' => ['POST', 'OPTIONS'],
                'save-about' => ['POST', 'OPTIONS'],
                'save-qualification' => ['POST', 'OPTIONS'],
                'save-experience' => ['POST', 'OPTIONS'],
                'save-skills' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

//    public function actionAboutMe(){
//
//        if( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )
//        {
//            header("HTTP/1.1 202 Accepted");
//            exit;
//        }
//
//        $token_holder_id = UserAccessTokens::findOne([
//            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
//        ]);
//
//        $id = $token_holder_id->user_enc_id;
//
//        $u = Users::find()
//            ->select(['description'])
//            ->where([
//                'user_enc_id' => $id
//            ])
//            ->asArray()
//            ->one();
//
//    }

    public function actionSaveAbout()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);

        $id = $token_holder_id->user_enc_id;

        $about = Yii::$app->request->post('description');

        $users = Users::find()
            ->where(['user_enc_id' => $id])
            ->one();

        $users->description = $about;
        if ($users->update()) {
            return $this->response(200, ['status' => 200]);
        } else {
            print_r($users->getErrors());
        }
    }

    public function actionFetchDetails()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);

        $id = $token_holder_id->user_enc_id;

        $about = Users::find()
            ->select(['description'])
            ->where([
                'user_enc_id' => $id
            ])
            ->asArray()
            ->one();

        $experience = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.experience_enc_id id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current'])
//            ->innerJoin(Cities::tableName() . "b", "b.city_enc_id=a.city_enc_id")
            ->where(['a.created_by' => $id])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $education = UserEducation::find()
            ->where(['created_by' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        $skills = UserSkills::find()
            ->alias('a')
            ->select(['a.created_by', 'a.user_skill_enc_id', 'c.skill_enc_id', 'c.skill', 'a.created_on', 'a.is_deleted'])
            ->joinWith(['skillEnc c'], false)
            ->where(['a.created_by' => $id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        $data = [];
        $data['about'] = $about;
        $data['experience'] = $experience;
        $data['education'] = $education;
        $data['skills'] = $skills;

        return $this->response(200, $data);
    }

    public function actionSaveExperience()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);

        $id = $token_holder_id->user_enc_id;

        $req = Yii::$app->request->post();

        $from = Yii::$app->formatter->asDate($req['from'], 'yyyy-MM-dd');
        $to = Yii::$app->formatter->asDate($req['to'], 'yyyy-MM-dd');

        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $obj = new UserWorkExperience();
        $obj->experience_enc_id = $utilitiesModel->encrypt();
        $obj->user_enc_id = $id;
        $obj->title = $req['title'];
        $obj->company = $req['company'];
        $obj->from_date = $from;
        $obj->to_date = $to;
        $obj->created_on = date('Y-m-d H:i:s');
        $obj->created_by = $id;
        $obj->description = $req['description'];

        if ($obj->save()) {
            $experience = UserWorkExperience::find()
                ->alias('a')
                ->select(['a.experience_enc_id id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current'])
//                ->innerJoin(Cities::tableName() . "b", "b.city_enc_id=a.city_enc_id")
                ->where(['a.created_by' => $id])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();
            return $this->response(200, ['status' => 200, 'data' => $experience]);
        } else {
            return $this->response(500);
        }
    }

    public function actionSaveQualification()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);

        $id = $token_holder_id->user_enc_id;
        $req = Yii::$app->request->post();

        $utilities = new Utilities();
        $user_education_model = new UserEducation();
        $from = Yii::$app->formatter->asDate($req['from'], 'yyyy-MM-dd');
        $to = Yii::$app->formatter->asDate($req['to'], 'yyyy-MM-dd');

        $user_education_model->institute = $req['college'];
        $user_education_model->degree = $req['degree'];
        $user_education_model->from_date = $from;
        $user_education_model->to_date = $to;
        $user_education_model->created_by = $id;
        $user_education_model->user_enc_id = $id;
        $user_education_model->created_on = date('Y-m-d H:i:s');
        $utilities->variables['string'] = time() . rand(100, 100000);
        $user_education_model->education_enc_id = $utilities->encrypt();
        if (!$user_education_model->save()) {
            print_r($user_education_model->getErrors());
        }

        $education = UserEducation::find()
            ->where(['created_by' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'data' => $education]);
    }

    public function updateQualification($education_id)
    {
        $req = Yii::$app->request->post();
        $from = Yii::$app->formatter->asDate($req['qualification_from'], 'yyyy-MM-dd');
        $to = Yii::$app->formatter->asDate($req['qualification_to'], 'yyyy-MM-dd');
        $data = UserEducation::find()
            ->where(['education_enc_id' => $education_id])
            ->one();
        $data->institute = $req['school'];
        $data->degree = $req['degree'];
        $data->field = $req['field'];
        $data->from_date = $from;
        $data->to_date = $to;
        if (!$data->update()) {
            return false;
        }

        return true;
    }

    public function actionSkillRemove()
    {
        $req = Yii::$app->request->post();

        $skill_id = $req['skill_id'];
        $skill_rmv = UserSkills::findOne([
            'user_skill_enc_id' => $skill_id,
            'is_deleted' => 0
        ]);

        $skill_rmv->is_deleted = 1;
        if ($skill_rmv->update()) {
            return $this->response(200);
        } else {
            return $this->response(500);
        }
    }

    public function actionSaveSkills()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);

        $id = $token_holder_id->user_enc_id;

        $skills = Yii::$app->request->post('skills');

        //finding already saved skills
        $saved_skills = UserSkills::find()
            ->select(['skill_enc_id'])
            ->where(['created_by' => $id, 'is_deleted' => 0])
            ->asArray()
            ->all();

        $s_skill = [];
        foreach ($saved_skills as $s) {
            array_push($s_skill, $s['skill_enc_id']);
        }

        //get skill_enc_id of new added skills
        $model = new Skills();
        $new_skill_keys = [];
        foreach ($skills as $s) {
            if (empty($s['key'])) {
                $utilities = new Utilities();
                $utilities->variables['string'] = time() . rand(100, 100000);
                $model->skill_enc_id = $utilities->encrypt();
                $model->skill = $s['value'];
                $model->created_by = $id;
                $model->created_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    array_push($new_skill_keys, $model->skill_enc_id);
                }else{
                    print_r($model->getErrors());
                }
            } else {
                array_push($new_skill_keys, $s['key']);
            }
        }

        //check difference between skills
        $to_be_added_skills = array_diff($new_skill_keys, $s_skill);
        $to_be_deleted_skills = array_diff($s_skill, $new_skill_keys);

        //add skills to user skills table
        if(!empty($to_be_added_skills)){
            foreach ($to_be_added_skills as $skill){
                $model = new UserSkills();
                $utilities = new Utilities();
                $utilities->variables['string'] = time() . rand(100, 100000);
                $model->user_skill_enc_id = $utilities->encrypt();
                $model->skill_enc_id = $skill;
                $model->created_on = date('Y-m-d H:i:s');
                $model->created_by = $id;
                if(!$model->save()){
                    print_r($model->getErrors());
                }
            }
        }

        //remove skills from user skills table
        if(!empty($to_be_deleted_skills)){
            foreach ($to_be_deleted_skills as $d){
                $skill = UserSkills::find()
                    ->where(['skill_enc_id'=>$d,'created_by'=>$id])
                    ->one();

                $skill->is_deleted = 1;
                $skill->last_updated_by = $id;
                $skill->last_updated_on = date('Y-m-d H:i:s');

                if(!$skill->update()){
                    print_r($skill->getErrors());
                }

            }
        }

        $skills = UserSkills::find()
            ->alias('a')
            ->select(['a.created_by', 'a.user_skill_enc_id', 'c.skill_enc_id', 'c.skill', 'a.created_on', 'a.is_deleted'])
            ->joinWith(['skillEnc c'], false)
            ->where(['a.created_by' => $id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        return $this->response(200,['status'=>200,'skills'=>$skills]);

    }

}