<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;

class IndividualImageForm extends Model {

    public $image;

    public function rules() {
        return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
        ];
    }

    public function attributeLabels() {
        return[
            'image' => Yii::t('frontend', 'image'),
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
                $user->image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->users->image_path . $user->image_location;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $user->image = $utilitiesModel->encrypt() . '.' . $this->image->extension;
                if (!is_dir($base_path)) {
                    if (mkdir($base_path, 0755, true)) {
                        if ($this->image->saveAs($base_path . DIRECTORY_SEPARATOR . $user->image)) {
                            if ($user->validate() && $user->save()) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return 'Unable to create directory';
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
