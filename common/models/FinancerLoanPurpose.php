<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_loan_purpose}}".
 *
 * @property int $id
 * @property string $financer_loan_purpose_enc_id
 * @property string $assigned_financer_loan_type_id
 * @property string $purpose
 * @property int $sequence
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted
 *
 * @property AssignedFinancerLoanTypes $assignedFinancerLoanType
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class FinancerLoanPurpose extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_loan_purpose}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_loan_purpose_enc_id', 'assigned_financer_loan_type_id', 'purpose', 'sequence', 'created_by'], 'required'],
            [['sequence', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['financer_loan_purpose_enc_id', 'assigned_financer_loan_type_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['purpose'], 'string', 'max' => 200],
            [['financer_loan_purpose_enc_id'], 'unique'],
            [['assigned_financer_loan_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedFinancerLoanTypes::className(), 'targetAttribute' => ['assigned_financer_loan_type_id' => 'assigned_financer_enc_id']],
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
