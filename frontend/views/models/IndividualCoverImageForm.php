<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;

class IndividualCoverImageForm extends Model {

    public $cover_image;

    public function rules() {
        return [
            [['cover_image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
        ];
    }

    public function attributeLabels() {
        return[
            'cover_image' => Yii::t('frontend', 'image'),
        ];
    }

    public function save() {
       
        if ($this->validate()) {
            $utilitiesModel = new Utilities();
            $usersModel = new Users();
            $user = $usersModel->find()
                    ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                    ->one();
            if ($user) {
                $user->cover_image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->users->cover_image_path . $user->cover_image_location;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user->cover_image = $utilitiesModel->encrypt() . '.' . $this->cover_image->extension;
                if (!is_dir($base_path)) {
                    if (mkdir($base_path, 0755, true)) {
                        if ($this->cover_image->saveAs($base_path . DIRECTORY_SEPARATOR . $user->cover_image)) {
                            if ($user->validate() && $user->save()) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
