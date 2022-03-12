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

class PictureUpload extends Model
{
    public $profile_image;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['profile_image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function update($image)
    {
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
        if ($user) {
            $user->image_location = \Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->users->image . $user->image_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);

            $encrypted_string = $utilitiesModel->encrypt();
            if (substr($encrypted_string, -1) == '.') {
                $encrypted_string = substr($encrypted_string, 0, -1);
            }

            $user->image = $encrypted_string . '.png';
            $type = 'image/png';
            $file = dirname(__DIR__, 4) . '/files/temp/' . $user->image;
            if ($user->update()) {
                if (file_put_contents($file, $image)) {
                    $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                    $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                    $my_space->uploadFileSources($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $user->image, "public",['params' => ['ContentType' => $type]]);
                    if (file_exists($file)) {
                        unlink($file);
                    }
                    if ($user->save()) {
                        return $user->user_enc_id;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}
