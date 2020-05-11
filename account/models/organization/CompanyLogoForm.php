<?php

namespace account\models\organization;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Organizations;

class CompanyLogoForm extends Model
{

    public $logo;

    public function rules()
    {
        return [
            [['logo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'logo' => Yii::t('account', 'logo'),
        ];
    }

    public function save($image)
    {
//        if ($this->validate()) {
        $utilitiesModel = new Utilities();
        $organizationsModel = new Organizations();
        $organization = $organizationsModel->find()
            ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->one();
        if ($organization) {
            $image_parts = explode(";base64,", $image);
            $image_base64 = base64_decode($image_parts[1]);
            $organization->logo_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->organizations->logo_path . $organization->logo_location;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organization->logo = $utilitiesModel->encrypt() . '.png';
            $organization->last_updated_on = date('Y-m-d H:i:s');
            $organization->last_updated_by = Yii::$app->user->identity->user_enc_id;
            if (!is_dir($base_path)) {
                if (mkdir($base_path, 0755, true)) {
                    if (file_put_contents($base_path . DIRECTORY_SEPARATOR . $organization->logo, $image_base64)) {
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
