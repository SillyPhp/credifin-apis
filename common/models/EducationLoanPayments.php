<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%education_loan_payments}}".
 *
 * @property int $id
 * @property string $education_loan_payment_enc_id loan payment encrypted id
 * @property string $loan_app_enc_id loan application enc id
 * @property string $payment_token payment id
 * @property double $payment_amount
 * @property double $payment_gst
 * @property string $payment_id transaction id
 * @property string $payment_status payment status
 * @property int $payment_mode 0 as gateway payment, 1 as NEFT, 2 as RTGS, 3 as IMPS, 4 as Cheque, 5 as UPI, 6 as DD
 * @property string $reference_number Number of payment mode
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%education_loan_payments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['education_loan_payment_enc_id', 'loan_app_enc_id', 'payment_amount'], 'required'],
            [['payment_amount', 'payment_gst'], 'number'],
            [['payment_mode'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['education_loan_payment_enc_id', 'loan_app_enc_id', 'payment_token', 'payment_id', 'payment_status', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['reference_number'], 'string', 'max' => 50],
            [['education_loan_payment_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dsbedutech', 'ID'),
            'education_loan_payment_enc_id' => Yii::t('dsbedutech', 'Education Loan Payment Enc ID'),
            'loan_app_enc_id' => Yii::t('dsbedutech', 'Loan App Enc ID'),
            'payment_token' => Yii::t('dsbedutech', 'Payment Token'),
            'payment_amount' => Yii::t('dsbedutech', 'Payment Amount'),
            'payment_gst' => Yii::t('dsbedutech', 'Payment Gst'),
            'payment_id' => Yii::t('dsbedutech', 'Payment ID'),
            'payment_status' => Yii::t('dsbedutech', 'Payment Status'),
            'payment_mode' => Yii::t('dsbedutech', 'Payment Mode'),
            'reference_number' => Yii::t('dsbedutech', 'Reference Number'),
            'created_by' => Yii::t('dsbedutech', 'Created By'),
            'created_on' => Yii::t('dsbedutech', 'Created On'),
            'updated_by' => Yii::t('dsbedutech', 'Updated By'),
            'updated_on' => Yii::t('dsbedutech', 'Updated On'),
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
