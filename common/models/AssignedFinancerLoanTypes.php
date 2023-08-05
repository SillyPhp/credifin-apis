<?php

namespace common\models;

/**
 * This is the model class for table "{{%assigned_financer_loan_types}}".
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
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Organizations $organizationEnc
 * @property LoanTypes $loanTypeEnc
 * @property FinancerLoanProducts[] $financerLoanProducts
 */
class AssignedFinancerLoanTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_financer_loan_types}}';
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
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanTypes::className(), 'targetAttribute' => ['loan_type_enc_id' => 'loan_type_enc_id']],
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanTypeEnc()
    {
        return $this->hasOne(LoanTypes::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProducts()
    {
        return $this->hasMany(FinancerLoanProducts::className(), ['assigned_financer_loan_type_enc_id' => 'assigned_financer_enc_id']);
    }
}
