<?php

namespace api\modules\v4\models;

use common\models\EmiCollection;
use common\models\spaces\Spaces;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class EmiCollectionForm extends Model
{
    public $customer_name;
    public $collection_date;
    public $loan_account_number;
    public $phone;
    public $amount;
    public $loan_type;
    public $loan_purpose;
    public $payment_method;
    public $other_payment_method;
    public $ptp_amount;
    public $ptp_date;
    public $delay_reason;
    public $other_delay_reason;
    public $location_image;
    public $borrower_image;
    public $pr_receipt_image;
    public $address;
    public $state;
    public $city;
    public $zip;
    public $comments;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['customer_name', 'collection_date', 'loan_account_number', 'phone', 'amount', 'loan_type', 'address', 'state', 'city', 'zip'], 'required'],
            [['ptp_amount', 'ptp_date', 'delay_reason', 'other_delay_reason', 'location_image', 'borrower_image', 'pr_receipt_image', 'payment_method', 'loan_purpose', 'comments'], 'safe'],
            [['amount', 'ptp_amount'], 'number'],
            [['collection_date'], 'date', 'format' => 'php:Y-m-d'],
            [['ptp_date'], 'date', 'format' => 'php:Y-m-d'],
            [['location_image', 'borrower_image', 'pr_receipt_image'], 'file', 'skipOnEmpty' => True, 'extensions' => 'png, jpg'],
            ['other_payment_method', 'required', 'when' => function ($model) {
                return $model->payment_method == null;
            }]
        ];
    }

    public function save($user_id)
    {
        $model = new EmiCollection();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->emi_collection_enc_id = $utilitiesModel->encrypt();
        $model->customer_name = $this->customer_name;
        $model->collection_date = $this->collection_date;
        $model->loan_account_number = $this->loan_account_number;
        $model->phone = $this->phone;
        $model->amount = $this->amount;
        $model->loan_type = $this->loan_type;
        if ($this->loan_purpose) {
            $model->loan_purpose = $this->loan_purpose;
        }
        $model->address = $this->address;
        $model->state_enc_id = $this->state;
        $model->city_enc_id = $this->city;
        $model->pincode = $this->zip;
        $model->created_by = $user_id;
        $model->updated_by = $user_id;
        $model->created_on = date('Y-m-d h:i:s');
        $model->updated_on = date('Y-m-d h:i:s');
        if ($this->ptp_amount) {
            $model->ptp_amount = $this->ptp_amount;
        }
        if ($this->comments) {
            $model->comments = $this->comments;
        }
        if ($this->ptp_date) {
            $model->ptp_date = $this->ptp_date;
        }
        if ($this->delay_reason) {
            $model->delay_reason = $this->delay_reason;
        }
        if ($this->other_delay_reason) {
            $model->other_delay_reason = $this->other_delay_reason;
        }
        if ($this->payment_method) {
            $model->payment_method = $this->payment_method;
        }
        if ($this->other_payment_method) {
            $model->other_payment_method = $this->other_payment_method;
        }
        if ($this->location_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->location_image = $utilitiesModel->encrypt() . '.' . $this->location_image->extension;
            $model->location_image_location = Yii::$app->getSecurity()->generateRandomString();

            $this->fileUpload($this->location_image, $model->location_image, $model->location_image_location);
        }

        if ($this->borrower_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->borrower_image = $utilitiesModel->encrypt() . '.' . $this->location_image->extension;
            $model->borrower_image_location = Yii::$app->getSecurity()->generateRandomString();

            $this->fileUpload($this->borrower_image, $model->borrower_image, $model->borrower_image_location);
        }

        if ($this->pr_receipt_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->pr_receipt_image = $utilitiesModel->encrypt() . '.' . $this->location_image->extension;
            $model->pr_receipt_image_location = Yii::$app->getSecurity()->generateRandomString();

            $this->fileUpload($this->location_image, $model->pr_receipt_image, $model->pr_receipt_image_location);
        }
        if (!$model->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()];
        }
        return ['status' => 200, 'message' => 'Saved Successfully'];
    }

    private function fileUpload($img_obj, $image, $image_location)
    {
        $base_path = Yii::$app->params->upload_directories->emi_collection->image . $image_location;
        $type = $img_obj->type;
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($img_obj->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . DIRECTORY_SEPARATOR . $image, "private", ['params' => ['ContentType' => $type]]);
        if (!$result) {
            throw new \Exception('error occurred while uploading logo');
        }
    }
}