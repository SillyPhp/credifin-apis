<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Organizations;
use common\models\OrganizationImages;

class CompanyImagesForm extends Model {

    public $image;

    public function rules() {
        return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
        ];
    }


    public function save() {
        if ($this->validate()) {
            $utilitiesModel = new Utilities();
            $organizationsModel = new Organizations();
            $organizationImagesModel = new OrganizationImages();
            $organization = $organizationsModel->find()
                ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'is_deleted' => 0])
                ->one();
            if ($organization) {
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $organizationImagesModel->image_enc_id = $utilitiesModel->encrypt();
                $organizationImagesModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                $organizationImagesModel->image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->organizations->image_path . $organizationImagesModel->image_location;
                $organizationImagesModel->image = Yii::$app->getSecurity()->generateRandomString() . '.' . $this->image->extension;
                $organizationImagesModel->title = $organizationImagesModel->alt = $this->image->baseName;
                $organizationImagesModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!is_dir($base_path)) {
                    if (mkdir($base_path, 0755, true)) {
                        if ($this->image->saveAs($base_path . DIRECTORY_SEPARATOR . $organizationImagesModel->image)) {
                            if ($organizationImagesModel->validate() && $organizationImagesModel->save()) {
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
