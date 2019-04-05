<?php

namespace account\models\questionnaire;

use Yii;
use yii\base\Model;
use common\models\AnsweredQuestionnaire;
use common\models\AnsweredQuestionnaireFields;
use common\models\AppliedApplications;
use common\models\Utilities;


class QuestionnaireViewForm extends Model
{

    public $field;

    public function saveAnswer($applied_id, $data, $qidk)
    {
        $arr = json_decode($data);
        $utilitiesModel = new Utilities();
        $answeredModel = new AnsweredQuestionnaire();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $answeredModel->answered_questionnaire_enc_id = $utilitiesModel->encrypt();
        $answeredModel->applied_application_enc_id = $applied_id;
        $answeredModel->questionnaire_enc_id = $qidk;
        $answeredModel->created_on = date('Y-m-d H:i:s');
        $answeredModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($answeredModel->save()) {
            foreach ($arr as $array) {
                if ($array->type == 'checkbox') {
                    foreach ($array->option as $option) {
                        $utilitiesModel = new Utilities();
                        $fieldsModel = new AnsweredQuestionnaireFields;
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $fieldsModel->answer_enc_id = $utilitiesModel->encrypt();
                        $fieldsModel->answered_questionnaire_enc_id = $answeredModel->answered_questionnaire_enc_id;
                        $fieldsModel->field_enc_id = $array->id;
                        $fieldsModel->field_option_enc_id = $option;
                        $fieldsModel->created_on = date('Y-m-d H:i:s');
                        $fieldsModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$fieldsModel->save()) {
                            return false;
                        }
                    }
                }

                if ($array->type == 'select' || $array->type == 'radio') {
                    $utilitiesModel = new Utilities();
                    $fieldsModel = new AnsweredQuestionnaireFields;
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $fieldsModel->answer_enc_id = $utilitiesModel->encrypt();
                    $fieldsModel->answered_questionnaire_enc_id = $answeredModel->answered_questionnaire_enc_id;
                    $fieldsModel->field_enc_id = $array->id;
                    $fieldsModel->field_option_enc_id = $array->option;
                    $fieldsModel->created_on = date('Y-m-d H:i:s');
                    $fieldsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$fieldsModel->save()) {
                        return false;
                    }
                }
                if ($array->type == 'text' || $array->type == 'textarea' || $array->type == 'number' || $array->type == 'date' || $array->type == 'time') {

                    $utilitiesModel = new Utilities();
                    $fieldsModel = new AnsweredQuestionnaireFields;
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $fieldsModel->answer_enc_id = $utilitiesModel->encrypt();
                    $fieldsModel->answered_questionnaire_enc_id = $answeredModel->answered_questionnaire_enc_id;
                    $fieldsModel->field_enc_id = $array->id;
                    $fieldsModel->answer = $array->answer;
                    $fieldsModel->created_on = date('Y-m-d H:i:s');
                    $fieldsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$fieldsModel->save()) {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
        $update = Yii::$app->db->createCommand()
            ->update(AppliedApplications::tableName(), ['status' => 'Pending', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $applied_id])
            ->execute();
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
}
