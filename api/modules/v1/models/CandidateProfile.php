<?php

namespace api\modules\v1\models;

use common\models\UserAccessTokens;
use common\models\Users;
use common\models\Categories;
use common\models\Cities;
use common\models\UserSkills;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class CandidateProfile extends Model{
    public $first_name;
    public $last_name;
    public $job_profile;
    public $job_profile_id;
    public $exp_month;
    public $exp_year;
    public $dob;
    public $languages;
    public $skills;
    public $availability;
    public $description;
    public $state;
    public $city;

    public function formName(){
        return '';
    }

    public function rules(){
        return [
            [['job_profile', 'exp_month', 'exp_year', 'dob', 'languages', 'skills', 'availability', 'description', 'state', 'city', 'job_profile_id'], 'required'],
            ['exp_month', 'integer', 'max'=>12],
            ['exp_year', 'integer', 'max'=>99]
        ];
    }

    public function update(){

        if(empty($this->skills)){
            $this->skills = [];
        }

        if(empty($this->languages)){
            $this->languages = [];
        }

        $flag = 0;
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $usersModel = new Users();
        $user = $usersModel->find()
            ->where(['user_enc_id' => $candidate->user_enc_id])
            ->one();
        $user->dob = date('Y-m-d', strtotime($this->dob));
        $user->city_enc_id = $this->city;
        $user->is_available = $this->availability;
        $user->experience = json_encode([''.$this->exp_year.'',''.$this->exp_month.'']);
        $user->description = $this->description;
        $user->job_function = $this->job_profile_id;
        if($user->update()){
            $flag++;
        }
        $userSkills = UserSkills::find()
                    ->where(['created_by'=>$candidate->user_enc_id])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();
        $skillArray = ArrayHelper::getColumn($userSkills, 'skill_enc_id');
//        $skillsToAdd = array_merge(array_intersect($this->skills, $userSkills), array_diff($this->skills, $userSkills));
//        $skillsToDelete = array_diff($userSkills, array_intersect($userSkills, $this->skills));
        $new_skill = array_diff($this->skills, $skillArray);
        $delete_skill = array_diff($skillArray, $this->skills);
        if(!empty($new_skill)){
            foreach($new_skill as $val){
                $skillsModel = new UserSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time().rand(100, 100000);
                $skillsModel->user_skill_enc_id = $utilitiesModel->encrypt();
                $skillsModel->skill_enc_id = $val;
                $skillsModel->created_on = date('Y-m-d H:i:s');
                $skillsModel->created_by = $candidate->user_enc_id;
                if(!$skillsModel->save()){
                    return false;
                }else{
                    $flag++;
                }
            }
        }
        if(!empty($delete_skill)){
            foreach ($delete_skill as $val) {
                $update = Yii::$app->db->createCommand()
                    ->update(UserSkills::tableName(), [
                        'is_deleted' => 1,
                        'last_updated_on' => date('Y-m-d H:i:s'),
                        'last_updated_by' => $candidate->user_enc_id
                    ], [
                        'created_by' => $candidate->user_enc_id,
                        'skill_enc_id' => $val
                    ])
                    ->execute();
                if(!$update){
                    return false;
                }else{
                    $flag++;
                }
            }
        }
        $userLanguage = UserSpokenLanguages::find()
                        ->where(['created_by' => $candidate->user_enc_id])
                        ->andWhere(['is_deleted' => 0])
                        ->asArray()
                        ->all();
        $languageArray = ArrayHelper::getColumn($userLanguage, 'language_enc_id');
        $new_language = array_diff($this->skills, $languageArray);
        $delete_language = array_diff($languageArray, $this->languages);
        if(!empty($new_language)){
            foreach($new_language as $val){
                $languageModel = new UserSpokenLanguages();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $languageModel->user_language_enc_id = $utilitiesModel->encrypt();
                $languageModel->language_enc_id = $val;
                $languageModel->created_on = date('Y-m-d H:i:s');
                $languageModel->created_by = $candidate->user_enc_id;
                if(!$languageModel->save()){
                    return false;
                }else{
                    $flag++;
                }
            }
        }
        if(!empty($delete_language)){
            foreach($delete_language as $val){
                $update = Yii::$app->db->createCommand()
                        ->update(UserSpokenLanguages::tableName(),[
                            'is_deleted' => 1,
                            'last_updated_on' => date('Y-m-d H:i:s'),
                            'last_updated_by' => $candidate->user_enc_id
                        ], [
                            'created_by' => $candidate->user_enc_id,
                            'language_enc_id' => $val
                        ])
                        ->execute();
                if(!$update){
                    return false;
                }else{
                    $flag++;
                }
            }
        }

        if($flag == 0){
            return false;
        }else{
            return true;
        }
    }

    public function getJobFunction(){
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        if(!empty($candidate->job_function)){
            $getName = Categories::find()
                        ->select(['name', 'category_enc_id'])
                        ->where(['category_enc_id' => $candidate->job_function])
                        ->one();
            return $getName;
        }else{
            $getName = '';
            return $getName;
        }
    }

    public function getExperience(){
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        if(!empty($candidate->experience)){
            $getExperience = json_decode($candidate->experience);
            return $getExperience;
        }else{
            $getExperience = '';
            return $getExperience;
        }
    }

    public function getCurrentCity(){
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

    }
}

