<?php

namespace frontend\models\applications;

use common\models\spaces\Spaces;
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
    public $org_id;
    public $check;
    public $resume_list;
    public $location_pref;
    public $status;

    public function rules()
    {
        return [
            [['id', 'org_id', 'status', 'questionnaire_id', 'fill_question'], 'required'],
            [
                ['location_pref'], 'required', 'when' => function ($model, $attribute) {
            }, 'whenClient' => "function (attribute, value) {
                       return $('#jobapplied-location_pref label input').length != 0;
                }"
            ],
//            [['resume_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx,pdf,png,jpg,jpeg', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function upload()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userResumeModel = new UserResume();
            $userResumeModel->resume_enc_id = $utilitiesModel->encrypt();
            $userResumeModel->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $userResumeModel->resume_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->resume->file . $userResumeModel->resume_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userResumeModel->resume = $utilitiesModel->encrypt() . '.' . $this->resume_file->extension;
            $userResumeModel->title = $this->resume_file->baseName . '.' . $this->resume_file->extension;
            $userResumeModel->alt = $this->resume_file->baseName . '.' . $this->resume_file->extension;
            $type = $this->resume_file->type;
            $userResumeModel->created_on = date('Y-m-d H:i:s');
            $userResumeModel->created_by = Yii::$app->user->identity->user_enc_id;
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($this->resume_file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $userResumeModel->resume, "private",['params' => ['ContentType' => $type]]);
            if ($result) {
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
                                if (!$locModel->save()) {
                                    $transaction->rollBack();
                                    return false;
                                }
                            }
                        }
                        $status = [
                            'status' => true,
                            'aid' => $appliedModel->applied_application_enc_id,
                        ];
                        $id = $this->id;
                        $app_id = $appliedModel->applied_application_enc_id;
                        if (!$this->save_process($id, $app_id)) {
                            $transaction->rollBack();
                            return false;
                        }
                        $transaction->commit();
                        RefferalJobAppliedTracking::widget(['job_applied_id' => $appliedModel->applied_application_enc_id]);
                        return $status;

                    } else {
                        $transaction->rollBack();
                        return false;
                    }
                } else {
                    $transaction->rollBack();
                    return false;
                }
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return false;
        }

    }

    public function saveValues()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
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
                        if (!$locModel->save()) {
                            $transaction->rollBack();
                            return false;
                        }
                    }
                }
                $status = [
                    'status' => true,
                    'aid' => $appliedModel->applied_application_enc_id,
                ];
                $app_id = $appliedModel->applied_application_enc_id;
                $id = $this->id;
                if (!$this->save_process($id, $app_id)) {
                    $transaction->rollBack();
                    return false;
                }
                $transaction->commit();
                RefferalJobAppliedTracking::widget(['job_applied_id' => $appliedModel->applied_application_enc_id]);
                return $status;
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
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
        if (!empty($process_list)) {
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
        }

        return true;
    }
}