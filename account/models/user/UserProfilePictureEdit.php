<?php
namespace account\models\user;
use yii\web\UploadedFile;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;

class UserProfilePictureEdit extends Model {

    public $profile_image;

    public function formName()
    {
        return '';
    }

    public function rules() {
        return [
            [['profile_image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
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
            $base_path = Yii::$app->params->upload_directories->users->image_path . $user->image_location;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $user->image = $utilitiesModel->encrypt() . '.' . $this->profile_image->extension;
            if ($user->update()){
                if (!is_dir($base_path)) {
                    if (mkdir($base_path, 0755, true)) {
                        if ($this->profile_image->saveAs($base_path . DIRECTORY_SEPARATOR . $user->image)) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            }
            else {
                return false;
            }

        }

    }

}