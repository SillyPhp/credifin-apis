<?php

namespace api\modules\v2\controllers;

use common\models\Cities;
use common\models\User;
use common\models\UserEducation;
use common\models\Users;
use common\models\UserSkills;
use common\models\UserWorkExperience;
use Yii;
use common\models\Utilities;

class CandResumeController extends ApiBaseController{
    public function actionAboutMe($id){
        $u = Users::find()
            ->select(['description'])
            ->where([
                'user_enc_id' => $id
            ])
            ->asArray()
            ->one();

        return $this->response(200, $u);
    }

    public function actionSaveAbout($id, $about){
        $users = Users::find()
            ->where(['user_enc_id' => $id])
            ->one();

        $users->description = $about;
        $users->update();
    }

    public function actionFetchDetails($id){
        $experience = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.experience_enc_id', 'a.title', 'a.description', 'a.company', 'a.from_date', 'a.to_date', 'a.is_current', 'b.name city'])
            ->innerJoin(Cities::tableName() . "b", "b.city_enc_id=a.city_enc_id")
            ->where(['a.created_by'=>$id])
            ->orderBy(['a.id'=>SORT_DESC])
            ->asArray()
            ->all();

        $education = UserEducation::find()
            ->where(['created_by' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        $skills = UserSkills::find()
            ->alias('a')
            ->select(['a.created_by', 'a.user_skill_enc_id', 'c.skill_enc_id', 'c.skill', 'a.created_on', 'a.is_deleted', 'a.user_skill_enc_id'])
            ->joinWith(['skillEnc c'], false)
            ->where(['a.created_by'=>$id,'a.is_deleted'=>0])
            ->asArray()
            ->all();

        $data = [];
        $data['experience'] = $experience;
        $data['education'] = $education;
        $data['skills'] = $skills;

        return $this->response(200, $data);
    }

    public function actionSaveExperience($id){
        $req = Yii::$app->request->post();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $obj = new UserWorkExperience();
        $obj->experience_enc_id = $utilitiesModel->encrypt();
        $obj->user_enc_id = $id;
        $obj->title = $req['title'];
        $obj->company = $req['company'];
        $obj->city_enc_id = $req['city'];
        $obj->from_date = $req['from'];
        $obj->to_date = $req['to'];
        $obj->is_current = $req['checkbox'];
        $obj->created_on = date('Y-m-d H:i:s');
        $obj->created_by = $id;
        $obj->description = $req['description'];

        if(!$obj->save()){
            return $this->response(200);
        }else{
            return $this->response(500);
        }
    }

//    public function actionUpdateExperience(){
//        $req = Yii::$app->request->post();
//        $editexp = UserWorkExperience::find()
//            ->alias('a')
//            ->selecrt
//    }

    public function actionSaveQualification($id){
        $req = Yii::$app->request->post();

        $utilities = new Utilities();
        $user_education_model = new UserEducation();
        $from = Yii::$app->formatter->asDate($req['from'], 'yyyy-MM-dd');
        $to = Yii::$app->formatter->asDate($req['to'], 'yyyy-MM-dd');

        $user_education_model->institute = $req['school'];
        $user_education_model->degree = $req['degree'];
        $user_education_model->from_date = $from;
        $user_education_model->to_date = $to;
        $user_education_model->field = $req['field'];
        $user_education_model->created_by = $id;
        $user_education_model->user_enc_id = $id;
        $user_education_model->created_on = date('Y-m-d H:i:s');
        $utilities->variables['string'] = time() . rand(100, 100000);
        $user_education_model->education_enc_id = $utilities->encrypt();
        if(!$user_education_model->save()){
            return false;
        }

        return true;
    }

    public function updateQualification($education_id){
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
        if(!$data->update()){
            return false;
        }

        return true;
    }

    public function actionSkillRemove(){
        $req = Yii::$app->request->post();

        $skill_id= $req['skill_id'];
        $skill_rmv = UserSkills::findOne([
            'user_skill_enc_id' => $skill_id,
            'is_deleted' => 0
        ]);

        $skill_rmv->is_deleted = 1;
        if($skill_rmv->update()){
            return $this->response(200);
        }else{
            return $this->response(500);
        }
    }
}