<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_loan_status}}".
 *
 * @property int $id
 * @property string $financer_loan_status_enc_id financer loan status enc id
 * @property string $assigned_financer_loan_type_id assigned financer loan type id
 * @property string $loan_status_enc_id loan status enc id
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property AssignedFinancerLoanTypes $assignedFinancerLoanType
 * @property LoanStatus $loanStatusEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class FinancerLoanStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_loan_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_loan_status_enc_id', 'assigned_financer_loan_type_id', 'loan_status_enc_id', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['financer_loan_status_enc_id', 'assigned_financer_loan_type_id', 'loan_status_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['financer_loan_status_enc_id'], 'unique'],
            [['assigned_financer_loan_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedFinancerLoanTypes::className(), 'targetAttribute' => ['assigned_financer_loan_type_id' => 'assigned_financer_enc_id']],
            [['loan_status_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanStatus::className(), 'targetAttribute' => ['loan_status_enc_id' => 'loan_status_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanTypes()
    {
        return $this->hasOne(AssignedFinancerLoanTypes::className(), ['assigned_financer_enc_id' => 'assigned_financer_loan_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanStatusEnc()
    {
        return $this->hasOne(LoanStatus::className(), ['loan_status_enc_id' => 'loan_status_enc_id']);
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
