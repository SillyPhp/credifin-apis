<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Organizations;

class CompanyCoverImageForm extends Model {

    public $image;

    public function rules() {
        return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
        ];
    }

    public function attributeLabels() {
        return[
            'image' => Yii::t('frontend', 'Image'),
        ];
    }

    public function save($c_image) {
//        if ($this->validate()) {
            $utilitiesModel = new Utilities();
            $organizationsModel = new Organizations();
            $organization = $organizationsModel->find()
                    ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                    ->one();
            if ($organization) {
                $image_parts = explode(";base64,", $c_image);
                $image_base64 = base64_decode($image_parts[1]);
                $organization->cover_image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $organization->cover_image_location;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $organization->cover_image = $utilitiesModel->encrypt() . '.' . $this->image->extension;
                $organization->last_updated_on = date('Y-m-d h:i:s');
                $organization->last_updated_by = Yii::$app->user->identity->user_enc_id;
                if (!is_dir($base_path)) {
                    if (mkdir($base_path, 0755, true)) {
                        if (file_put_contents($base_path . DIRECTORY_SEPARATOR . $organization->cover_image, $image_base64)) {
                            if ($organization->validate() && $organization->save()) {
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
//        } else {
//            return false;
//        }
    }

}
