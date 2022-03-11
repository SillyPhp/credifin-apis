<?php

namespace api\modules\v2\models;

use common\models\spaces\Spaces;
use common\models\UserAccessTokens;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Utilities;
use common\models\Users;
use common\models\UserResume;

class ResumeUpload extends Model
{
    public $resume_file;

    public function rules()
    {
        return [
            [['resume_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx, pdf', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function upload($data)
    {

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userResumeModel = new UserResume();
            $userResumeModel->resume_enc_id = $utilitiesModel->encrypt();
            $userResumeModel->user_enc_id = $data['user_id'];
            $userResumeModel->resume_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->resume->file . $userResumeModel->resume_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);

            $encrypted_string = $utilitiesModel->encrypt();
            if (substr($encrypted_string, -1) == '.') {
                $encrypted_string = substr($encrypted_string, 0, -1);
            }

            $userResumeModel->resume = $encrypted_string . '.' . $this->resume_file->extension;
            $userResumeModel->title = $this->resume_file->baseName . '.' . $this->resume_file->extension;
            $userResumeModel->alt = $this->resume_file->baseName . '.' . $this->resume_file->extension;
            $type = $this->resume_file->type;
            $userResumeModel->created_on = date('Y-m-d h:i:s');
            $userResumeModel->created_by = $data['user_id'];
            if ($userResumeModel->save()) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($this->resume_file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $userResumeModel->resume, "private",['params' => ['ContentType' => $type]]);
                if ($result) {
//                    print_r($result['ObjectURL']);
                    $transaction->commit();
                    return $userResumeModel->resume_enc_id;
                } else {
                    return false;
                }
            } else {
                $transaction->rollback();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }
}
