<?php

namespace api\modules\v4\models;

use common\models\ProductImages;
use common\models\ProductOtherDetails;
use common\models\Products;
use common\models\RandomColors;
use common\models\spaces\Spaces;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class ProductsForm extends Model
{
    public $product_name;
    public $description;
    public $model_id;
    public $price;
    public $assigned_category;
    public $city_id;
    public $variant;
    public $discounted_price;
    public $product_other_detail;
    public $ownership_type;
    public $images;
    public $dent_images;
    public $status;
    public $km_driven;
    public $making_year;
    public $ram;
    public $rom;
    public $screen_size;
    public $front_camera;
    public $back_camera;
    public $sim_type;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['model_id', 'price', 'city_id', 'assigned_category', 'product_other_detail', 'ownership_type', 'status'], 'required'],
            [['variant', 'description', 'product_name', 'dent_images', 'km_driven', 'making_year', 'ram', 'rom', 'images', 'discounted_price', 'screen_size', 'front_camera', 'back_camera', 'sim_type'], 'safe'],
            [['assigned_category', 'product_name'], 'trim'],
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
            $product->discounted_price = $this->discounted_price;
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
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $product->getErrors()];
            }

            $product_other_detail = new ProductOtherDetails();
            $product_other_detail->product_other_detail_enc_id = Yii::$app->security->generateRandomString(32);
            $product_other_detail->product_enc_id = $product->product_enc_id;
            $product_other_detail->other_detail = $this->product_other_detail;
            $product_other_detail->variant = $this->variant;
            $product_other_detail->ownership_type = $this->ownership_type;
            $product_other_detail->km_driven = $this->km_driven;
            $product_other_detail->making_year = $this->making_year;
            $product_other_detail->ram = $this->ram;
            $product_other_detail->rom = $this->rom;
            $product_other_detail->screen_size = $this->screen_size;
            $product_other_detail->front_camera = $this->front_camera;
            $product_other_detail->back_camera = $this->back_camera;
            $product_other_detail->sim_type = $this->sim_type;
            $product_other_detail->created_by = $user_id;
            if (!$product_other_detail->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $product_other_detail->getErrors()];
            }

            if (!$this->saveImages($user_id, $product->product_enc_id)) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => 'error occurred while uploading images'];
            }

            $transaction->commit();

            return ['status' => 200, 'message' => 'successfully saved'];

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
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
            $image->image = $utilitiesModel->encrypt() . '.' . 'jpg';
            $image->created_by = $user_id;
            $type = 'image/jpeg';
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
                $image->image = $utilitiesModel->encrypt() . '.' . 'jpg';
                $image->type = 'defect';
                $image->created_by = $user_id;
                $type = 'image/jpeg';
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

    public function update($user_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $params = Yii::$app->request->post();
        $product_enc_id = $params['product_enc_id'];
        try {
            $product = Products::findOne(['product_enc_id' => $product_enc_id]);
            if (!empty($product)) {
                $product->status = $this->status;
                $product->price = $this->price;
                $product->discounted_price = $this->discounted_price;
                $product->description = $this->description;
                $product->updated_by = $user_id;
                $product->city_enc_id = $this->city_id;
                $product->updated_on = date('Y-m-d H:i:s');
                if (!$product->update()) {
                    $transaction->rollBack();
                    return ['status' => 500, 'message' => 'an error occurred', 'error' => $product->getErrors()];
                }
                $product_other_details = ProductOtherDetails::findOne(['product_enc_id' => $product_enc_id]);
                if (!empty($product_other_details)) {
                    $product_other_details->other_detail = $this->product_other_detail;
                    $product_other_details->variant = $this->variant;
                    $product_other_details->km_driven = $this->km_driven;
                    $product_other_details->making_year = $this->making_year;
                    $product_other_details->ownership_type = $this->ownership_type;
                    $product_other_details->ram = $this->ram;
                    $product_other_details->rom = $this->rom;
                    $product_other_details->front_camera = $this->front_camera;
                    $product_other_details->back_camera = $this->back_camera;
                    $product_other_details->sim_type = $this->sim_type;
                    $product_other_details->updated_by = $user_id;
                    $product_other_details->updated_on = date('Y-m-d H:i:s');
                    if (!$product_other_details->update()) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred', 'error' => $product_other_details->getErrors()];
                    }
                }
                if (!$this->saveImages($user_id, $product_enc_id)) {
                    $transaction->rollBack();
                    return ['status' => 500, 'message' => 'an error occurred', 'error' => 'error occurred while uploading images'];
                }
            }
            $transaction->commit();
            return ['status' => 200, 'message' => 'successfully updated'];
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }
}