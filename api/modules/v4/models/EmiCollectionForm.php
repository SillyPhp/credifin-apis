<?php

namespace api\modules\v4\models;

use api\modules\v4\utilities\UserUtilities;
use common\models\EmiCollection;
use common\models\extended\EmiCollectionExtended;
use common\models\extended\EmployeesCashReportExtended;
use common\models\extended\LoanAccountsExtended;
use common\models\LoanAccountPtps;
use common\models\LoanAccounts;
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
    public $ptp_payment_method;
    public $ptp_collection_manager;
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
    public $loan_account_enc_id;
    public $collection_date;
    public $customer_interaction;
    public $customer_visit;
    public $loan_app_enc_id;
    public static $payment_methods = [
        'total' => 'Total',
        '1' => 'QR',
        '2' => 'Link',
        // '3' => 'POS',
        '4' => 'Cash',
        '10' => 'Digital Transfer',
        '5' => 'Cheque',
        '6' => 'Nach/Enach',
        '7' => 'Nach/Enach',
        '81' => 'Cash',
        '82' => 'Cheque',
        '83' => 'Net Banking',
        '84' => 'RTGS/NEFT',
        '9' => 'QR',
        '11' => 'Paid To Dealer',
        // 'paid' => 'Paid',
        '0' => 'PTP',
        'pending' => 'Pending',
        // 'collected' => 'Collected',
        // 'pipeline' => 'Pipeline',
        'rejected' => 'Rejected',
        'failed' => 'Failed',
    ];
    public static $payment_modes = [
        '0' => 'Not Collected',
        '1' => 'Pay Now',
        '2' => 'Manual Collection',
        '3' => 'Pay By EOD',
        '4' => 'Online Off System Transaction',

        '21' => 'Pay Now',
        '22' => 'Manual Collection',
        '23' => 'Pay By EOD',
        '24' => 'Online Off System Transaction',
    ];

    public static $modes_methods = [
        '1' => ['1', '2', '3'],
        '2' => ['4', '5'],
        '3' => ['6', '7'],
        '4' => ['81', '82', '83', '84', '9', '10', '11']
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
                return !in_array($model->payment_mode, [0, 1]);
            }],
            [['dealer_name'], 'required', 'when' => function ($model) {
                return $model->payment_method == 11;
            }],
            [['ptp_amount', 'ptp_date', 'customer_interaction', 'customer_visit', 'collection_date', 'ptp_payment_method', 'ptp_collection_manager', 'delay_reason', 'other_delay_reason', 'other_doc_image', 'payment_method', 'borrower_image', 'loan_purpose', 'comments', 'other_payment_method', 'address', 'state', 'city', 'postal_code', 'loan_account_enc_id', 'loan_app_enc_id'], 'safe'],
            [['amount', 'ptp_amount', 'latitude', 'longitude'], 'number'],
            [['ptp_date'], 'date', 'format' => 'php:Y-m-d'],
            [['other_doc_image', 'borrower_image', 'pr_receipt_image'], 'file', 'skipOnEmpty' => True, 'extensions' => 'png, jpg'],
        ];
    }

    public function save($user_id)
    {
        $loan_num_temp = strtolower(preg_replace('/[^a-zA-Z0-9\']/', '', $this->loan_account_number));
        $condition = "LOWER(REGEXP_REPLACE(loan_account_number, '[^a-zA-Z0-9]', '')) = '$loan_num_temp'";
        $loan_find = LoanAccounts::find()->select(['loan_account_enc_id', 'company_id', 'case_no', 'loan_account_number'])->where($condition)->asArray()->one();
        $loan_account_number = $this->loan_account_number;

        $model = new EmiCollectionExtended();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->emi_collection_enc_id = $utilitiesModel->encrypt();

        if ($loan_find) {
            $loan_account_number = $loan_find['loan_account_number'];
            $model->loan_account_enc_id = $loan_find['loan_account_enc_id'];
            $model->company_id = $loan_find['company_id'];
            $model->case_no = $loan_find['case_no'];
        } elseif ($this->loan_type == 'Loan Against Property' || $this->loan_type == 'MSME') {
            $model->company_id = '01';
        } elseif ($this->loan_type == 'E-Rickshaw') {
            $model->company_id = '25';
        }
        $loan_account_number = str_replace(' ', '', $loan_account_number);

        $model->customer_interaction = $this->customer_interaction;
        $model->customer_visit = $this->customer_visit;
        $model->branch_enc_id = $this->branch_enc_id;
        $model->customer_name = $this->customer_name;
        if (!in_array($this->payment_mode, [0, 1])) {
            $model->collection_date = !empty($this->collection_date) ? $this->collection_date : date('Y-m-d');
        }
        $model->transaction_initiated_date = date('Y-m-d');
        $model->loan_account_number = $loan_account_number;
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
        $model->created_on = $model->updated_on = date('Y-m-d H:i:s');
        if ($this->ptp_amount && $this->ptp_date) {
            $model->ptp_amount = $this->ptp_amount;
            $model->ptp_date = $this->ptp_date;
            $model->ptp_payment_method = $this->ptp_payment_method;
        }
        if ($this->comments) {
            $model->comments = $this->comments;
        }
        if ($this->delay_reason) {
            $model->delay_reason = $this->delay_reason;
        }
        if ($this->other_delay_reason) {
            $model->other_delay_reason = $this->other_delay_reason;
        }
        $model->emi_payment_mode = $this->payment_mode;
        $model->emi_payment_method = $this->payment_method;
        $model->emi_payment_status = in_array($this->payment_method, [5, 9, 10, 81, 82, 83, 84]) ? 'pipeline' : ($this->payment_method == 4 ? 'collected' : ($this->amount == 0 ? 'not paid' : 'pending'));
        $model->dealer_name = $this->dealer_name ?? '';
        $model->reference_number = $this->reference_number ?? '';
        if ($this->other_doc_image) {
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->other_doc_image = $utilitiesModel->encrypt() . '.' . $this->other_doc_image->extension;
            $model->other_doc_image_location = Yii::$app->getSecurity()->generateRandomString();
            $path = Yii::$app->params->upload_directories->emi_collection->other_doc_image->image;
            $this->fileUpload($this->other_doc_image, $model->other_doc_image, $model->other_doc_image_location, $path);
        }

        if ($this->borrower_image) {
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->borrower_image = $utilitiesModel->encrypt() . '.' . $this->borrower_image->extension;
            $model->borrower_image_location = Yii::$app->getSecurity()->generateRandomString();
            $path = Yii::$app->params->upload_directories->emi_collection->borrower_image->image;
            $this->fileUpload($this->borrower_image, $model->borrower_image, $model->borrower_image_location, $path);
        }

        if (!in_array($this->payment_method, ["0", "1", "2", "6", "7"]) && !$this->pr_receipt_image) {
            throw new \Exception('pr receipt is required');
        }
        if ($this->pr_receipt_image) {
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->pr_receipt_image = $utilitiesModel->encrypt() . '.' . $this->pr_receipt_image->extension;
            $model->pr_receipt_image_location = Yii::$app->getSecurity()->generateRandomString();
            $path = Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image;
            $this->fileUpload($this->pr_receipt_image, $model->pr_receipt_image, $model->pr_receipt_image_location, $path);
        }
        // visit_charges only in manual cash payment 
        if (!empty(Yii::$app->params->charges->visit_charges)) {
            $visit_charges = Yii::$app->params->charges->visit_charges;
            $model->visit_charges = $visit_charges;
        }
        if (!$model->save()) {
            throw new \Exception(implode(", ", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
        }


        if ($this->ptp_amount && $this->ptp_date) {

            $ptp_model = new LoanAccountPtps;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $ptp_model->ptp_enc_id = $utilitiesModel->encrypt();
            $ptp_model->emi_collection_enc_id = $model->emi_collection_enc_id;
            $ptp_model->proposed_date = $this->ptp_date;
            $ptp_model->proposed_amount = $this->ptp_amount;
            $ptp_model->proposed_payment_method = $this->ptp_payment_method;
            $ptp_model->collection_manager = $this->ptp_collection_manager;
            $ptp_model->created_by = $user_id;
            $ptp_model->created_on = date('Y-m-d H:i:s');

            if (!$ptp_model->save()) {
                throw new \Exception(implode(", ", \yii\helpers\ArrayHelper::getColumn($ptp_model->errors, 0, false)));
            }
        }

        if ($model->emi_payment_method == 4 && !empty($this->amount)) {
            $trackCash['user_id'] = $trackCash['given_to'] = $user_id;
            $trackCash['amount'] = $this->amount;
            $trackCash['emi_id'] = $model->emi_collection_enc_id;
            $trackCash['visit_charges'] = $visit_charges ?? 0;
            $this->collect_cash($trackCash);
        }

        $return = ['status' => 200, 'message' => 'Saved Successfully'];
        if (in_array($model->emi_payment_mode, [0, 1])) {
            $options = [];
            if (!empty($this->loan_app_enc_id)) {
                $options['loan_app_enc_id'] = $this->loan_app_enc_id;
            }
            $options['emi_collection_enc_id'] = $model->emi_collection_enc_id;
            $options['user_id'] = $user_id;
            $options['org_id'] = $this->org_id;
            $options['description'] = 'EMI Collection for ' . $loan_account_number;
            $options['name'] = $this->customer_name;
            $options['contact'] = $this->phone;
            $options['call_back_url'] = Yii::$app->params->EmpowerYouth->callBack . "/payment/transaction";
            $options['brand'] = $this->brand;
            $options['purpose'] = $this->loan_type;
            if ($model->emi_payment_mode == 1) {
                $options['amount'] = $this->amount;
                $link = self::createLinks($options, $model->emi_payment_method);
                $return['links'] = $link;
            } else {
                $options['amount'] = $this->ptp_amount;
                $options['close_by'] = strtotime($this->ptp_date . ' 23:59:59');
                self::createLinks($options, 2);
            }
        }
        return $return;
    }


    private function createLinks($options, $type)
    {
        $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
        if (!$keys) {
            throw new \Exception('an error occurred while fetching razorpay credentials');
        }
        $api_key = $keys['api_key'];
        $api_secret = $keys['api_secret'];
        $api = new Api($api_key, $api_secret);
        $options['ref_id'] = 'EMPL-' . Yii::$app->security->generateRandomString(8);
        if (empty($options['close_by'])) {
            $options['close_by'] = time() + 24 * 60 * 60 * 30;
        }
        if ($type == 1) {
            $link['qr'] = \common\models\payments\Payments::createQr($api, $options);
            if (!$link['qr']) {
                throw new \Exception('an error occurred while creating qr');
            }
        }
        if ($type == 2) {
            $link['link'] = \common\models\payments\Payments::createLink($api, $options);
            if (!$link['link']) {
                throw new \Exception('an error occurred while creating link');
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

    public static function collect_cash($data)
    {
        if (!empty($data['type'])) {
            if (!in_array($data['type'], [1, 2])) {
                throw new \Exception('invalid type');
            }
        }
        // if cash id is received then the person is giving received money to someone else
        // otherwise person is giving money to someone else received from customer
        if (empty($data['cash_ids'])) {
            if (empty($data['emi_id'])) {
                throw new \Exception('missing parameter "emi_id"');
            }
            $emi_id = $data['emi_id'];
        }
        if (!empty($data['given_to']) && !empty($data['received_from'])) {
            // if person is giving money to himself by mistake then sending error
            if ($data['given_to'] == $data['received_from']) {
                throw new \Exception('sender and receiver can not be same');
            }
        }
        $query = new EmployeesCashReportExtended();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $query->cash_report_enc_id = $utilitiesModel->encrypt();
        $query->received_from = !empty($data['type']) ? $data['received_from'] : null;
        $query->emi_collection_enc_id = empty($data['type']) && !empty($emi_id) ? $emi_id : null;
        $query->given_to = empty($data['type']) || $data['type'] != 1 ? $data['given_to'] : null;
        $query->type = !empty($data['type']) ? $data['type'] : 0;
        if (!empty($data['specialroles'])) {
            $query->approved_on = date('Y-m-d H:i:s');
            $query->approved_by = $data['user_id'];
            $status = 1;
        } else {
            $status = !empty($data['cash_ids']) ? 2 : 0;
            if (!empty($query->received_from)) {
                Yii::$app->db->createCommand()->update(EmiCollection::tableName(), [
                    "emi_payment_status" => 'pipeline',
                    "updated_on" => date("Y-m-d H:i:s"),
                    "updated_by" => $data['user_id']
                ], [
                    "emi_collection_enc_id" => !empty($emi_id) ? $emi_id : null
                ])->execute();
            }
        }

        $amount = !empty($data['visit_charges']) ? $data['amount'] + $data['visit_charges'] : $data['amount'];
        $query->status = $status;
        $query->remarks = !empty($data['remarks']) ? $data['remarks'] : '';
        $query->amount = $amount;
        $query->remaining_amount = $amount;
        $query->created_by = $query->updated_by = $data['user_id'];
        $query->created_on = $query->updated_on = date('Y-m-d H:i:s');


        if (!empty($data['type']) && $data['type'] == 1) {
            $image_parts = explode(";base64,", $data['receipt']);
            $image_base64 = base64_decode($image_parts[1]);
            $ext = explode(':', $image_parts[0])[1];
            $type = explode('/', $ext)[1];
            $query->image = $utilitiesModel->encrypt() . '.' . $type;
            $query->image_location = Yii::$app->getSecurity()->generateRandomString();
            $query->reference_number = $data['reference_number'];
            $path = Yii::$app->params->upload_directories->cash_report->image;
            $base_path = $path . $query->image_location . DIRECTORY_SEPARATOR . $query->image;
            $file = dirname(__DIR__, 4) . '/files/temp/' . $query->image;

            if (file_put_contents($file, $image_base64)) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path, "private", ['params' => ['ContentType' => $ext]]);
                if (!$result) {
                    throw new \Exception('error occurred while saving image');
                }
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
        if (!$query->save()) {
            throw new \Exception(implode(", ", \yii\helpers\ArrayHelper::getColumn($query->errors, 0, false)));
        }
        if (!empty($data['cash_ids'])) {
            $cash_ids = explode(',', $data['cash_ids']);
            $update = [
                'parent_cash_report_enc_id' => $query->cash_report_enc_id,
                'updated_on' => date('Y-m-d H:i:s'),
                'updated_by' => $data['user_id'],
                'remaining_amount' => 0
            ];
            $where = ['cash_report_enc_id' => $cash_ids, 'parent_cash_report_enc_id' => null];
            if (!UserUtilities::updating("cash", "cash_report_enc_id", $where, $update)) {
                throw new \Exception("Duplicate request");
            }
        }
        return true;
    }

    public static function updateOverdue($loan_id, $amount, $user_id = ""): void
    {
        $query = LoanAccountsExtended::findOne(["loan_account_enc_id" => $loan_id]);
        if ($query) {
            $query->overdue_amount -= $amount;
            if (!empty($user_id)) {
                $query->updated_by = $user_id;
                $query->updated_on = date('Y-m-d H:i:s');
            }
            if (!$query->save()) {
                throw new \Exception("error occurred while updating overdue amount");
            }
        }
    }
}
