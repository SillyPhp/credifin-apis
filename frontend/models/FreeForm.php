<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;
use common\models\Utilities;
use common\models\UserWorkExperience;
use common\models\UserEducation;
use common\models\UserTypes;

class FreeForm extends Model {

    public $first_name;
    public $last_name;
    public $job_functions;
    public $email;
    public $city;
    public $city_main;
    public $phone;
    public $address;
    public $school;
    public $field;
    public $degree;
    public $from_degree;
    public $to_degree;
    public $company;
    public $experience_cities;
    public $experience_city_main;
    public $title;
    public $summary;
    public $currently;
    public $date_from;
    public $date_to;
    public $description;
    public $username;
    public $password;
    public $confirm_password;

//    public $user_type;

    public function rules() {
        return [
            [['first_name', 'last_name', 'job_functions', 'email', 'city', 'experience_cities', 'experience_city_main', 'phone', 'address', 'school', 'field', 'degree', 'from_degree', 'to_degree', 'date_from', 'date_to', 'username', 'password', 'confirm_password'], 'required'],
            [['first_name', 'last_name', 'job_functions', 'email', 'phone', 'address', 'school', 'field', 'degree', 'company', 'title', 'summary', 'description'], 'trim'],
            [['email'], 'email'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            ['email', 'unique', 'targetClass' => Users::className(), 'message' => 'This email address has already been used.'],
            ['phone', 'unique', 'targetClass' => Users::className(), 'targetAttribute' => ['phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['username', 'unique', 'targetClass' => Users::className(), 'message' => 'This username has already been taken.'],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'first_name' => Yii::t('frontend', 'First Name'),
            'last_name' => Yii::t('frontend', 'Last Name'),
            'email' => Yii::t('frontend', 'Email'),
            'phone' => Yii::t('frontend', 'Phone'),
            'job_functions' => Yii::t('frontend', 'Job Functions'),
            'address' => Yii::t('frontend', 'Address'),
            'school' => Yii::t('frontend', 'University or Institute'),
            'summary' => Yii::t('frontend', 'Summary'),
            'description' => Yii::t('frontend', 'Tell us more about yourself'),
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $usersModel = new Users();
        $utilitiesModel = new Utilities();
        $userWorkExperienceModel = new UserWorkExperience();
        $userEducationModel = new UserEducation();
        $userTypesModel = new UserTypes();
        $user_type = $userTypesModel->findOne([
            'user_type' => Individual,
        ]);
        $usersModel->first_name = $this->first_name;
        $usersModel->last_name = $this->last_name;
        $usersModel->username = $this->username;
        $usersModel->email = $this->email;
        $usersModel->phone = $this->phone;
        $usersModel->city_enc_id = $this->city_main;
        $usersModel->address = $this->address;
        $usersModel->job_function = $this->job_functions;
        if (!empty($this->description)) {
            $usersModel->description = $this->description;
        } else {
            $usersModel->description = NULL;
        }
        $utilitiesModel->variables['password'] = $this->password;
        $usersModel->password = $utilitiesModel->encrypt_pass();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $usersModel->user_enc_id = $utilitiesModel->encrypt();
        $usersModel->user_type_enc_id = $user_type->user_type_enc_id;
        $usersModel->auth_key = Yii::$app->security->generateRandomString();
        if (!$usersModel->validate() || !$usersModel->save()) {
            return $usersModel->getErrors();
        }

        $userEducationModel->institute = $this->school;
        $userEducationModel->degree = $this->degree;
        $userEducationModel->from_date = $this->from_degree;
        $userEducationModel->to_date = $this->to_degree;
        $userEducationModel->field = $this->field;
        $userEducationModel->created_by = $usersModel->user_enc_id;
        $userEducationModel->user_enc_id = $usersModel->user_enc_id;
        $userEducationModel->created_on = date('Y-m-d H:i:s');
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userEducationModel->education_enc_id = $utilitiesModel->encrypt();
        if (!$userEducationModel->validate() || !$userEducationModel->save()) {
            return $userEducationModel->getErrors();
        }

        $userWorkExperienceModel->title = $this->title;
        $userWorkExperienceModel->company = $this->company;
        $userWorkExperienceModel->from_date = $this->date_from;
        $userWorkExperienceModel->to_date = $this->date_to;
        $userWorkExperienceModel->description = $this->summary;
        $userWorkExperienceModel->created_by = $usersModel->user_enc_id;
        $userWorkExperienceModel->user_enc_id = $usersModel->user_enc_id;
        $userWorkExperienceModel->city_enc_id = $this->experience_city_main;
        $userWorkExperienceModel->created_on = date('Y-m-d H:i:s');
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userWorkExperienceModel->experience_enc_id = $utilitiesModel->encrypt();
        if (!$userWorkExperienceModel->validate() || !$userWorkExperienceModel->save()) {
            return $userWorkExperienceModel->getErrors();
        }
        return true;
    }

}
