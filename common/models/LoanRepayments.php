<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_repayments}}".
 *
 * @property int $id
 * @property string $repayment_enc_id loan structure enc Id
 * @property string $loan_structure_enc_id customer structure enc id
 * @property double $total_emi_amount monthly emi
 * @property string $start_date
 * @property string $end_date
 * @property int $emi_cycle 30 as 30 days biling cycle or 15 as 15 days cycle
 * @property int $instalment_count counted as if 1 ,2,3 ( total number of emi)
 * @property string $payment_token
 * @property string $payment_short_url
 * @property string $transaction_id
 * @property string $payment_signature
 * @property string $payment_status
 * @property string $payment_mode
 * @property string $comments
 * @property string $created_on created on
 * @property string $created_by created by
 * @property string $last_updated_on last updated on
 * @property string $last_updated_by last updated by
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property LoanEmiStructure $loanStructureEnc
 */
class LoanRepayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_repayments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['repayment_enc_id', 'loan_structure_enc_id', 'total_emi_amount', 'start_date', 'end_date', 'payment_status', 'created_by'], 'required'],
            [['total_emi_amount'], 'number'],
            [['start_date', 'end_date', 'created_on', 'last_updated_on'], 'safe'],
            [['emi_cycle', 'instalment_count'], 'integer'],
            [['payment_status'], 'string'],
            [['repayment_enc_id', 'loan_structure_enc_id', 'payment_token', 'payment_short_url', 'transaction_id', 'payment_mode', 'comments', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['payment_signature'], 'string', 'max' => 255],
            [['repayment_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['loan_structure_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanEmiStructure::className(), 'targetAttribute' => ['loan_structure_enc_id' => 'loan_structure_enc_id']],
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanStructureEnc()
    {
        return $this->hasOne(LoanEmiStructure::className(), ['loan_structure_enc_id' => 'loan_structure_enc_id']);
    }
}
