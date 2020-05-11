<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\OrganizationProductImages;
use common\models\OrganizationProducts;

class OrganizationProductsForm extends Model {

    public $image;
    public $description;

    public function rules() {
        return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
            [['description'], 'trim'],
        ];
    }
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $checkProduct = OrganizationProducts::find()
            ->select(['product_enc_id'])
            ->where(['organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->asArray()
            ->one();

            $utilitiesModel = new Utilities();
        if (empty($checkProduct)) {
            $organizationProducts = new OrganizationProducts();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organizationProducts->product_enc_id = $utilitiesModel->encrypt();
            $organizationProducts->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
//            $organizationProducts->description = $this->description;
            $organizationProducts->created_on = date('Y-m-d H:i:s');
            $organizationProducts->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$organizationProducts->validate() || !$organizationProducts->save()) {
                return false;
            }
        }
            $organizationProductImages = new OrganizationProductImages();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $organizationProductImages->image_enc_id = $utilitiesModel->encrypt();
            $organizationProductImages->product_enc_id = (empty($checkProduct) ? $organizationProducts->product_enc_id : $checkProduct['product_enc_id']);
            $organizationProductImages->image_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->organizations->image_path . $organizationProductImages->image_location;
            $organizationProductImages->image = Yii::$app->getSecurity()->generateRandomString() . '.' . $this->image->extension;
            $organizationProductImages->title = $organizationProductImages->alt = $this->image->baseName;
            $organizationProductImages->created_on = date('Y-m-d H:i:s');
            $organizationProductImages->created_by = Yii::$app->user->identity->user_enc_id;
            if (!is_dir($base_path)) {
                if (mkdir($base_path, 0755, true)) {
                    if ($this->image->saveAs($base_path . DIRECTORY_SEPARATOR . $organizationProductImages->image)) {
                        if ($organizationProductImages->validate() && $organizationProductImages->save()) {
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
//        }
    }
}