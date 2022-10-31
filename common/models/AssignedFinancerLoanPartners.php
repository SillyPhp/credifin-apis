<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_financer_loan_partners}}".
 *
 * @property int $id
 * @property string $assigned_loan_partner_enc_id
 * @property string $assigned_financer_enc_id
 * @property string $loan_partner_enc_id Foreign key to users table
 * @property double $ltv LTV in percentage
 * @property string $created_on
 * @property string $created_by Foreign key to users table
 * @property string $updated_on
 * @property string $updated_by Foreign key to users table
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property Users $loanPartnerEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property AssignedFinancerLoanType $assignedFinancerEnc
 */
class AssignedFinancerLoanPartners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_financer_loan_partners}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_loan_partner_enc_id', 'assigned_financer_enc_id', 'created_by'], 'required'],
            [['ltv'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_loan_partner_enc_id', 'assigned_financer_enc_id', 'loan_partner_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_loan_partner_enc_id'], 'unique'],
            [['loan_partner_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['loan_partner_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['assigned_financer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedFinancerLoanType::className(), 'targetAttribute' => ['assigned_financer_enc_id' => 'assigned_financer_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanPartnerEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'loan_partner_enc_id']);
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
    public function getAssignedFinancerEnc()
    {
        return $this->hasOne(AssignedFinancerLoanType::className(), ['assigned_financer_enc_id' => 'assigned_financer_enc_id']);
    }
}
