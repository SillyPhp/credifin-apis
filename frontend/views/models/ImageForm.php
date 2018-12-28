<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\OrganizationImages;

class ImageForm extends Model {

    public $images;

    public function rules() {
        return[
            ['images', 'each', 'rule' => ['file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 5, 'maxFiles' => 10]],
        ];
    }

    public function attributeLabels() {
        return[
            'images' => Yii::t('frontend', 'Image'),
        ];
    }

    public function save() {
//        if ($this->validate()) {
        return $this->images;
        exit;
        foreach ($this->images as $image) {
            $utilitiesModel = new Utilities();
            $organizationImagesModel = new OrganizationImages();
            $organizationImagesModel->image_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->companies->image_path . $organizationImagesModel->image_location;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organizationImagesModel->image = $utilitiesModel->encrypt() . '.' . $image->extension;
            if (!is_dir($base_path)) {
                if (mkdir($base_path, 0755, true)) {
                    if ($image->saveAs($base_path . DIRECTORY_SEPARATOR . $organizationImagesModel->image)) {
                        $organizationImagesModel->organization_enc_id = Yii::$app->user->identity->company->organization_enc_id;
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $organizationImagesModel->image_enc_id = $utilitiesModel->encrypt();
                        $organizationImagesModel->title = $image->baseName;
                        $organizationImagesModel->alt = $image->baseName;
                        $organizationImagesModel->created_by = Yii::$app->user->identity->user_enc_id;
                        $organizationImagesModel->created_on = date('Y-m-d h:i:s');
                        if ($organizationImagesModel->validate() && $organizationImagesModel->save()) {
                            return true;
                        } else {
                            return $organizationImagesModel->getErrors();
                        }
                    } else {
                        return 'Image not saved';
                    }
                } else {
                    return 'directory not created';
                }
            }
        }
//        } else {
//            return false;
//        }
    }

}
