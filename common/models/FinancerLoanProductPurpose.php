<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_loan_product_purpose}}".
 *
 * @property int $id
 * @property string $financer_loan_product_purpose_enc_id
 * @property string $financer_loan_product_enc_id
 * @property string $purpose
 * @property string $purpose_code
 * @property int $sequence
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted
 *
 * @property FinancerLoanProducts $financerLoanProductEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanPurpose[] $loanPurposes
 */
class FinancerLoanProductPurpose extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_loan_product_purpose}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_loan_product_purpose_enc_id', 'financer_loan_product_enc_id', 'purpose', 'sequence', 'created_by'], 'required'],
            [['sequence', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['financer_loan_product_purpose_enc_id', 'financer_loan_product_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['purpose'], 'string', 'max' => 200],
            [['purpose_code'], 'string', 'max' => 50],
            [['financer_loan_product_purpose_enc_id'], 'unique'],
            [['financer_loan_product_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProducts::className(), 'targetAttribute' => ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductEnc()
    {
        return $this->hasOne(FinancerLoanProducts::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
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
    public function getLoanPurposes()
    {
        return $this->hasMany(LoanPurpose::className(), ['financer_loan_purpose_enc_id' => 'financer_loan_product_purpose_enc_id']);
    }
}
