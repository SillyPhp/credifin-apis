<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_purpose}}".
 *
 * @property int $id
 * @property string $loan_purpose_enc_id
 * @property string $fee_component_enc_id
 * @property string $financer_loan_purpose_enc_id
 * @property string $loan_app_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property OrganizationFeeComponents $feeComponentEnc
 * @property Users $createdBy
 * @property LoanApplications $loanAppEnc
 * @property FinancerLoanProductPurpose $financerLoanPurposeEnc
 * @property Users $updatedBy
 */
class LoanPurpose extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_purpose}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_purpose_enc_id', 'loan_app_enc_id'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_purpose_enc_id', 'fee_component_enc_id', 'financer_loan_purpose_enc_id', 'loan_app_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['loan_purpose_enc_id'], 'unique'],
            [['fee_component_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationFeeComponents::className(), 'targetAttribute' => ['fee_component_enc_id' => 'fee_component_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['financer_loan_purpose_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProductPurpose::className(), 'targetAttribute' => ['financer_loan_purpose_enc_id' => 'financer_loan_product_purpose_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeComponentEnc()
    {
        return $this->hasOne(OrganizationFeeComponents::className(), ['fee_component_enc_id' => 'fee_component_enc_id']);
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
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanPurposeEnc()
    {
        return $this->hasOne(FinancerLoanProductPurpose::className(), ['financer_loan_product_purpose_enc_id' => 'financer_loan_purpose_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
