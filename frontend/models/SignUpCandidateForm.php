<?php

namespace frontend\models;

use common\models\Usernames;
use common\models\UserPreferences;
use common\models\UserPreferredJobProfile;
use common\models\UserPreferredLocations;
use common\models\Users;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use frontend\models\events\UserModel;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class SignUpCandidateForm extends Model
{

    public $email;
    public $username;
    public $new_password;
    public $confirm_password;
    public $first_name;
    public $last_name;
    public $job_profile;
    public $city;
    public $city_id;
    public $experience;
    public $salary;
    public $phone;
    public $countryCode;
    public $_flag;

    public function behaviors()
    {
        return [
            [
                'class' => PhoneInputBehavior::className(),
                'countryCodeAttribute' => 'countryCode',
            ],
        ];
    }

    public function formName(){
        return '';
    }

    public function rules()
    {
        return [
            [['email','username','new_password','confirm_password','first_name','last_name','job_profile','city','city_id'], 'required'],
            [['experience','salary','phone'], 'safe'],
            [['salary'], 'integer', 'min' => 1],
            [['email'], 'email'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'new_password', 'confirm_password'], 'trim'],
            [['username', 'email', 'first_name', 'last_name','phone', 'new_password', 'confirm_password'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['username'], 'string', 'length' => [3, 20]],
            [['new_password', 'confirm_password'], 'string', 'length' => [8, 20]],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            [['phone'], PhoneInputValidator::className()],
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password'],
            ['phone', 'unique', 'targetClass' => Users::className(), 'targetAttribute' => ['phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['email', 'unique', 'targetClass' => Users::className(), 'message' => 'This email address has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
            ];
    }
    public function save($profileJob,$cityJob,$salaryJob,$experienceJob,$cityJobId){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $userPreference = new UserPreferences();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userPreference->preference_enc_id = $utilitiesModel->encrypt();
            if($experienceJob){
            $userPreference->experience = $experienceJob;
            }
            if($salaryJob){
            $userPreference->salary = $salaryJob;
            }
            $userPreference->created_on = date('Y-m-d H:i:s');
            $userPreference->created_by =Yii::$app->user->identity->user_enc_id;
            if (!$userPreference->validate() || !$userPreference->save()) {
                $this->_flag = false;
                $transaction->rollBack();
                return false;
            } else {
                $this->_flag = true;
                $preference_id = $userPreference->preference_enc_id;
            }
            if($this->_flag){
                $userPreferredLocation = new UserPreferredLocations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $userPreferredLocation->preferred_location_enc_id = $utilitiesModel->encrypt();
                $userPreferredLocation->city_enc_id = $cityJobId;
                $userPreferredLocation->preference_enc_id = $preference_id;
                $userPreferredLocation->created_on = date('Y-m-d H:i:s');
                $userPreferredLocation->created_by =Yii::$app->user->identity->user_enc_id;
                if (!$userPreferredLocation->validate() || !$userPreferredLocation->save()) {
                    $this->_flag = false;
                    $transaction->rollBack();
                    return false;
                } else {
                    $this->_flag = true;
                }
            }
            if($this->_flag){
                $userPreferredJobProfile = new UserPreferredJobProfile();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $userPreferredJobProfile->preferred_job_profile_enc_id = $utilitiesModel->encrypt();
                $userPreferredJobProfile->job_profile_enc_id = $profileJob;
                $userPreferredJobProfile->preference_enc_id = $preference_id;
                $userPreferredJobProfile->created_on = date('Y-m-d H:i:s');
                $userPreferredJobProfile->created_by =Yii::$app->user->identity->user_enc_id;
                if (!$userPreferredJobProfile->validate() || !$userPreferredJobProfile->save()) {
                    $this->_flag = false;
                    $transaction->rollBack();
                    return false;
                } else {
                    $this->_flag = true;
                }
            }
            if($this->_flag){
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (Exception $e){
            $transaction->rollBack();
            return false;
        }
    }
}
