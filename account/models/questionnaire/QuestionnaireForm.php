<?php

namespace account\models\questionnaire;

use Yii;
use yii\base\Model;
use common\models\OrganizationQuestionnaire;
use common\models\QuestionnaireFields;
use common\models\QuestionnaireFieldOptions;
use common\models\Utilities;

class QuestionnaireForm extends Model
{

    public $formbuilderdata;
    public $formname;
    public $formusedcategory;

    public function rules()
    {
        return [
            [['formbuilderdata', 'formname', 'formusedcategory'], 'required']
        ];
    }

    public function formName()
    {
        return '';
    }

    public function add()
    {
        $utilitiesModel = new Utilities();
        $organizationQuestionnaireModel = new OrganizationQuestionnaire();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $organizationQuestionnaireModel->questionnaire_enc_id = $utilitiesModel->encrypt();
        $organizationQuestionnaireModel->questionnaire_name = $this->formname;
        $organizationQuestionnaireModel->questionnaire_for = json_encode($this->formusedcategory);
        $organizationQuestionnaireModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;

        $organizationQuestionnaireModel->created_on = date('Y-m-d H:i:s');
        $organizationQuestionnaireModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($organizationQuestionnaireModel->save()) {
            $quesionnaire_array = json_decode($this->formbuilderdata);
            $i = 1;

            foreach ($quesionnaire_array as $array) {
                $utilitiesModel = new Utilities();
                $questionnaireFieldsModel = new QuestionnaireFields();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $questionnaireFieldsModel->field_enc_id = $utilitiesModel->encrypt();
                $questionnaireFieldsModel->field_type = $array->type;
                $questionnaireFieldsModel->field_label = $array->label;
                $questionnaireFieldsModel->field_name = $array->name;
                $questionnaireFieldsModel->placeholder = $array->placeholder;
                if ($array->required == "required") {
                    $questionnaireFieldsModel->is_required = 1;
                } else {
                    $questionnaireFieldsModel->is_required = 0;
                }

                $questionnaireFieldsModel->sequence = $i;
                $questionnaireFieldsModel->questionnaire_enc_id = $organizationQuestionnaireModel->questionnaire_enc_id;
                $questionnaireFieldsModel->created_on = date('Y-m-d H:i:s');
                $questionnaireFieldsModel->created_by = Yii::$app->user->identity->user_enc_id;

                if (!$questionnaireFieldsModel->save()) {
                    return false;
                }
                if ($questionnaireFieldsModel->field_type == "radio" || $questionnaireFieldsModel->field_type == "select" || $questionnaireFieldsModel->field_type == "checkbox") {
                    foreach ($array->options as $options) {
                        $utilitiesModel = new Utilities();
                        $questionnaireFieldsOptionsModel = new QuestionnaireFieldOptions();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $questionnaireFieldsOptionsModel->field_option_enc_id = $utilitiesModel->encrypt();
                        $questionnaireFieldsOptionsModel->field_option = $options->option;
                        $questionnaireFieldsOptionsModel->field_enc_id = $questionnaireFieldsModel->field_enc_id;
                        $questionnaireFieldsOptionsModel->created_on = date('Y-m-d H:i:s');
                        $questionnaireFieldsOptionsModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$questionnaireFieldsOptionsModel->save()) {
                            return false;
                        }
                    }
                }
                $i++;
            }
            return true;
        }
    }

    public function getCloneData($qidk)
    {
        $fields = OrganizationQuestionnaire::find()
            ->alias('a')
            ->distinct()
            ->select(['a.questionnaire_enc_id', 'a.questionnaire_name', 'a.questionnaire_for'])
            ->where(['a.questionnaire_enc_id' => $qidk])
            ->joinWith(['questionnaireFields b' => function ($b) {
                $b->select(['b.questionnaire_enc_id', 'b.field_enc_id', 'b.field_type', 'b.field_label', 'b.field_name', 'b.sequence', 'b.placeholder']);
                $b->orderBy(['b.sequence' => SORT_ASC]);
                $b->groupBy(['b.field_enc_id']);
                $b->joinWith(['questionnaireFieldOptions c' => function ($b) {
                    $b->select(['c.field_enc_id', 'c.field_option']);
                }]);
            }])
            ->asArray()
            ->one();
        return $fields;
    }

}