<?php

namespace account\models\resumeBuilder;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\UserEducation;

class AddQualificationForm extends Model {

    public $school;
    public $degree;
    public $field;
    public $qualification_from;
    public $qualification_to;

    public function rules() {
        return [
            [['school', 'degree', 'field', 'qualification_from', 'qualification_to'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'school' => Yii::t('account', 'School'),
            'degree' => Yii::t('account', 'Degree'),
            'field' => Yii::t('account', 'Field of Study'),
            'qualification_from' => Yii::t('account', 'From Year'),
            'qualification_to' => Yii::t('account', 'To Year'),
        ];
    }
    
       public function save() {
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $utilitiesModel = new Utilities();
        $userEducationModel = new UserEducation();

        $userEducationModel->institute = $this->school;
        $userEducationModel->degree = $this->degree;
        $userEducationModel->from_date = $this->qualification_from;
        $userEducationModel->to_date = $this->qualification_to;
        $userEducationModel->field = $this->field;
        $userEducationModel->created_by = Yii::$app->user->identity->user_enc_id;
        $userEducationModel->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $userEducationModel->created_on = date('Y-m-d H:i:s');
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userEducationModel->education_enc_id = $utilitiesModel->encrypt();
        if (!$userEducationModel->validate() || !$userEducationModel->save()) {
            return $userEducationModel->getErrors();
        }
        return true;
    }

    public function update($id){

        if (!$this->validate()) {
            return $this->getErrors();
        }

        $data = UserEducation::find()
            ->where(['education_enc_id'=>$id])
            ->one();

        $data->institute = $this->school;
        $data->degree = $this->degree;
        $data->field = $this->field;
        $data->from_date = $this->qualification_from;
        $data->to_date = $this->qualification_to;

        if (!$data->validate() || !$data->update()) {
            return false;
        }
        return true;
    }


}
