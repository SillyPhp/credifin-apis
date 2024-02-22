<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_disbursement_schedule}}".
 *
 * @property int $id
 * @property string $disbursed_enc_id
 * @property string $loan_app_enc_id
 * @property double $amount
 * @property string $disbursed_date
 * @property string $type
 * @property string $utr_number utr number
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property Users $updatedBy
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 */
class LoanDisbursementSchedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_disbursement_schedule}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['disbursed_enc_id', 'loan_app_enc_id', 'amount', 'disbursed_date', 'type', 'created_by'], 'required'],
            [['amount'], 'number'],
            [['disbursed_date', 'created_on', 'updated_on'], 'safe'],
            [['type'], 'string'],
            [['disbursed_enc_id', 'loan_app_enc_id', 'utr_number', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['disbursed_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
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
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
