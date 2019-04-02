<?php

namespace api\modules\v1\models;

use common\models\UserAccessTokens;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Utilities;
use common\models\Users;
use common\models\UserResume;

class ResumeUpload extends Model{
    public $resume_file;

    public function formName(){
        return '';
    }

    public function rules(){
        return [
            [['resume_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx,pdf'],
        ];
    }

    public function upload(){
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userResumeModel = new UserResume();
        $userResumeModel->resume_enc_id = $utilitiesModel->encrypt();
        $userResumeModel->user_enc_id = $user->user_enc_id;
        $userResumeModel->resume_location = Yii::$app->getSecurity()->generateRandomString();
        $base_path = Yii::$app->params->upload_directories->resume->file_path . $userResumeModel->resume_location;
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userResumeModel->resume = $utilitiesModel->encrypt() . '.' . $this->resume_file->extension;
        $userResumeModel->title = $this->resume_file->baseName . '.' . $this->resume_file->extension;
        $userResumeModel->alt = $this->resume_file->baseName . '.' . $this->resume_file->extension;
        $userResumeModel->created_on = date('Y-m-d h:i:s');
        $userResumeModel->created_by = $user->user_enc_id;
        if (!is_dir($base_path)) {
            if (mkdir($base_path, 0755, true)) {
                if ($this->resume_file->saveAs($base_path . DIRECTORY_SEPARATOR . $userResumeModel->resume)) {
                    if ($userResumeModel->validate() && $userResumeModel->save()) {
                        return $userResumeModel->resume_enc_id;
                    }
                    return false;
                }
                return false;
            }
            return false;
        }

    }
}
