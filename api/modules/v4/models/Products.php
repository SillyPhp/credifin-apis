<?php

namespace api\modules\v4\models;

use common\models\ProductImages;
use common\models\ProductOtherDetails;
use common\models\RandomColors;
use common\models\spaces\Spaces;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class Products extends Model
{
    public $product_name;
    public $description;
    public $model_id;
    public $price;
    public $assigned_category;
    public $city_id;
    public $variant;
    public $product_other_detail;
    public $ownership_type;
    public $images;
    public $dent_images;
    public $status;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['model_id', 'price', 'city_id', 'assigned_category', 'product_other_detail', 'ownership_type', 'images', 'status'], 'required'],
            [['variant', 'description', 'product_name', 'dent_images'], 'safe'],
            [['assigned_category', 'product_name'], 'trim'],
            [['images'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 8],
            [['dent_images'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 8]
        ];
    }

    public function save($user_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $product = new \common\models\Products();
            $product->product_enc_id = Yii::$app->security->generateRandomString(32);
            $product->model_enc_id = $this->model_id;
            $product->dealer_enc_id = $user_id;
            $product->assigned_category_enc_id = $this->assigned_category;
            $product->price = $this->price;
            $product->city_enc_id = $this->city_id;
            $product->name = $this->product_name;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['name'] = $product->name;
            $utilitiesModel->variables['table_name'] = \common\models\Products::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $product->slug = $utilitiesModel->create_slug();
            $product->description = $this->description;
            $product->status = $this->status;
            $product->created_by = $user_id;

            if (!$product->save()) {
                $transaction->rollBack();
                return false;
            }

            $product_other_detail = new ProductOtherDetails();
            $product_other_detail->product_other_detail_enc_id = Yii::$app->security->generateRandomString(32);
            $product_other_detail->product_enc_id = $product->product_enc_id;
            $product_other_detail->other_detail = json_encode($this->product_other_detail);
            $product_other_detail->variant = $this->variant;
            $product_other_detail->ownership_type = $this->ownership_type;
            $product_other_detail->created_by = $user_id;
            if (!$product_other_detail->save()) {
                $transaction->rollBack();
                return false;
            }

            if (!$this->saveImages($user_id, $product->product_enc_id)) {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();

            return true;
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return false;
        }
    }

    private function saveImages($user_id, $product_id)
    {
        foreach ($this->images as $i) {
            $image = new ProductImages();
            $image->image_enc_id = Yii::$app->security->generateRandomString(32);
            $image->product_enc_id = $product_id;
            $image->image_location = \Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->refurbished->image . $image->image_location . '/';
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $image->image = $utilitiesModel->encrypt() . '.' . $i->extension;
            $image->created_by = $user_id;
            $type = $i->type;
            if ($image->save()) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($i->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $image->image, "public", ['params' => ['ContentType' => $type]]);
                if (!$result) {
                    return false;
                }
            } else {
                return false;
            }
        }

        if ($this->dent_images) {
            foreach ($this->dent_images as $d) {
                $image = new ProductImages();
                $image->image_enc_id = Yii::$app->security->generateRandomString(32);
                $image->product_enc_id = $product_id;
                $image->image_location = \Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->refurbished->image . $image->image_location . '/';
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $image->image = $utilitiesModel->encrypt() . '.' . $d->extension;
                $image->type = 'defect';
                $image->created_by = $user_id;
                $type = $d->type;
                if ($image->save()) {
                    $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                    $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                    $result = $my_space->uploadFileSources($d->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $image->image, "public", ['params' => ['ContentType' => $type]]);
                    if (!$result) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        return true;
    }
}