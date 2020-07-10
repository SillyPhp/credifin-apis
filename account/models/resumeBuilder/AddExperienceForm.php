<?php

namespace account\models\resumeBuilder;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\UserWorkExperience;

class AddExperienceForm extends Model {

    public $title;
    public $company;
    public $location;
    public $exp_from;
    public $exp_to;
    public $present;
    public $description;
    public $city_id;
    public $salary;
    public $ctc;

    public function rules() {
        return [
            [['location', 'company', 'title', 'exp_from', 'city_id', 'description'], 'required'],
            [['salary', 'ctc'], 'integer'],
//            ['present', 'boolean'],
            [['company'], 'string', 'max' => 50],
            [
                ['exp_to'], 'required', 'when' => function ($model, $attribute) {
                    return $model->present == 0;
                }, 'whenClient' => "function (attribute, value) {
                        return $('input[name=\"AddExperienceForm[present][]\"]').val() == 0;
                }"
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'title' => Yii::t('account', 'Title'),
            'company' => Yii::t('account', 'Company'),
            'location' => Yii::t('account', 'Location'),
            'exp_from' => Yii::t('account','Experience From'),
            'exp_to' => Yii::t('account','Experience To')
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $utilitiesModel = new Utilities();
        $userWorkExperienceModel = new UserWorkExperience();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userWorkExperienceModel->experience_enc_id = $utilitiesModel->encrypt();
        $userWorkExperienceModel->title = $this->title;
        $userWorkExperienceModel->company = $this->company;
        $userWorkExperienceModel->from_date = $this->exp_from;
        $userWorkExperienceModel->to_date = $this->exp_to;
        $userWorkExperienceModel->description = $this->description;
        $userWorkExperienceModel->city_enc_id = $this->city_id;
        $userWorkExperienceModel->created_on = date('Y-m-d H:i:s');
        $userWorkExperienceModel->created_by = Yii::$app->user->identity->user_enc_id;
        $userWorkExperienceModel->user_enc_id = Yii::$app->user->identity->user_enc_id;
        if (!$userWorkExperienceModel->validate() || !$userWorkExperienceModel->save()) {
            print_r($userWorkExperienceModel->getErrors());
        }

        $utilitiesModel = new Utilities();
        $userWorkExperienceModel = new UserWorkExperience();
        return true;
    }

}
