<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Applications;
use common\models\ApplicationAnswers;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

class CAApplicationForm extends Model
{

    public $first_name;
    public $last_name;
    public $email;
    public $contact;
    public $qualification_enc_id;
    public $college;
    public $state_enc_id;
    public $city_enc_id;
    public $answers;

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
            [['first_name', 'last_name', 'email', 'state_enc_id', 'qualification_enc_id', 'college', 'city_enc_id', 'contact', 'answers'], 'required'],
            [['first_name', 'last_name', 'email', 'contact', 'college', 'answers'], 'trim'],
            [['first_name', 'last_name', 'email', 'state_enc_id', 'qualification_enc_id', 'college', 'city_enc_id', 'contact',],  'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['email', 'college'], 'string', 'max' => 50],
            [['contact'], 'string', 'max' => 15],
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
            'email' => Yii::t('frontend', 'Email'),
            'contact' => Yii::t('frontend', 'Phone Number'),
            'qualification_enc_id' => Yii::t('frontend', 'Qualification'),
            'college' => Yii::t('frontend', 'School / College / University'),
            'state_enc_id' => Yii::t('frontend', 'State'),
            'city_enc_id' => Yii::t('frontend', 'City'),
            'answers' => Yii::t('frontend', 'Answer'),
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $applicationsModel = new Applications();
        $applicationAnswersModel = new ApplicationAnswers();
        $utilitiesModel = new Utilities();
        $applicationsModel->application_id = time();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $applicationsModel->application_enc_id = $utilitiesModel->encrypt();
        $applicationsModel->first_name = $this->first_name;
        $applicationsModel->last_name = $this->last_name;
        $applicationsModel->email = $this->email;
        $applicationsModel->contact = $this->contact;
        $applicationsModel->qualification_enc_id = $this->qualification_enc_id;
        $applicationsModel->college = $this->college;
        $applicationsModel->city_enc_id = $this->city_enc_id;
        if (!$applicationsModel->validate() || !$applicationsModel->save()) {
            return false;
        }
        $answers = $this->answers;
        foreach ($answers as $field => $value) {
            $this->answers = 'NULL';
            if (!empty($value)) {
                $applicationAnswersModel->application_enc_id = $applicationsModel->application_enc_id;
                $applicationAnswersModel->application_question_enc_id = $field;
                $applicationAnswersModel->answer = $value;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $applicationAnswersModel->application_answer_enc_id = $utilitiesModel->encrypt();
                if ($applicationAnswersModel->validate() && $applicationAnswersModel->save()) {
                    $applicationAnswersModel = new ApplicationAnswers();
                } else {
                    return false;
                }
            }
        }
        return true;
    }


}
