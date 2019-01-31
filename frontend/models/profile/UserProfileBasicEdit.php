<?php
/**
 * Created by PhpStorm.
 * User: Sneh Kant
 * Date: 27-01-2019
 * Time: 00:25
 */
namespace frontend\models\profile;

use common\models\Users;
use common\models\Categories;
use common\models\Cities;
use Yii;
use yii\base\Model;
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
            return true;
        }
        else
        {
            return false;
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


}