<?php

namespace api\modules\v4\models;

use common\models\ProductEnquiry;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class EnquiryForm extends Model
{
    public $product_id;
    public $first_name;
    public $last_name;
    public $email;
    public $mobile_number;
    public $message;
    public $status;
    public $created_by;
    public $enquiry_enc_id;
    public $is_deleted;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['product_id', 'first_name', 'last_name', 'email', 'mobile_number', 'message'], 'required'],
            [['status', 'enquiry_enc_id', 'created_by', 'is_deleted'], 'safe'],
            [['first_name', 'last_name', 'email'], 'trim'],
        ];
    }

    public function create()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $enquiry = new ProductEnquiry();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $enquiry->enquiry_enc_id = $utilitiesModel->encrypt();
            $enquiry->product_id = $this->product_id;
            $enquiry->first_name = $this->first_name;
            $enquiry->last_name = $this->last_name;
            $enquiry->email = $this->email;
            $enquiry->mobile_number = $this->mobile_number;
            $enquiry->message = $this->message;
            $enquiry->created_by = $this->created_by;
            $enquiry->created_on = date('Y-m-d H:i:s');
            if (!$enquiry->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $enquiry->getErrors()];
            }
            $transaction->commit();

            return ['status' => 200, 'message' => 'successfully saved'];

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }


    public function update($identity)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $enquiry = ProductEnquiry::findOne(['enquiry_enc_id' => $this->enquiry_enc_id]);
            if (!empty($enquiry)) {
                $enquiry->status = $this->status;
                $enquiry->updated_by = $identity;
                $enquiry->updated_on = date('Y-m-d H:i:s');
                if (!$enquiry->update()) {
                    $transaction->rollBack();
                    return ['status' => 500, 'message' => 'an error occurred', 'error' => $enquiry->getErrors()];
                }
                $transaction->commit();
                return ['status' => 200, 'message' => 'successfully updated'];

            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }
}