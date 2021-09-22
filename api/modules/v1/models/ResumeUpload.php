<?php

namespace api\modules\v1\models;

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

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['resume_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx, pdf', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function upload($resume, $resume_ext, $resume_name)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
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
            $base_path = Yii::$app->params->upload_directories->resume->file . $userResumeModel->resume_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);

            $encrypted_string = $utilitiesModel->encrypt();
            if (substr($encrypted_string, -1) == '.') {
                $encrypted_string = substr($encrypted_string, 0, -1);
            }

            $userResumeModel->resume = $encrypted_string . '.' . $resume_ext;
            $userResumeModel->title = $resume_name . '.' . $resume_ext;
            $userResumeModel->alt = $resume_name . '.' . $resume_ext;
            $userResumeModel->created_on = date('Y-m-d h:i:s');
            $userResumeModel->created_by = $user->user_enc_id;
            $file = dirname(__DIR__, 4) . '/files/temp/' . $userResumeModel->resume;
            if ($userResumeModel->save()) {
                if (file_put_contents($file, $resume)) {
                    $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                    $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                    $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $userResumeModel->resume, "private");
                    if (file_exists($file)) {
                        unlink($file);
                    } else {
                        print_r('file not found');
                        die();
                    }
                    $transaction->commit();
                    return $userResumeModel->resume_enc_id;
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


}
