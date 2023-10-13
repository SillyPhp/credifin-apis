<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_disbursement_charges}}".
 *
 * @property int $id
 * @property string $assigned_disbursement_charges_enc_id
 * @property string $disbursement_charges_enc_id
 * @property string $loan_app_enc_id
 * @property string $name
 * @property double $amount
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_on
 * @property string $updated_by
 * @property int $is_deleted
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property FinancerLoanProductDisbursementCharges $disbursementChargesEnc
 */
class AssignedDisbursementCharges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_disbursement_charges}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_disbursement_charges_enc_id', 'disbursement_charges_enc_id', 'loan_app_enc_id', 'name', 'amount', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['amount'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_disbursement_charges_enc_id', 'disbursement_charges_enc_id', 'loan_app_enc_id', 'name', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_disbursement_charges_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['disbursement_charges_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProductDisbursementCharges::className(), 'targetAttribute' => ['disbursement_charges_enc_id' => 'disbursement_charges_enc_id']],
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementChargesEnc()
    {
        return $this->hasOne(FinancerLoanProductDisbursementCharges::className(), ['disbursement_charges_enc_id' => 'disbursement_charges_enc_id']);
    }
}
