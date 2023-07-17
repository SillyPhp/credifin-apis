<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_loan_product_no_dues}}".
 *
 * @property int $id Primary Id
 * @property string $financer_loan_product_no_dues_enc_id Fees enc id
 * @property string $financer_loan_product_enc_id Product enc id
 * @property string $name Name
 * @property float $amount Amount
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string|null $updated_by updated by
 * @property string|null $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Users $createdBy
 * @property FinancerLoanProducts $financerLoanProductEnc
 * @property LoanPaymentsDetails[] $loanPaymentsDetails
 * @property Users $updatedBy
 */
class FinancerLoanProductNoDues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_loan_product_no_dues}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_loan_product_no_dues_enc_id', 'financer_loan_product_enc_id', 'name', 'amount', 'created_by'], 'required'],
            [['amount'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['financer_loan_product_no_dues_enc_id', 'financer_loan_product_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['financer_loan_product_no_dues_enc_id'], 'unique'],
            [['financer_loan_product_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProducts::className(), 'targetAttribute' => ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']],
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
     * Gets query for [[FinancerLoanProductEnc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductEnc()
    {
        return $this->hasOne(FinancerLoanProducts::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * Gets query for [[LoanPaymentsDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoanPaymentsDetails()
    {
        return $this->hasMany(LoanPaymentsDetails::className(), ['loan_no_dues_enc_id' => 'financer_loan_product_no_dues_enc_id']);
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
