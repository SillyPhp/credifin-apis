<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%emi_payment_records}}".
 *
 * @property int $id Primary Key
 * @property string $emi_payment_records_enc_id Emi Payment Records Enc Id
 * @property string $loan_account_enc_id Loan Accounts Enc Id
 * @property string $loan_account_number Loan Account Number
 * @property string $payment_id Payment Id
 * @property string $name Name
 * @property int $type 1 for nach, 2 for e-nach
 * @property double $amount Amount
 * @property double $charges_paid
 * @property string $nach_date Nach Date
 * @property string $status Status
 * @property string $created_by Created By
 * @property string $created_on Created On
 * @property string $updated_by Updated By
 * @property string $updated_on Updated On
 * @property int $is_deleted Is Deleted
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanAccounts $loanAccountEnc
 */
class EmiPaymentRecords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%emi_payment_records}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emi_payment_records_enc_id', 'loan_account_number', 'name', 'type', 'amount', 'nach_date', 'status', 'created_by', 'created_on', 'updated_by', 'updated_on'], 'required'],
            [['type', 'is_deleted'], 'integer'],
            [['amount', 'charges_paid'], 'number'],
            [['nach_date', 'created_on', 'updated_on'], 'safe'],
            [['emi_payment_records_enc_id', 'loan_account_enc_id', 'loan_account_number', 'payment_id', 'name', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 50],
            [['emi_payment_records_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_account_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanAccounts::className(), 'targetAttribute' => ['loan_account_enc_id' => 'loan_account_enc_id']],
        ];
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
    public function getLoanAccountEnc()
    {
        return $this->hasOne(LoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }
}
