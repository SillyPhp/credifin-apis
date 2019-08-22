<?php

namespace frontend\models\applications;

use frontend\models\referral\RefferalJobAppliedTracking;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\UserResume;
use common\models\AppliedApplications;
use common\models\AppliedApplicationLocations;
use common\models\EmployerApplications;
use common\models\InterviewProcessFields;
use common\models\AppliedApplicationProcess;

class JobApplied extends Model
{
    public $resume_file;
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
            [['resume_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx,pdf,png,jpg,jpeg','maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function upload()
    {
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userResumeModel = new UserResume();
        $userResumeModel->resume_enc_id = $utilitiesModel->encrypt();
        $userResumeModel->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $userResumeModel->resume_location = Yii::$app->getSecurity()->generateRandomString();
        $base_path = Yii::$app->params->upload_directories->resume->file_path . $userResumeModel->resume_location;
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userResumeModel->resume = $utilitiesModel->encrypt() . '.' . $this->resume_file->extension;
        $userResumeModel->title = $this->resume_file->baseName . '.' . $this->resume_file->extension;
        $userResumeModel->alt = $this->resume_file->baseName . '.' . $this->resume_file->extension;
        $userResumeModel->created_on = date('Y-m-d H:i:s');
        $userResumeModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!is_dir($base_path)) {
            if (mkdir($base_path, 0755, true)) {
                if ($this->resume_file->saveAs($base_path . DIRECTORY_SEPARATOR . $userResumeModel->resume)) {
                    if ($userResumeModel->validate() && $userResumeModel->save()) {
                        $appliedModel = new AppliedApplications();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $appliedModel->applied_application_enc_id = $utilitiesModel->encrypt();
                        $appliedModel->application_number = date('ymd') . time();
                        $appliedModel->application_enc_id = $this->id;
                        $appliedModel->status = $this->status;
                        $appliedModel->resume_enc_id = $userResumeModel->resume_enc_id;
                        $appliedModel->created_on = date('Y-m-d H:i:s');
                        $appliedModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if ($appliedModel->save()) {
                            if (!empty($this->location_pref)) {
                                foreach (json_decode($this->location_pref) as $location) {
                                    $locModel = new AppliedApplicationLocations;
                                    $utilitiesModel = new Utilities();
                                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                                    $locModel->application_location_enc_id = $utilitiesModel->encrypt();
                                    $locModel->applied_application_enc_id = $appliedModel->applied_application_enc_id;
                                    $locModel->city_enc_id = $location;
                                    $locModel->created_on = date('Y-m-d H:i:s');
                                    $locModel->created_by = Yii::$app->user->identity->user_enc_id;
                                    $app_id = $appliedModel->applied_application_enc_id;
                                    $id = $this->id;
                                    if (!$locModel->save()) {
                                       return false;
                                    }
                                }
                            }
                            $status = [
                                'status' => true,
                                'aid' => $appliedModel->applied_application_enc_id,
                            ];
                            $this->save_process($id, $app_id);
                            RefferalJobAppliedTracking::widget(['job_applied_id' => $appliedModel->applied_application_enc_id]);
                            return $status;

                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

    }

    public function saveValues()
    {
        $appliedModel = new AppliedApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $appliedModel->applied_application_enc_id = $utilitiesModel->encrypt();
        $appliedModel->application_number = date('ymd') . time();
        $appliedModel->application_enc_id = $this->id;
        $appliedModel->resume_enc_id = $this->resume_list;
        $appliedModel->status = $this->status;
        $appliedModel->created_on = date('Y-m-d H:i:s');
        $appliedModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($appliedModel->save()) {
            if (!empty($this->location_pref)) {
                foreach (json_decode($this->location_pref) as $location) {
                    $locModel = new AppliedApplicationLocations;
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $locModel->application_location_enc_id = $utilitiesModel->encrypt();
                    $locModel->applied_application_enc_id = $appliedModel->applied_application_enc_id;
                    $locModel->city_enc_id = $location;
                    $locModel->created_on = date('Y-m-d H:i:s');
                    $locModel->created_by = Yii::$app->user->identity->user_enc_id;
                    $app_id = $appliedModel->applied_application_enc_id;
                    $id = $this->id;
                    if (!$locModel->save()) {
                        return false;
                    }
                }
            }
            $status = [
                'status' => true,
                'aid' => $appliedModel->applied_application_enc_id,
            ];
            $this->save_process($id, $app_id);
            RefferalJobAppliedTracking::widget(['job_applied_id' => $appliedModel->applied_application_enc_id]);
            return $status;
        } else {
            return false;
        }
    }


    private function save_process($id, $app_id)
    {
        $process_list = EmployerApplications::find()
            ->alias('a')
            ->select(['b.field_name', 'b.field_enc_id'])
            ->where(['a.application_enc_id' => $id])
            ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.interview_process_enc_id = a.interview_process_enc_id')
            ->asArray()
            ->all();
        if (!empty($process_list)):
        foreach ($process_list as $process) {
            $processModel = new AppliedApplicationProcess;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $processModel->process_enc_id = $utilitiesModel->encrypt();
            $processModel->applied_application_enc_id = $app_id;
            $processModel->field_enc_id = $process['field_enc_id'];
            $processModel->created_on = date('Y-m-d H:i:s');
            $processModel->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$processModel->save()) {
                return false;
            }
        }
        endif;
    }
}