<?php

namespace common\models;


/**
 * This is the model class for table "{{%education_loan_payments}}".
 *
 * @property int $id
 * @property string $education_loan_payment_enc_id loan payment encrypted id
 * @property string $loan_app_enc_id loan application enc id
 * @property string $college_enc_id
 * @property string $payment_token payment id
 * @property string $payment_short_url in case of razor pay
 * @property double $payment_amount
 * @property double $payment_gst
 * @property string $payment_id transaction id
 * @property string $payment_status payment status
 * @property int $payment_mode 0 as gateway payment, 1 as NEFT, 2 as RTGS, 3 as IMPS, 4 as Cheque, 5 as UPI, 6 as DD, 7 as Cash, 8 as Credit Card, 9 as Debit Card
 * @property string $reference_number Number of payment mode
 * @property string $remarks Any remarks or reason for Refund
 * @property string $payment_signature
 * @property string $image Receipt
 * @property string $image_location Receipt Location
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class EducationLoanPayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%education_loan_payments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['education_loan_payment_enc_id', 'loan_app_enc_id', 'payment_amount'], 'required'],
            [['payment_amount', 'payment_gst'], 'number'],
            [['payment_mode'], 'integer'],
            [['remarks'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['education_loan_payment_enc_id', 'loan_app_enc_id', 'college_enc_id', 'payment_token', 'payment_short_url', 'payment_id', 'payment_status', 'image', 'image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['reference_number'], 'string', 'max' => 50],
            [['payment_signature'], 'string', 'max' => 255],
            [['education_loan_payment_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'education_loan_payment_enc_id' => 'Education Loan Payment Enc ID',
            'loan_app_enc_id' => 'Loan App Enc ID',
            'college_enc_id' => 'College Enc ID',
            'payment_token' => 'Payment Token',
            'payment_short_url' => 'Payment Short Url',
            'payment_amount' => 'Payment Amount',
            'payment_gst' => 'Payment Gst',
            'payment_id' => 'Payment ID',
            'payment_status' => 'Payment Status',
            'payment_mode' => 'Payment Mode',
            'reference_number' => 'Reference Number',
            'remarks' => 'Remarks',
            'payment_signature' => 'Payment Signature',
            'image' => 'Image',
            'image_location' => 'Image Location',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
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
}
