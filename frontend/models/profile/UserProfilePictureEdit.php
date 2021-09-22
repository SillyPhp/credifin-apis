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

    public function update($image)
    {
//        $this->profile_image = UploadedFile::getInstance($this, 'profile_image');
        $utilitiesModel = new Utilities();
        $usersModel = new Users();
        $user = $usersModel->find()
            ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->one();
        if ($user) {
            $image_parts = explode(";base64,", $image);
            $image_base64 = base64_decode($image_parts[1]);
            $user->image_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->users->image . $user->image_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $encrypted_string = $utilitiesModel->encrypt();
            if (substr($encrypted_string, -1) == '.') {
                $encrypted_string = substr($encrypted_string, 0, -1);
            }
            $user->image = $encrypted_string . '.png';
            $file = dirname(__DIR__, 3) . '/files/temp/' . $user->image;
            if (file_put_contents($file, $image_base64)) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $user->image, "public");
                if (file_exists($file)) {
                    unlink($file);
                }
                if ($user->update()) {
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