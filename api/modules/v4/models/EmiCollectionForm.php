<?php

namespace api\modules\v4\models;

use common\models\EmiCollection;
use common\models\spaces\Spaces;
use common\models\Utilities;
use Razorpay\Api\Api;
use Yii;
use yii\base\Model;

class EmiCollectionForm extends Model
{
    public $customer_name;
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
    public $other_doc_image;
    public $borrower_image;
    public $pr_receipt_image;
    public $address;
    public $state;
    public $city;
    public $postal_code;
    public $comments;
    public $latitude;
    public $longitude;
    public $branch_enc_id;
    public $org_id;
    public $brand;
    public $desc;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['customer_name', 'phone', 'amount', 'loan_type', 'address', 'state', 'city', 'postal_code', 'latitude', 'longitude', 'payment_method', 'branch_enc_id'], 'required'],
            [['desc', 'org_id', 'brand'], 'required', 'when' => function ($model) {
                return $model->payment_method == 'Online Payment';
            }],
            [['loan_account_number'], 'required', 'when' => function ($model) {
                return $model->payment_method != 'Online Payment';
            }],
            [['ptp_amount', 'ptp_date', 'delay_reason', 'other_delay_reason', 'other_doc_image', 'borrower_image', 'pr_receipt_image', 'loan_purpose', 'comments', 'other_payment_method'], 'safe'],
            [['amount', 'ptp_amount', 'latitude', 'longitude'], 'number'],
            [['ptp_date'], 'date', 'format' => 'php:Y-m-d'],
            [['other_doc_image', 'borrower_image', 'pr_receipt_image'], 'file', 'skipOnEmpty' => True, 'extensions' => 'png, jpg'],
        ];
    }

    public function save($user_id)
    {
        $model = new EmiCollection();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->emi_collection_enc_id = $utilitiesModel->encrypt();
        $model->branch_enc_id = $this->branch_enc_id;
        $model->customer_name = $this->customer_name;
        $model->collection_date = date('Y-m-d');
        $model->loan_account_number = $this->loan_account_number;
        $model->phone = $this->phone;
        $model->amount = $this->amount;
        $model->loan_type = $this->loan_type;
        if ($this->loan_purpose) {
            $model->loan_purpose = $this->loan_purpose;
        }
        $address = $this->address . ', ' . $this->city . ', ' . $this->state;
        $model->address = $address;
        $model->pincode = $this->postal_code;
        $model->latitude = $this->latitude;
        $model->longitude = $this->longitude;
        $model->created_by = $model->updated_by = $user_id;
        $model->created_on = $model->updated_on = date('Y-m-d h:i:s');
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
        if ($this->other_doc_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->other_doc_image = $utilitiesModel->encrypt() . '.' . $this->other_doc_image->extension;
            $model->other_doc_image_location = Yii::$app->getSecurity()->generateRandomString();

            $this->fileUpload($this->other_doc_image, $model->other_doc_image, $model->other_doc_image_location);
        }

        if ($this->borrower_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->borrower_image = $utilitiesModel->encrypt() . '.' . $this->borrower_image->extension;
            $model->borrower_image_location = Yii::$app->getSecurity()->generateRandomString();

            $this->fileUpload($this->borrower_image, $model->borrower_image, $model->borrower_image_location);
        }

        if ($this->pr_receipt_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->pr_receipt_image = $utilitiesModel->encrypt() . '.' . $this->pr_receipt_image->extension;
            $model->pr_receipt_image_location = Yii::$app->getSecurity()->generateRandomString();

            $this->fileUpload($this->pr_receipt_image, $model->pr_receipt_image, $model->pr_receipt_image_location);
        }
        if (!$model->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()];
        }

        $return = ['status' => 200, 'message' => 'Saved Successfully'];

        if ($model->payment_method == 'Online Payment') {
            $options = [];
            $options['emi_collection_enc_id'] = $model->emi_collection_enc_id;
            $options['user_id'] = $user_id;
            $options['org_id'] = $this->org_id;
            $options['amount'] = $this->amount;
            $options['description'] = $this->desc;
            $options['name'] = $this->customer_name;
            $options['contact'] = $this->phone;
            $options['call_back_url'] = Yii::$app->params->EmpowerYouth->callBack . "/payment/transaction";
            $options['brand'] = $this->brand;
            $options['purpose'] = $this->loan_type;
            $links = self::createLinks($options);
            if ($links['status'] != 200) {
                return $links;
            }
            $return['links'] = $links['data'];
        }
        return $return;
    }

    private function createLinks($options)
    {
        $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
        if (!$keys) {
            return ['status' => 500, 'message' => 'an error occurred while fetching razorpay credentials'];
        }
        $api_key = $keys['api_key'];
        $api_secret = $keys['api_secret'];
        $api = new Api($api_key, $api_secret);
        $options['close_by'] = time() + 24 * 60 * 60;
        $data['qr'] = \common\models\payments\Payments::createQr($api, $options);
        if (!$data['qr']) {
            return ['status' => 500, 'message' => 'an error occurred while creating qr'];
        }
        $options['close_by'] = time() + 24 * 60 * 60 * 7;
        $data['link'] = \common\models\payments\Payments::createLink($api, $options);
        if (!$data['link']) {
            return ['status' => 500, 'message' => 'an error occurred while creating link'];
        }
        return ['status' => 200, 'data' => $data];
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