<?php

namespace account\models\organization;

use common\models\spaces\Spaces;
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
            $base_path = Yii::$app->params->upload_directories->organizations->logo . $organization->logo_location;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organization->logo = $utilitiesModel->encrypt() . '.png';
            $organization->last_updated_on = date('Y-m-d H:i:s');
            $organization->last_updated_by = Yii::$app->user->identity->user_enc_id;
            $file = dirname(__DIR__, 2) . '/files/temp/' . $organization->logo;
            if (file_put_contents($file, $image_base64)) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . '/' . $organization->logo, "public");
                if (file_exists($file)) {
                    unlink($file);
                }
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
//        } else {
//            return false;
//        }
    }

}
