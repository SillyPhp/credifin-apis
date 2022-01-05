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

class JobAppliedResume extends Model
{
    public $resume_file;
    public $id;
    public $org_id;
    public $check;
    public $resume_list;

    public function rules()
    {
        return [
            [['id', 'resume_file', 'org_id', 'check', 'resume_list'], 'required'],
            [['resume_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx,pdf,png,jpg,jpeg', 'maxSize' => 1024 * 1024 * 2],
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
            $userResumeModel->created_on = date('Y-m-d H:i:s');
            $userResumeModel->created_by = Yii::$app->user->identity->user_enc_id;
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFile($this->resume_file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $userResumeModel->resume, "private");
            if ($result) {
                if ($userResumeModel->validate() && $userResumeModel->save()) {
                    $appliedModel = AppliedApplications::findone(['applied_application_enc_id'=>$this->id]);
                    $appliedModel->resume_enc_id = $userResumeModel->resume_enc_id;
                    $appliedModel->last_updated_on = date('Y-m-d H:i:s');
                    $appliedModel->last_updated_by = Yii::$app->user->identity->user_enc_id;
                    if ($appliedModel->save()) {
                        $status = [
                            'status' => true,
                        ];
                        $transaction->commit();
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
            $appliedModel = AppliedApplications::findone(['applied_application_enc_id'=>$this->id]);
            $appliedModel->resume_enc_id = $this->resume_list;
            $appliedModel->last_updated_on = date('Y-m-d H:i:s');
            $appliedModel->last_updated_by = Yii::$app->user->identity->user_enc_id;
            if ($appliedModel->save()) {
                $status = [
                    'status' => true,
                ];
                $transaction->commit();
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

}