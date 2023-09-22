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
    public $payment_mode;
    public $dealer_name;
    public $reference_number;
    public static $payment_methods = [
        'total' => 'Total',
        '1' => 'QR',
        '2' => 'Link',
        //        '3' => 'POS',
        '4' => 'Cash',
        '5' => 'Cheque',
        '6' => 'Nach',
        '7' => 'eNach',
        '81' => 'Cash',
        '82' => 'Cheque',
        '83' => 'Net Banking',
        '84' => 'RTGS/NEFT',
        '9' => 'QR',
        '10' => 'Digital Transfer',
        '11' => 'Paid To Dealer',
        'pending' => 'Pending',
    ];
    public static $payment_modes = [
        '1' => 'Pay Now',
        '2' => 'Manual Collection',
        '3' => 'Pay By EOD',
        '4' => 'Online Off System Transaction',
    ];

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['customer_name', 'phone', 'amount', 'loan_type', 'latitude', 'longitude', 'payment_mode', 'branch_enc_id', 'loan_account_number'], 'required'],
            [['org_id', 'brand'], 'required', 'when' => function ($model) {
                return $model->payment_mode == 1;
            }],
            [['reference_number'], 'required', 'when' => function ($model) {
                return $model->payment_mode != 1;
            }],
            [['dealer_name'], 'required', 'when' => function ($model) {
                return $model->payment_method == 11;
            }],
            [['ptp_amount', 'ptp_date', 'delay_reason', 'other_delay_reason', 'other_doc_image', 'payment_method', 'borrower_image', 'pr_receipt_image', 'loan_purpose', 'comments', 'other_payment_method', 'address', 'state', 'city', 'postal_code'], 'safe'],
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
        if ($this->address) {
            $address = $this->address;
            if ($this->city) {
                $address .= ', ' . $this->city;
            }
            if ($this->state) {
                $address .= ', ' . $this->state;
            }
        }
        if (!empty($address)) {
            $model->address = $address;
        }
        if ($this->postal_code) {
            $model->pincode = $this->postal_code;
        }
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
        $model->emi_payment_mode = $this->payment_mode;
        $model->emi_payment_method = $this->payment_method;
        $model->emi_payment_status = 'pending';
        $model->dealer_name = $this->dealer_name ?? '';
        $model->reference_number = $this->reference_number ?? '';
        if ($this->other_doc_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->other_doc_image = $utilitiesModel->encrypt() . '.' . $this->other_doc_image->extension;
            $model->other_doc_image_location = Yii::$app->getSecurity()->generateRandomString();
            $path = Yii::$app->params->upload_directories->emi_collection->other_doc_image->image;
            $this->fileUpload($this->other_doc_image, $model->other_doc_image, $model->other_doc_image_location, $path);
        }

        if ($this->borrower_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->borrower_image = $utilitiesModel->encrypt() . '.' . $this->borrower_image->extension;
            $model->borrower_image_location = Yii::$app->getSecurity()->generateRandomString();
            $path = Yii::$app->params->upload_directories->emi_collection->borrower_image->image;
            $this->fileUpload($this->borrower_image, $model->borrower_image, $model->borrower_image_location, $path);
        }

        if ($this->pr_receipt_image) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->pr_receipt_image = $utilitiesModel->encrypt() . '.' . $this->pr_receipt_image->extension;
            $model->pr_receipt_image_location = Yii::$app->getSecurity()->generateRandomString();
            $path = Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image;
            $this->fileUpload($this->pr_receipt_image, $model->pr_receipt_image, $model->pr_receipt_image_location, $path);
        }
        if (!$model->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()];
        }

        $return = ['status' => 200, 'message' => 'Saved Successfully'];

        if ($model->emi_payment_mode == 1) {
            if (in_array($model->emi_payment_method, [1, 2])) {
                $options = [];
                $options['emi_collection_enc_id'] = $model->emi_collection_enc_id;
                $options['user_id'] = $user_id;
                $options['org_id'] = $this->org_id;
                $options['amount'] = $this->amount;
                $options['description'] = 'Emi collection for ' . $this->loan_type;
                $options['name'] = $this->customer_name;
                $options['contact'] = $this->phone;
                $options['call_back_url'] = Yii::$app->params->EmpowerYouth->callBack . "/payment/transaction";
                $options['brand'] = $this->brand;
                $options['purpose'] = $this->loan_type;
                $link = self::createLinks($options, $model->emi_payment_method);
                if (!$link) {
                    return ['status' => 500, 'message' => 'an error occurred while fetching link'];
                }
                $return['links'] = $link;
            }
        }
        return $return;
    }

    private function createLinks($options, $type)
    {
        $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
        if (!$keys) {
            return ['status' => 500, 'message' => 'an error occurred while fetching razorpay credentials'];
        }
        $api_key = $keys['api_key'];
        $api_secret = $keys['api_secret'];
        $api = new Api($api_key, $api_secret);
        $options['ref_id'] = 'EMPL-' . Yii::$app->security->generateRandomString(8);
        if ($type == 1) {
            $options['close_by'] = time() + 24 * 60 * 60;
            $link['qr'] = \common\models\payments\Payments::createQr($api, $options);
            if (!$link) {
                return ['status' => 500, 'message' => 'an error occurred while creating qr'];
            }
        }
        if ($type == 2) {
            $options['close_by'] = time() + 24 * 60 * 60 * 7;
            $link['link'] = \common\models\payments\Payments::createLink($api, $options);
            if (!$link) {
                return ['status' => 500, 'message' => 'an error occurred while creating link'];
            }
        }
        return $link ?? false;
    }


    private function fileUpload($img_obj, $image, $image_location, $path)
    {
        $base_path = $path . $image_location;
        $type = $img_obj->type;
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($img_obj->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . DIRECTORY_SEPARATOR . $image, "private", ['params' => ['ContentType' => $type]]);
        if (!$result) {
            throw new \Exception('error occurred while uploading logo');
        }
    }
}
