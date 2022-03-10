<?php

namespace api\modules\v2\models;

use api\modules\v1\models\Candidates;
use common\models\Organizations;
use common\models\spaces\Spaces;
use common\models\UserAccessTokens;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Utilities;
use common\models\Users;

class ProfilePicture extends Model
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

    public function update()
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
            $user->image = $utilitiesModel->encrypt() . '.' . $this->profile_image->extension;
            $type = $this->profile_image->type;
            if ($user->update()) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($this->profile_image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $user->image, "public",['params' => ['ContentType' => $type]]);
                if ($result) {
                    return $user->user_enc_id;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function updateLogo()
    {
        $token_holder_id = UserAccessTokens::findOne([
            'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
        ]);
        $candidate = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);
        $utilitiesModel = new Utilities();
        $usersModel = new Organizations();
        $user = $usersModel->find()
            ->where(['created_by' => $candidate->user_enc_id])
            ->one();
        if ($user) {
            $user->logo_location = \Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->organizations->logo . $user->logo_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $user->logo = $utilitiesModel->encrypt() . '.' . $this->profile_image->extension;
            $type = $this->profile_image->type;
            if ($user->update()) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($this->profile_image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $user->logo, "public",['params' => ['ContentType' => $type]]);
                if ($result) {
                    return $user->organization_enc_id;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}
