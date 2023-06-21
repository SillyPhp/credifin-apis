<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%emi_collection}}".
 *
 * @property int $id Primary Key
 * @property string $emi_collection_enc_id Emi Collection Enc Id
 * @property string $customer_name Customer Name
 * @property string $collection_date Collection Date
 * @property string $loan_account_number Loan Account Number
 * @property string $phone Phone Number
 * @property float $amount Amount
 * @property string $loan_type Loan Type
 * @property string|null $loan_purpose Loan Purpose
 * @property string|null $payment_method Payment Method
 * @property string|null $other_payment_method Other Payment Method
 * @property float|null $ptp_amount Ptp Amount
 * @property string|null $ptp_date Ptp Date
 * @property string|null $delay_reason Delay Reason
 * @property string|null $other_delay_reason Other Delay Reason
 * @property string|null $location_image Location Image
 * @property string|null $location_image_location Location Image Location
 * @property string|null $borrower_image Borrower Image
 * @property string|null $borrower_image_location Borrower Image Location
 * @property string|null $pr_receipt_image Pr Receipt
 * @property string|null $pr_receipt_image_location Pr Receipt Location
 * @property string|null $address Address
 * @property string|null $state_enc_id State Enc Id
 * @property string|null $city_enc_id City Enc Id
 * @property string|null $pincode Pincode
 * @property string|null $comments Comments
 * @property string $created_by Created By
 * @property string $created_on Created On
 * @property string|null $updated_by Updated By
 * @property string|null $updated_on Updated On
 * @property int $is_deleted Is Deleted
 *
 * @property Cities $cityEnc
 * @property Users $createdBy
 * @property States $stateEnc
 * @property Users $updatedBy
 */
class EmiCollection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%emi_collection}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emi_collection_enc_id', 'customer_name', 'collection_date', 'loan_account_number', 'phone', 'amount', 'loan_type', 'created_by', 'created_on'], 'required'],
            [['collection_date', 'ptp_date', 'created_on', 'updated_on'], 'safe'],
            [['amount', 'ptp_amount'], 'number'],
            [['address', 'comments'], 'string'],
            [['is_deleted'], 'integer'],
            [['emi_collection_enc_id', 'customer_name', 'loan_account_number', 'loan_type', 'loan_purpose', 'delay_reason', 'other_delay_reason', 'location_image', 'location_image_location', 'borrower_image', 'borrower_image_location', 'pr_receipt_image', 'pr_receipt_image_location', 'state_enc_id', 'city_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['payment_method'], 'string', 'max' => 30],
            [['other_payment_method'], 'string', 'max' => 50],
            [['pincode'], 'string', 'max' => 8],
            [['emi_collection_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['state_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_enc_id' => 'state_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
        ];
    }

    /**
     * Gets query for [[CityEnc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * Gets query for [[StateEnc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStateEnc()
    {
        return $this->hasOne(States::className(), ['state_enc_id' => 'state_enc_id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
