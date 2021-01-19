<?php
/**
 * Created by PhpStorm.
 * User: Sneh Kant
 * Date: 27-01-2019
 * Time: 00:25
 */

namespace frontend\models\profile;

use common\models\spaces\Spaces;
use yii\web\UploadedFile;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;

class UserProfilePictureEdit extends Model
{

    public $profile_image;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['profile_image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 5,'tooBig'=>'The Image file You Uploaded is too large, Its size cannot exceed more than 5 MB'],
        ];
    }

    public function update()
    {
        $this->profile_image = UploadedFile::getInstance($this, 'profile_image');
        $utilitiesModel = new Utilities();
        $usersModel = new Users();
        $user = $usersModel->find()
            ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->one();
        if ($user) {
            $user->image_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->users->image . $user->image_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $user->image = $utilitiesModel->encrypt() . '.' . $this->profile_image->extension;
            if ($user->update()) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFile($this->profile_image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $user->image, "public");
                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

    }

}