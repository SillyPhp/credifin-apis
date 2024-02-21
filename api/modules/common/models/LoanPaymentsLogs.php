<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_payments_logs}}".
 *
 * @property int $id
 * @property string $payment_log_enc_id loan payment encrypted id
 * @property string $loan_payments_enc_id
 * @property string $payment_status payment status
 * @property string $update_from
 * @property string $payment_log_json
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property LoanPayments $loanPaymentsEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class LoanPaymentsLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_payments_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_log_enc_id', 'loan_payments_enc_id'], 'required'],
            [['update_from', 'payment_log_json'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['payment_log_enc_id', 'loan_payments_enc_id', 'payment_status', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['payment_log_enc_id'], 'unique'],
            [['loan_payments_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanPayments::className(), 'targetAttribute' => ['loan_payments_enc_id' => 'loan_payments_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
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
