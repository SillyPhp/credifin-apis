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
 * @property string $collection_manager Collection Manager
 * @property string $last_emi_date Last Emi Date
 * @property int $total_installments Total Installments
 * @property double $financed_amount Amount Financed
 * @property string $stock Stock
 * @property string $pos POS
 * @property string $advance_interest Advance Hp
 * @property string $bucket Bucket
 * @property string $branch_enc_id Branch Enc Id
 * @property string $bucket_status_date Bucket Status Date
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
 * @property EmiPaymentIssues[] $emiPaymentIssues
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property OrganizationLocations $branchEnc
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
            [['last_emi_date', 'bucket_status_date', 'emi_date', 'last_emi_received_date', 'created_on', 'updated_on'], 'safe'],
            [['total_installments', 'is_deleted'], 'integer'],
            [['financed_amount', 'emi_amount', 'overdue_amount', 'ledger_amount', 'last_emi_received_amount'], 'number'],
            [['loan_account_enc_id', 'loan_account_number', 'branch_enc_id', 'name', 'loan_type', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['lms_loan_account_number'], 'string', 'max' => 20],
            [['collection_manager', 'stock', 'pos', 'advance_interest', 'bucket'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['loan_account_enc_id'], 'unique'],
            [['loan_account_number'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['branch_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLocations::className(), 'targetAttribute' => ['branch_enc_id' => 'location_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmiPaymentIssues()
    {
        return $this->hasMany(EmiPaymentIssues::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
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
    public function getBranchEnc()
    {
        return $this->hasOne(OrganizationLocations::className(), ['location_enc_id' => 'branch_enc_id']);
    }
}
