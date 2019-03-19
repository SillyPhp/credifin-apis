<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\UserResume;
//use yii\httpclient\Client;

class UploadCvForm extends Model {

    public $file;

    public function rules() {
        return [
            [['file'], 'required'],
        ];
    }

    public function attributbeLabels() {
        return[
            'file' => Yii::t('frontend', 'resume'),
        ];
    }

    public function save() {
        if ($this->validate()) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userResumeModel = new UserResume();
            $userResumeModel->resume_enc_id = $utilitiesModel->encrypt();
            $userResumeModel->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $userResumeModel->resume_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->resumes->logo_path . $userResumeModel->resume_location;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userResumeModel->resume = $utilitiesModel->encrypt() . '.' . $this->file->extension;
            $userResumeModel->created_on = date('Y-m-d H:i:s');
            $userResumeModel->created_by = Yii::$app->user->identity->user_enc_id;
             
            if (!is_dir($base_path)) {
                if (mkdir($base_path, 0755, true)) {
                    if ($this->file->saveAs($base_path . DIRECTORY_SEPARATOR . $userResumeModel->resume)) {
                        if ($userResumeModel->validate() && $userResumeModel->save()) {
                            return true;
                        } else {
                            return print_r($userResumeModel->getErrors());
                        }
                    } else {
                        return print_r($userResumeModel->getErrors());
                    }
                } else {
                    return print_r($userResumeModel->getErrors());
                }
            }
        }
    }

}
