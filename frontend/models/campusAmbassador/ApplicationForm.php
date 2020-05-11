<?php

namespace frontend\models\campusAmbassador;

use common\models\ApplicationTypes;
use common\models\Usernames;
use common\models\UserTypes;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\RandomColors;
use common\models\Applications;
use common\models\ApplicationAnswers;
use common\models\Users;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

class ApplicationForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $qualification_id;
    public $college;
    public $state_id;
    public $city_id;
    public $countryCode;
    public $answers;
    public $username;
    public $password;
    public $confirm_password;
    public $_flag;

    public function formName()
    {
        return '';
    }

    public function behaviors()
    {
        return [
            [
                'class' => PhoneInputBehavior::className(),
                'countryCodeAttribute' => 'countryCode',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'state_id', 'qualification_id', 'college', 'city_id', 'phone', 'answers', 'username', 'password', 'confirm_password'], 'required'],
            [['first_name', 'last_name', 'email', 'phone', 'college', 'city_id', 'answers', 'username', 'password', 'confirm_password'], 'trim'],
            [['first_name', 'last_name', 'email', 'state_id', 'qualification_id', 'college', 'city_id', 'phone', 'username'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['username'], 'string', 'length' => [3, 20]],
            [['password', 'confirm_password'], 'string', 'length' => [8, 20]],
            [['email'], 'email'],
            [['username'], 'match', 'pattern' => '/^[a-z]\w*$/i'],
            [['phone'], PhoneInputValidator::className()],
            [['email', 'college'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
            ['email', 'unique', 'targetClass' => Users::className(), 'message' => 'This email address has already been used.'],
            ['phone', 'unique', 'targetClass' => Users::className(), 'targetAttribute' => ['phone' => 'phone'], 'message' => 'This phone number has already been used.'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('frontend', 'First Name'),
            'last_name' => Yii::t('frontend', 'Last Name'),
            'username' => Yii::t('frontend', 'Username'),
            'password' => Yii::t('frontend', 'Password'),
            'confirm_password' => Yii::t('frontend', 'Confirm Password'),
            'email' => Yii::t('frontend', 'Email'),
            'phone' => Yii::t('frontend', 'Phone Number'),
            'qualification_id' => Yii::t('frontend', 'Qualification'),
            'college' => Yii::t('frontend', 'School / College / University'),
            'state_id' => Yii::t('frontend', 'State'),
            'city_id' => Yii::t('frontend', 'City'),
            'answers' => Yii::t('frontend', 'Answer'),
        ];
    }

    public function save($type)
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $user_type = UserTypes::findOne([
            'user_type' => 'Individual',
        ]);

        if (!$user_type) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $app_type_id = ApplicationTypes::findOne(['name' => $type])['application_type_enc_id'];

            $usernamesModel = new Usernames();
            $usernamesModel->username = $this->username;
            $usernamesModel->assigned_to = 1;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                $transaction->rollBack();
                return false;
            } else {
                $this->_flag = true;
            }
            $usersModel = new Users();
            $utilitiesModel = new Utilities();
            $usersModel->username = $usernamesModel->username;
            $usersModel->first_name = $this->first_name;
            $usersModel->last_name = $this->last_name;
            $usersModel->email = $this->email;
            $usersModel->phone = $this->phone;
            $usersModel->initials_color = RandomColors::one();
            $utilitiesModel->variables['password'] = $this->password;
            $usersModel->password = $utilitiesModel->encrypt_pass();
            $usersModel->user_type_enc_id = $user_type->user_type_enc_id;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $usersModel->user_enc_id = $utilitiesModel->encrypt();
            $usersModel->auth_key = Yii::$app->security->generateRandomString();
            $usersModel->city_enc_id = $this->city_id;
            $usersModel->status = 'Active';
            if (!$usersModel->validate() || !$usersModel->save()) {
                $transaction->rollBack();
                return false;
            } else {
                $this->_flag = true;
            }
            $applicationsModel = new Applications();
            $applicationsModel->application_id = time();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $applicationsModel->application_enc_id = $utilitiesModel->encrypt();
            $applicationsModel->application_type_enc_id = $app_type_id;
            $applicationsModel->user_enc_id = $usersModel->user_enc_id;
            $applicationsModel->qualification_enc_id = $this->qualification_id;
            $applicationsModel->college = $this->college;
            $applicationsModel->created_by = $usersModel->user_enc_id;
            if (!$applicationsModel->validate() || !$applicationsModel->save()) {
                $transaction->rollBack();
                return false;
            } else {
                $this->_flag = true;
            }
            $applicationAnswersModel = new ApplicationAnswers();
            $answers = $this->answers;
            foreach ($answers as $field => $value) {
                $this->answers = 'NULL';
                if (!empty($value)) {
                    $applicationAnswersModel->application_enc_id = $applicationsModel->application_enc_id;
                    $applicationAnswersModel->application_question_enc_id = $field;
                    $applicationAnswersModel->answer = $value;
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationAnswersModel->application_answer_enc_id = $utilitiesModel->encrypt();
                    if (!$applicationAnswersModel->validate() || !$applicationAnswersModel->save()) {
                        $transaction->rollBack();
                        return false;
                    } else {
                        $applicationAnswersModel = new ApplicationAnswers();
                        $this->_flag = true;
                    }
                }
            }
            if ($this->_flag) {
                $transaction->commit();
            }

        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        if ($this->_flag) {
            return true;
        } else {
            return false;
        }

    }

}