<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_accounts}}".
 *
 * @property int $id Primary Id
 * @property string $loan_account_enc_id Loan Account
 * @property string $loan_account_number Loan Account Number
 * @property string $lms_loan_account_number
 * @property string $name Name
 * @property string $phone Phone
 * @property double $emi_amount Emi Amount
 * @property double $overdue_amount Overdue Amount
 * @property double $ledger_amount Ledger Amount
 * @property string $loan_type Loan Type
 * @property string $emi_date Emi Date
 * @property double $last_emi_received_amount Last emi received amount
 * @property string $last_emi_received_date Last emi received date
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 */
class LoanAccounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_accounts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_account_enc_id', 'loan_account_number', 'lms_loan_account_number', 'name', 'emi_amount', 'loan_type', 'emi_date', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['emi_amount', 'overdue_amount', 'ledger_amount', 'last_emi_received_amount'], 'number'],
            [['emi_date', 'last_emi_received_date', 'created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_account_enc_id', 'loan_account_number', 'name', 'loan_type', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['lms_loan_account_number'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 15],
            [['loan_account_enc_id'], 'unique'],
            [['loan_account_number'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
