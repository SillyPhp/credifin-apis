<?php

namespace common\models;

/**
 * This is the model class for table "{{%emi_collection}}".
 *
 * @property int $id Primary Key
 * @property string $emi_collection_enc_id Emi Collection Enc Id
 * @property string $loan_account_enc_id Loan Account Enc Id
 * @property string $branch_enc_id Branch Enc Id
 * @property string $customer_name Customer Name
 * @property int $company_id
 * @property string $case_no
 * @property string $collection_date Collection Date
 * @property string $loan_account_number Loan Account Number
 * @property string $phone Phone Number
 * @property string $payment_method
 * @property string $other_payment_method
 * @property double $amount Amount
 * @property string $loan_type Loan Type
 * @property string $loan_purpose Loan Purpose
 * @property string $customer_interaction
 * @property string $customer_visit
 * @property string $transaction_initiated_date
 * @property int $ptp_payment_method 1 = cash, 2 = online
 * @property double $ptp_amount Ptp Amount
 * @property string $ptp_date Ptp Date
 * @property string $delay_reason Delay Reason
 * @property string $other_delay_reason Other Delay Reason
 * @property string $borrower_image Borrower Image
 * @property string $borrower_image_location Borrower Image Location
 * @property string $pr_receipt_image Pr Receipt
 * @property string $pr_receipt_image_location Pr Receipt Location
 * @property string $other_doc_image Other Document Image
 * @property string $other_doc_image_location Other Document Image Location
 * @property int $emi_payment_mode
 * @property int $emi_payment_method
 * @property string $emi_payment_status
 * @property string $reference_number
 * @property string $dealer_name
 * @property string $address Address
 * @property string $pincode Pincode
 * @property double $latitude Location Latitude
 * @property double $longitude Location Longitude
 * @property string $comments Comments
 * @property string $created_by Created By
 * @property string $created_on Created On
 * @property string $updated_by Updated By
 * @property string $updated_on Updated On
 * @property int $is_deleted Is Deleted
 * @property int $discrepency_emi Temporary column
 *
 * @property AssignedLoanPayments[] $assignedLoanPayments
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property OrganizationLocations $branchEnc
 * @property LoanAccounts $loanAccountEnc
 * @property EmployeesCashReport[] $employeesCashReports
 * @property LoanAccountPtps[] $loanAccountPtps
 */
class EmiCollection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%emi_collection}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emi_collection_enc_id', 'branch_enc_id', 'customer_name', 'phone', 'amount', 'loan_type', 'created_by'], 'required'],
            [['company_id', 'ptp_payment_method', 'emi_payment_mode', 'emi_payment_method', 'is_deleted', 'discrepency_emi'], 'integer'],
            [['collection_date', 'transaction_initiated_date', 'ptp_date', 'created_on', 'updated_on'], 'safe'],
            [['amount', 'ptp_amount', 'latitude', 'longitude'], 'number'],
            [['customer_interaction', 'customer_visit', 'emi_payment_status', 'address', 'comments'], 'string'],
            [['emi_collection_enc_id', 'loan_account_enc_id', 'branch_enc_id', 'customer_name', 'case_no', 'loan_account_number', 'loan_type', 'loan_purpose', 'delay_reason', 'other_delay_reason', 'borrower_image', 'borrower_image_location', 'pr_receipt_image', 'pr_receipt_image_location', 'other_doc_image', 'other_doc_image_location', 'reference_number', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['payment_method'], 'string', 'max' => 30],
            [['other_payment_method', 'dealer_name'], 'string', 'max' => 50],
            [['pincode'], 'string', 'max' => 8],
            [['emi_collection_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['branch_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLocations::className(), 'targetAttribute' => ['branch_enc_id' => 'location_enc_id']],
            [['loan_account_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanAccounts::className(), 'targetAttribute' => ['loan_account_enc_id' => 'loan_account_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLoanPayments()
    {
        return $this->hasMany(AssignedLoanPayments::className(), ['emi_collection_enc_id' => 'emi_collection_enc_id']);
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
    public function getBranchEnc()
    {
        return $this->hasOne(OrganizationLocations::className(), ['location_enc_id' => 'branch_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountEnc()
    {
        return $this->hasOne(LoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeesCashReports()
    {
        return $this->hasMany(EmployeesCashReport::className(), ['emi_collection_enc_id' => 'emi_collection_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountPtps()
    {
        return $this->hasMany(LoanAccountPtps::className(), ['emi_collection_enc_id' => 'emi_collection_enc_id']);
    }
}
