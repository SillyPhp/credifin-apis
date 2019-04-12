<?php

namespace frontend\models\campusAmbassador;

use common\models\Users;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Applications;
use common\models\ApplicationAnswers;

class CaApplicationForm extends Model
{

    public $qualification_id;
    public $college;
    public $state_id;
    public $city_id;
    public $answers;
    public $_flag;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['state_id', 'qualification_id', 'college', 'city_id', 'answers',], 'required'],
            [['college', 'city_id', 'answers',], 'trim'],
            [['state_id', 'qualification_id', 'college', 'city_id'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['college'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qualification_id' => Yii::t('frontend', 'Qualification'),
            'college' => Yii::t('frontend', 'School / College / University'),
            'state_id' => Yii::t('frontend', 'State'),
            'city_id' => Yii::t('frontend', 'City'),
            'answers' => Yii::t('frontend', 'Answer'),
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $update = Yii::$app->db->createCommand()
                ->update(Users::tableName(), ['city_enc_id' => $this->city_id], ['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->execute();
            if (!$update) {
                return false;
            }
            $utilitiesModel = new Utilities();
            $applicationsModel = new Applications();
            $applicationsModel->application_id = time();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $applicationsModel->application_enc_id = $utilitiesModel->encrypt();
            $applicationsModel->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $applicationsModel->qualification_enc_id = $this->qualification_id;
            $applicationsModel->college = $this->college;
            $applicationsModel->created_by = Yii::$app->user->identity->user_enc_id;
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