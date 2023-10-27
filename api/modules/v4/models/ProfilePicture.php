<?php

namespace api\modules\v4\models;

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

    public function update($userId)
    {
        $utilitiesModel = new Utilities();

        // finding user with this user_id
        $usersModel = new Users();
        $user = $usersModel->findOne(['user_enc_id' => $userId]);

        // creating image location
        $user->image_location = \Yii::$app->getSecurity()->generateRandomString();
        $base_path = Yii::$app->params->upload_directories->users->image . $user->image_location . '/';
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $user->image = $utilitiesModel->encrypt() . '.' . $this->profile_image->extension;
        $type = $this->profile_image->type;
        if ($user->update()) {
            // creating spaces to upload image on digital ocean
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($this->profile_image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $user->image, "public", ['params' => ['ContentType' => $type]]);
            if ($result) {
                // returning image link
                $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $user->image_location . DIRECTORY_SEPARATOR . $user->image;
                return ['status' => 200, 'image' => $image];
            } else {
                return ['status' => 500, 'message' => 'an error occurred', 'error' => 'error in uploading image'];
            }
        } else {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $user->getErrors()];
        }
    }
}
