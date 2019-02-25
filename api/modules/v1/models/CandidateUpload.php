<?php

namespace api\modules\v1\models;

use common\models\UserAccessTokens;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Utilities;
use common\models\Users;
use common\models\UserResume;

class CandidateUpload extends Model{
    public $profile_image;
    public $resume_file;

    public function formName(){
        return '';
    }

    public function rules(){
        return [
            [['profile_image', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1]],
            [['resume_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx,pdf']
        ];
    }

    public function update(){
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $utilitiesModel = new Utilities();
        $usersModel = new Users();
        $user = $usersModel->find()
                ->where(['user_enc_id' => $candidate->user_enc_id])
                ->one();
        if($user){
            $user->image_location = \Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->users->image_path . $user->image_location;
            $utilitiesModel->variables['string'] = time(). rand(100, 100000);
            $user->image = $utilitiesModel->encrypt() . '.' . $this->profile_image->extension;
            if($user->update()){
                if(!is_dir($base_path)){
                    if(mkdir($base_path, 0755, true)){
                        if($this->profile_image->saveAs($base_path . DIRECTORY_SEPARATOR . $user->image)) {
                                return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }
            }else{
                return false;
            }
        }
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
