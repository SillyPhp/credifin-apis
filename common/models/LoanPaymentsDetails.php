<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_payments_details}}".
 *
 * @property int $id Primary Id
 * @property string $loan_payments_details_enc_id Loan Payments Details Enc  Id
 * @property string $loan_payments_enc_id Loan Payments Enc Id
 * @property string $financer_loan_product_login_fee_structure_enc_id Fees enc id
 * @property string $no_dues_name No Dues Name
 * @property double $no_dues_amount No Dues Amount
 * @property string $created_by Created By
 * @property string $created_on Created On
 * @property int $is_deleted Is Deleted
 *
 * @property LoanPayments $loanPaymentsEnc
 * @property Users $createdBy
 * @property FinancerLoanProductLoginFeeStructure $financerLoanProductLoginFeeStructureEnc
 */
class LoanPaymentsDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_payments_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_payments_details_enc_id', 'loan_payments_enc_id', 'financer_loan_product_login_fee_structure_enc_id', 'no_dues_name', 'no_dues_amount', 'created_by'], 'required'],
            [['no_dues_amount'], 'number'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_payments_details_enc_id', 'loan_payments_enc_id', 'financer_loan_product_login_fee_structure_enc_id', 'created_by'], 'string', 'max' => 100],
            [['no_dues_name'], 'string', 'max' => 50],
            [['loan_payments_details_enc_id'], 'unique'],
            [['loan_payments_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanPayments::className(), 'targetAttribute' => ['loan_payments_enc_id' => 'loan_payments_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['financer_loan_product_login_fee_structure_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProductLoginFeeStructure::className(), 'targetAttribute' => ['financer_loan_product_login_fee_structure_enc_id' => 'financer_loan_product_login_fee_structure_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanPaymentsEnc()
    {
        return $this->hasOne(LoanPayments::className(), ['loan_payments_enc_id' => 'loan_payments_enc_id']);
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
    public function getFinancerLoanProductLoginFeeStructureEnc()
    {
        return $this->hasOne(FinancerLoanProductLoginFeeStructure::className(), ['financer_loan_product_login_fee_structure_enc_id' => 'financer_loan_product_login_fee_structure_enc_id']);
    }
}
