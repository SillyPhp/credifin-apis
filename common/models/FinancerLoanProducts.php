<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_loan_products}}".
 *
 * @property int $id
 * @property string $financer_loan_product_enc_id assigned financer loan product enc id
 * @property string $assigned_financer_loan_type_enc_id assigned financer loan type enc id
 * @property string $name product name
 * @property string $product_code
 * @property string $created_on created on
 * @property string $created_by created by
 * @property string $updated_on updated on
 * @property string $updated_by updated by
 * @property int $is_deleted 0 false, 1 true
 *
 * @property ColumnPreferences[] $columnPreferences
 * @property FinancerLoanProductDocuments[] $financerLoanProductDocuments
 * @property FinancerLoanProductImages[] $financerLoanProductImages
 * @property FinancerLoanProductLoginFeeStructure[] $financerLoanProductLoginFeeStructures
 * @property FinancerLoanProductPendencies[] $financerLoanProductPendencies
 * @property FinancerLoanProductProcess[] $financerLoanProductProcesses
 * @property FinancerLoanProductPurpose[] $financerLoanProductPurposes
 * @property FinancerLoanProductStatus[] $financerLoanProductStatuses
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property AssignedFinancerLoanTypes $assignedFinancerLoanTypeEnc
 * @property FinancerRewards[] $financerRewards
 * @property LoanApplications[] $loanApplications
 */
class FinancerLoanProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_loan_products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_loan_product_enc_id', 'assigned_financer_loan_type_enc_id', 'name', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['financer_loan_product_enc_id', 'assigned_financer_loan_type_enc_id', 'name', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['product_code'], 'string', 'max' => 20],
            [['financer_loan_product_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['assigned_financer_loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedFinancerLoanTypes::className(), 'targetAttribute' => ['assigned_financer_loan_type_enc_id' => 'assigned_financer_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumnPreferences()
    {
        return $this->hasMany(ColumnPreferences::className(), ['loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductDocuments()
    {
        return $this->hasMany(FinancerLoanProductDocuments::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductImages()
    {
        return $this->hasMany(FinancerLoanProductImages::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductLoginFeeStructures()
    {
        return $this->hasMany(FinancerLoanProductLoginFeeStructure::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductPendencies()
    {
        return $this->hasMany(FinancerLoanProductPendencies::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductProcesses()
    {
        return $this->hasMany(FinancerLoanProductProcess::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductPurposes()
    {
        return $this->hasMany(FinancerLoanProductPurpose::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductStatuses()
    {
        return $this->hasMany(FinancerLoanProductStatus::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
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
    public function getAssignedFinancerLoanTypeEnc()
    {
        return $this->hasOne(AssignedFinancerLoanTypes::className(), ['assigned_financer_enc_id' => 'assigned_financer_loan_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerRewards()
    {
        return $this->hasMany(FinancerRewards::className(), ['loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplications()
    {
        return $this->hasMany(LoanApplications::className(), ['loan_products_enc_id' => 'financer_loan_product_enc_id']);
    }
}
