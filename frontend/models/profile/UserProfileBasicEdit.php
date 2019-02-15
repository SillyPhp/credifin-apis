<?php
/**
 * Created by PhpStorm.
 * User: Sneh Kant
 * Date: 27-01-2019
 * Time: 00:25
 */
namespace frontend\models\profile;

use common\models\Skills;
use common\models\SpokenLanguages;
use common\models\UserPreferredSkills;
use common\models\Users;
use common\models\Categories;
use common\models\Cities;
use common\models\UserSkills;
use common\models\UserSpokenLanguages;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\Utilities;

class UserProfileBasicEdit extends Model {
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

    public function formName()
    {
        return '';
    }

    public function rules() {
        return [
            [['job_profile','exp_month','exp_year','dob','languages','skills','availability','description','state','city','job_profile_id'],'required'],
            ['exp_month','integer','max'=>12],
            ['exp_year','integer','max'=>99],
        ];
    }

    public function update()
    {
        $flag = 0;
        $usersModel = new Users();
        $user = $usersModel->find()
            ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->one();
        $user->dob = date('Y-m-d', strtotime($this->dob));
        $user->city_enc_id = $this->city;
        $user->is_available = $this->availability;
        $user->experience = json_encode([''.$this->exp_year.'',''.$this->exp_month.'']);
        $user->description = $this->description;
        $user->job_function = $this->job_profile_id;
        if ($user->update())
        {
            $flag++;
        }
        if (!empty($this->skills))
        {
            $skill_set = [];
            foreach ($this->skills as $val){
                $chk_skill = Skills::find()
                    ->distinct()
                    ->select(['skill_enc_id'])
                    ->where(['skill'=>$val])
                    ->asArray()
                    ->one();
                if (!empty($chk_skill))
                {
                    $skill_set[] = $chk_skill['skill_enc_id'];
                }
                else
                {
                    $skillsModel = new Skills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                    $skillsModel->skill = $val;
                    $skillsModel->created_on = date('Y-m-d H:i:s');
                    $skillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$skillsModel->save())
                    {
                        return false;
                    }
                    $skill_set[] = $skillsModel->skill_enc_id;
                }
            }
        }
        else
        {
            $skill_set = [];
        }
        $userSkills = UserSkills::find()
                         ->where(['created_by'=>Yii::$app->user->identity->user_enc_id])
                         ->andWhere(['is_deleted'=>0])
                         ->asArray()
                         ->all();
            $skillArray = ArrayHelper::getColumn($userSkills, 'skill_enc_id');
            $new_skill = array_diff($skill_set, $skillArray);
            $delet_skill = array_diff($skillArray, $skill_set);
            if (!empty($new_skill)) {
                foreach ($new_skill as $val) {
                    $skillsModel = new UserSkills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsModel->user_skill_enc_id= $utilitiesModel->encrypt();
                    $skillsModel->skill_enc_id = $val;
                    $skillsModel->created_on = date('Y-m-d H:i:s');
                    $skillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$skillsModel->save()) {
                       return false;
                    }
                    else
                    {
                        $flag++;
                    }
                }
            }
            if (!empty($delet_skill)) {
                foreach ($delet_skill as $val) {
                    $update = Yii::$app->db->createCommand()
                        ->update(UserSkills::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by'=>Yii::$app->user->identity->user_enc_id,'skill_enc_id'=>$val])
                        ->execute();
                    if (!$update) {
                        return false;
                    }
                    else
                    {
                        $flag++;
                    }
                }
            }
            if (!empty($this->languages)) {
                $language_set = [];
                foreach ($this->languages as $val) {
                    $chk_language = SpokenLanguages::find()
                        ->distinct()
                        ->select(['language_enc_id'])
                        ->where(['language' => $val])
                        ->asArray()
                        ->one();
                    if (!empty($chk_language))
                    {
                        $language_set[] = $chk_language['language_enc_id'];
                    }
                    else
                    {
                        $languageModel = new SpokenLanguages();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $languageModel->language_enc_id = $utilitiesModel->encrypt();
                        $languageModel->language = $val;
                        $languageModel->created_on = date('Y-m-d H:i:s');
                        $languageModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$languageModel->save())
                        {
                            return false;
                        }
                        $language_set[] = $languageModel->language_enc_id;
                    }

                }
            }
            else
            {
                $language_set = [];
            }
            $userLanguage = UserSpokenLanguages::find()
                           ->where(['created_by'=>Yii::$app->user->identity->user_enc_id])
                           ->andWhere(['is_deleted'=>0])
                           ->asArray()
                           ->all();
            $languageArray = ArrayHelper::getColumn($userLanguage, 'language_enc_id');
            $new_language = array_diff($language_set, $languageArray);
            $delte_language = array_diff($languageArray, $language_set);

            if (!empty($new_language)) {
                foreach ($new_language as $val) {
                    $languageModel = new UserSpokenLanguages();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $languageModel->user_language_enc_id= $utilitiesModel->encrypt();
                    $languageModel->language_enc_id = $val;
                    $languageModel->created_on = date('Y-m-d H:i:s');
                    $languageModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$languageModel->save()) {
                        return false;
                    }
                    else
                    {
                        $flag++;
                    }
                }
            }

            if (!empty($delte_language)) {
                foreach ($delte_language as $val) {
                    $update = Yii::$app->db->createCommand()
                        ->update(UserSpokenLanguages::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by'=>Yii::$app->user->identity->user_enc_id,'language_enc_id'=>$val])
                        ->execute();
                    if (!$update) {
                        return false;
                    }
                    else
                    {
                        $flag++;
                    }
                }
            }

            if ($flag==0)
            {
                return false;
            }
            else
            {
                return true;
            }
    }

    public function getJobFunction()
    {
        if (!empty(Yii::$app->user->identity->job_function))
        {
            $getName = Categories::find()->select(['name','category_enc_id'])->where(['category_enc_id'=>Yii::$app->user->identity->job_function])->one();
            return $getName;
        }
        else
        {
            $getName = '';
            return $getName;
        }
    }
    public function getExperience()
    {
        if (!empty(Yii::$app->user->identity->experience))
        {
            $getExperience = json_decode(Yii::$app->user->identity->experience);
            return $getExperience;
        }
        else
        {
            $getExperience = '';
            return $getExperience;
        }
    }
    public function getCurrentCity()
    {
        if (!empty(Yii::$app->user->identity->city_enc_id))
        {
            $getCurrentCity = Cities::find()->alias('a')->select(['a.city_enc_id','a.name city_name','b.name state_name','b.state_enc_id'])->joinWith(['stateEnc b'],false)->where(['city_enc_id'=>Yii::$app->user->identity->city_enc_id])->asArray()->one();
            return $getCurrentCity;
        }
        else
        {
            $getCurrentCity = '';
            return $getCurrentCity;
        }
    }

    public function getUserSkills()
    {
        $getSkills = UserSkills::find()
            ->alias('a')
            ->select(['a.skill_enc_id','b.skill'])
            ->where(['a.created_by'=>Yii::$app->user->identity->user_enc_id])
            ->andWhere(['a.is_deleted'=>0])
            ->joinWith(['skillEnc b'],false)
            ->asArray()
            ->all();
        return $getSkills;
    }

    public function getUserlanguages()
    {
        $languages = UserSpokenLanguages::find()
            ->alias('a')
            ->select(['a.language_enc_id','b.language'])
            ->where(['a.created_by'=>Yii::$app->user->identity->user_enc_id])
            ->andWhere(['a.is_deleted'=>0])
            ->joinWith(['languageEnc b'],false)
            ->asArray()
            ->all();
        return $languages;
    }


}