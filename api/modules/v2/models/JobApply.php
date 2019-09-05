<?php

namespace api\modules\v2\models;

use api\modules\v1\models\Candidates;
use common\models\UserAccessTokens;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\AppliedApplications;
use common\models\AppliedApplicationLocations;
use common\models\EmployerApplications;
use common\models\InterviewProcessFields;
use common\models\AppliedApplicationProcess;

class JobApply extends Model
{
    public $id;
    public $check;
    public $resume_list;
    public $questionnaire_id;
    public $fill_question;
    public $location_pref;
    public $status;

    public function rules()
    {
        return [
            [['id', 'resume_file', 'status', 'check', 'resume_list', 'questionnaire_id', 'location_pref', 'fill_question'], 'required'],
        ];
    }

    public function saveValues()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        $appliedModel = new AppliedApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $appliedModel->applied_application_enc_id = $utilitiesModel->encrypt();
        $appliedModel->application_number = date('ymd') . time();
        $appliedModel->application_enc_id = $this->id;
//        $appliedModel->resume_enc_id = $this->resume_list;
        $appliedModel->status = $this->status;
        $appliedModel->created_on = date('Y-m-d h:i:s');
        $appliedModel->created_by = $user->user_enc_id;
        if ($appliedModel->save()) {
            if(count($this->location_pref) > 0) {
                foreach ($this->location_pref as $location) {
                    $locModel = new AppliedApplicationLocations;
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $locModel->application_location_enc_id = $utilitiesModel->encrypt();
                    $locModel->applied_application_enc_id = $appliedModel->applied_application_enc_id;
                    $locModel->city_enc_id = $location;
                    $locModel->created_on = date('Y-m-d h:i:s');
                    $locModel->created_by = $user->user_enc_id;
                    $app_id = $appliedModel->applied_application_enc_id;
                    $id = $this->id;
                    $user_enc_id = $user->user_enc_id;
                    if (!$locModel->save()) {
                        print_r($locModel->getErrors());
                    }
                }
            }
            $status = [
                'applied_application_enc_id' => $appliedModel->applied_application_enc_id,
            ];
            $this->save_process($id, $app_id, $user_enc_id);
            return $status;
        } else {
            return false;
        }
    }


    private function save_process($id, $app_id, $user_enc_id)
    {
        $process_list = EmployerApplications::find()
            ->alias('a')
            ->select(['b.field_name', 'b.field_enc_id'])
            ->where(['a.application_enc_id' => $id])
            ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.interview_process_enc_id = a.interview_process_enc_id')
            ->asArray()
            ->all();

        foreach ($process_list as $process) {
            $processModel = new AppliedApplicationProcess;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $processModel->process_enc_id = $utilitiesModel->encrypt();
            $processModel->applied_application_enc_id = $app_id;
            $processModel->field_enc_id = $process['field_e/nc_id'];
            $processModel->created_on = date('Y-m-d h:i:s');
            $processModel->created_by = $user_enc_id;
            if (!$processModel->save()) {
                return false;
            }
        }
    }
}