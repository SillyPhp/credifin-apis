<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_payments}}".
 *
 * @property int $id
 * @property string $loan_payments_enc_id loan payment encrypted id
 * @property string $payment_token payment id
 * @property string $payment_short_url in case of razor pay
 * @property int $payment_link_type 0 for link, 1 for qr
 * @property double $payment_amount
 * @property double $payment_gst
 * @property string $payment_id transaction id
 * @property string $payment_status payment status
 * @property int $payment_mode 0 as gateway payment, 1 as NEFT, 2 as RTGS, 3 as IMPS, 4 as Cheque, 5 as UPI, 6 as DD, 7 as Cash, 8 as Credit Card, 9 as Debit Card
 * @property string $reference_number Number of payment mode
 * @property string $remarks Any remarks or reason for Refund
 * @property string $payment_signature
 * @property string $payment_source
 * @property string $image Receipt
 * @property string $image_location Receipt Location
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property string $close_by
 *
 * @property AssignedLoanPayments[] $assignedLoanPayments
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanPaymentsDetails[] $loanPaymentsDetails
 * @property LoanPaymentsLogs[] $loanPaymentsLogs
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
            [['loan_payments_enc_id', 'payment_amount'], 'required'],
            [['payment_link_type', 'payment_mode'], 'integer'],
            [['payment_amount', 'payment_gst'], 'number'],
            [['remarks'], 'string'],
            [['created_on', 'updated_on', 'close_by'], 'safe'],
            [['loan_payments_enc_id', 'payment_token', 'payment_short_url', 'payment_id', 'payment_status', 'image', 'image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['reference_number'], 'string', 'max' => 50],
            [['payment_signature', 'payment_source'], 'string', 'max' => 255],
            [['loan_payments_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLoanPayments()
    {
        return $this->hasMany(AssignedLoanPayments::className(), ['loan_payments_enc_id' => 'loan_payments_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanPaymentsDetails()
    {
        return $this->hasMany(LoanPaymentsDetails::className(), ['loan_payments_enc_id' => 'loan_payments_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanPaymentsLogs()
    {
        return $this->hasMany(LoanPaymentsLogs::className(), ['loan_payments_enc_id' => 'loan_payments_enc_id']);
    }
}
