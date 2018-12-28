<?php

namespace account\models\processes;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\OrganizationInterviewProcess;
use common\models\InterviewProcessFields;

class InterviewProcess extends Model {

    public $title;
    public $process_data;
    public $process_validate;

    public function formName() {
        return '';
    }

    public function rules() {
        return [
            [['process_data', 'title', 'process_validate'], 'required'],
        ];
    }

    public function save() {
        $utilitiesModel = new Utilities();
        $interviewModel = new OrganizationInterviewProcess;
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $interviewModel->interview_process_enc_id = $utilitiesModel->encrypt();
        $interviewModel->process_name = $this->title;
        $interviewModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $interviewModel->created_on = date('Y-m-d H:i:s');
        $interviewModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($interviewModel->save()) {
            $process_array = json_decode($this->process_data);
            $i = 1;
            foreach ($process_array as $array) {
                $utilitiesModel = new Utilities();
                $interviewFieldsModel = new InterviewProcessFields;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $interviewFieldsModel->field_enc_id = $utilitiesModel->encrypt();
                $interviewFieldsModel->field_label = $array->label;
                $interviewFieldsModel->field_name = $array->name;
                $interviewFieldsModel->field_type = $array->name;
                $interviewFieldsModel->help_text = $array->help_text;
                $interviewFieldsModel->icon = $array->icon;
                $interviewFieldsModel->sequence = $i;
                $interviewFieldsModel->interview_process_enc_id = $interviewModel->interview_process_enc_id;
                $interviewFieldsModel->created_on = date('Y-m-d H:i:s');
                $interviewFieldsModel->created_by = Yii::$app->user->identity->user_enc_id;

                if (!$interviewFieldsModel->save()) {
                    return false;
                }
                $i++;
            }

            return true;
        }
    }

}
