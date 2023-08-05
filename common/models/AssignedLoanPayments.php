<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_loan_payments}}".
 *
 * @property int $id
 * @property string $assigned_loan_payments_enc_id assigned loan payment encrypted id
 * @property string $loan_app_enc_id
 * @property string $emi_collection_enc_id
 * @property string $loan_payments_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanPayments $loanPaymentsEnc
 * @property LoanApplications $loanAppEnc
 * @property EmiCollection $emiCollectionEnc
 */
class AssignedLoanPayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_loan_payments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_loan_payments_enc_id', 'loan_payments_enc_id'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['assigned_loan_payments_enc_id', 'loan_app_enc_id', 'emi_collection_enc_id', 'loan_payments_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_loan_payments_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_payments_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanPayments::className(), 'targetAttribute' => ['loan_payments_enc_id' => 'loan_payments_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['emi_collection_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmiCollection::className(), 'targetAttribute' => ['emi_collection_enc_id' => 'emi_collection_enc_id']],
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
    public function getLoanPaymentsEnc()
    {
        return $this->hasOne(LoanPayments::className(), ['loan_payments_enc_id' => 'loan_payments_enc_id']);
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
    public function getEmiCollectionEnc()
    {
        return $this->hasOne(EmiCollection::className(), ['emi_collection_enc_id' => 'emi_collection_enc_id']);
    }
}
