<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Companies;
use yii\web\UploadedFile;

class CompanyCoverModel extends Model {

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

    public function saveImage() {
        if ($this->validate()) {
            $utilitiesModel = new Utilities();
            $companiesModel = new Companies();
            $company = $companiesModel->find()
                    ->where(['organization_enc_id' => Yii::$app->user->identity->company->organization_enc_id])
                    ->one();
            $company->cover_image_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->companies->cover_image_path . $company->cover_image_location;
            //$image = UploadedFile::getInstance($this, 'image');  
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $company->cover_image = $utilitiesModel->encrypt() . '.' . $this->image->extension;
            if (!is_dir($base_path)) {
                if (mkdir($base_path, 0755, true)) {
                    if ($this->image->saveAs($base_path.$this->image->baseName.'.'.$this->image->extension)) {
//                        if ($company->validate() && $company->upate()) {
//                            return true;
//                        } else {
//                            return false;
//                        }
                        return true;
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
    }

}


