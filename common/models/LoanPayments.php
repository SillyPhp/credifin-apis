<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_payments}}".
 *
 * @property int $id
 * @property string $loan_payments_enc_id loan payment encrypted id
 * @property string $loan_app_enc_id loan application enc id
 * @property string|null $payment_token payment id
 * @property string|null $payment_short_url in case of razor pay
 * @property int|null $payment_link_type 0 for link, 1 for qr
 * @property float $payment_amount
 * @property float|null $payment_gst
 * @property string|null $payment_id transaction id
 * @property string|null $payment_status payment status
 * @property int|null $payment_mode 0 as gateway payment, 1 as NEFT, 2 as RTGS, 3 as IMPS, 4 as Cheque, 5 as UPI, 6 as DD, 7 as Cash, 8 as Credit Card, 9 as Debit Card
 * @property string|null $reference_number Number of payment mode
 * @property string|null $remarks Any remarks or reason for Refund
 * @property string|null $payment_signature
 * @property string|null $payment_source
 * @property string|null $image Receipt
 * @property string|null $image_location Receipt Location
 * @property string|null $created_by
 * @property string $created_on
 * @property string|null $updated_by
 * @property string|null $updated_on
 * @property string|null $close_by
 *
 * @property Users $createdBy
 * @property LoanApplications $loanAppEnc
 * @property LoanPaymentsDetails[] $loanPaymentsDetails
 * @property LoanPaymentsLogs[] $loanPaymentsLogs
 * @property Users $updatedBy
 */
class LoanPayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_payments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_payments_enc_id', 'loan_app_enc_id', 'payment_amount'], 'required'],
            [['payment_link_type', 'payment_mode'], 'integer'],
            [['payment_amount', 'payment_gst'], 'number'],
            [['remarks'], 'string'],
            [['created_on', 'updated_on', 'close_by'], 'safe'],
            [['loan_payments_enc_id', 'loan_app_enc_id', 'payment_token', 'payment_short_url', 'payment_id', 'payment_status', 'image', 'image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['reference_number'], 'string', 'max' => 50],
            [['payment_signature', 'payment_source'], 'string', 'max' => 255],
            [['loan_payments_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
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
     * Gets query for [[LoanAppEnc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * Gets query for [[LoanPaymentsDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoanPaymentsDetails()
    {
        return $this->hasMany(LoanPaymentsDetails::className(), ['loan_payments_enc_id' => 'loan_payments_enc_id']);
    }

    /**
     * Gets query for [[LoanPaymentsLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoanPaymentsLogs()
    {
        return $this->hasMany(LoanPaymentsLogs::className(), ['loan_payments_enc_id' => 'loan_payments_enc_id']);
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
