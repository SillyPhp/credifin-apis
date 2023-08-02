<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_financer_loan_type}}".
 *
 * @property int $id
 * @property string $assigned_financer_enc_id
 * @property string $organization_enc_id financer id
 * @property string $loan_type_enc_id
 * @property int $status 0 false, 1 true
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property AssignedFinancerLoanPartners[] $assignedFinancerLoanPartners
 * @property LoanType $loanTypeEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Organizations $organizationEnc
 * @property FinancerLoanDocuments[] $financerLoanDocuments
 * @property FinancerLoanPurpose[] $financerLoanPurposes
 * @property FinancerLoanStatus[] $financerLoanStatuses
 */
class AssignedFinancerLoanTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_financer_loan_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_financer_enc_id', 'organization_enc_id', 'loan_type_enc_id', 'created_by'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['assigned_financer_enc_id', 'organization_enc_id', 'loan_type_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_financer_enc_id'], 'unique'],
            [['loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanType::className(), 'targetAttribute' => ['loan_type_enc_id' => 'loan_type_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanPartners()
    {
        return $this->hasMany(AssignedFinancerLoanPartners::className(), ['assigned_financer_enc_id' => 'assigned_financer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanTypeEnc()
    {
        return $this->hasOne(LoanType::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumnPreferences()
    {
        return $this->hasMany(ColumnPreferences::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanDocuments()
    {
        return $this->hasMany(FinancerLoanDocuments::className(), ['assigned_financer_loan_type_id' => 'assigned_financer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProducts()
    {
        return $this->hasMany(FinancerLoanProducts::className(), ['assigned_financer_loan_type_enc_id' => 'assigned_financer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanPurposes()
    {
        return $this->hasMany(FinancerLoanPurpose::className(), ['assigned_financer_loan_type_id' => 'assigned_financer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanStatuses()
    {
        return $this->hasMany(FinancerLoanStatus::className(), ['assigned_financer_loan_type_id' => 'assigned_financer_enc_id']);
    }
}
