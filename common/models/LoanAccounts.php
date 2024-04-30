<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_accounts}}".
 *
 * @property int $id Primary Id
 * @property string $loan_account_enc_id Loan Account
 * @property string $loan_app_enc_id Loan Application Enc Id
 * @property string $assigned_financer_enc_id
 * @property string $loan_account_number Loan Account Number
 * @property string $lms_loan_account_number Lms Account Number
 * @property string $case_no Case Number
 * @property string $collection_manager
 * @property string $assigned_caller
 * @property int $company_id Company Id
 * @property string $name Name
 * @property string $phone Phone
 * @property string $company_name Company Name
 * @property string $dealer_name Dealer Name
 * @property int $hard_recovery
 * @property int $sales_priority
 * @property int $telecaller_priority
 * @property int $collection_priority
 * @property string $sales_target_date
 * @property string $telecaller_target_date
 * @property string $collection_target_date
 * @property int $nach_approved Nach Approved
 * @property string $coborrower_name CoBorrower Name
 * @property string $coborrower_phone CoBorrower Number
 * @property string $last_emi_date Last Emi Date
 * @property int $total_installments Total Installments
 * @property double $financed_amount Amount Financed
 * @property double $stock Stock
 * @property double $pos POS
 * @property double $advance_interest Advance Hp
 * @property string $bucket Bucket
 * @property int $sub_bucket
 * @property string $branch_enc_id Branch Enc Id
 * @property string $bucket_status_date Bucket Status Date
 * @property double $emi_amount Emi Amount
 * @property double $overdue_amount Overdue Amount
 * @property double $ledger_amount Ledger Amount
 * @property string $loan_type Loan Type
 * @property string $emi_date Emi Date
 * @property double $last_emi_received_amount Last emi received amount
 * @property string $last_emi_received_date Last emi received date
 * @property string $vehicle_type Vehicle Type
 * @property string $vehicle_make Vehicle Make
 * @property string $vehicle_model Vehicle Model
 * @property string $vehicle_engine_no Vehicle Engine Number
 * @property string $vehicle_chassis_no Vehicle Chassis Number
 * @property string $rc_number Rc Number
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property AssignedLoanAccounts[] $assignedLoanAccounts
 * @property AssignedLoanPayments[] $assignedLoanPayments
 * @property EmiCollection[] $emiCollections
 * @property EmiPaymentIssues[] $emiPaymentIssues
 * @property EmiPaymentRecords[] $emiPaymentRecords
 * @property LoanAccountComments[] $loanAccountComments
 * @property LoanAccountOtherDetails[] $loanAccountOtherDetails
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property OrganizationLocations $branchEnc
 * @property LoanApplications $loanAppEnc
 * @property Organizations $assignedFinancerEnc
 * @property Users $collectionManager
 * @property Users $assignedCaller
 * @property LoanActionRequests[] $loanActionRequests
 * @property VehicleRepossession[] $vehicleRepossessions
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
            [['loan_account_enc_id', 'loan_account_number', 'name', 'loan_type', 'emi_date', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['company_id', 'hard_recovery', 'sales_priority', 'telecaller_priority', 'collection_priority', 'nach_approved', 'total_installments', 'sub_bucket', 'is_deleted'], 'integer'],
            [['sales_target_date', 'telecaller_target_date', 'collection_target_date', 'last_emi_date', 'bucket_status_date', 'emi_date', 'last_emi_received_date', 'vehicle_make', 'created_on', 'updated_on'], 'safe'],
            [['financed_amount', 'stock', 'pos', 'advance_interest', 'emi_amount', 'overdue_amount', 'ledger_amount', 'last_emi_received_amount'], 'number'],
            [['loan_account_enc_id', 'loan_app_enc_id', 'assigned_financer_enc_id', 'loan_account_number', 'lms_loan_account_number', 'case_no', 'collection_manager', 'assigned_caller', 'name', 'company_name', 'dealer_name', 'coborrower_name', 'branch_enc_id', 'loan_type', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['phone', 'coborrower_phone'], 'string', 'max' => 15],
            [['bucket', 'vehicle_type', 'vehicle_model'], 'string', 'max' => 50],
            [['vehicle_engine_no', 'vehicle_chassis_no', 'rc_number'], 'string', 'max' => 30],
            [['loan_account_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['branch_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLocations::className(), 'targetAttribute' => ['branch_enc_id' => 'location_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['assigned_financer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['assigned_financer_enc_id' => 'organization_enc_id']],
            [['collection_manager'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['collection_manager' => 'user_enc_id']],
            [['assigned_caller'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['assigned_caller' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLoanAccounts()
    {
        return $this->hasMany(AssignedLoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLoanPayments()
    {
        return $this->hasMany(AssignedLoanPayments::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmiCollections()
    {
        return $this->hasMany(EmiCollection::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
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
    public function getEmiPaymentRecords()
    {
        return $this->hasMany(EmiPaymentRecords::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountComments()
    {
        return $this->hasMany(LoanAccountComments::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountOtherDetails()
    {
        return $this->hasMany(LoanAccountOtherDetails::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
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
    public function getAssignedFinancerEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'assigned_financer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionManager()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'collection_manager']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCaller()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'assigned_caller']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc0()
    {
        return $this->hasMany(LoanCoApplicants::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanActionRequests()
    {
        return $this->hasMany(LoanActionRequests::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleRepossessions()
    {
        return $this->hasMany(VehicleRepossession::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }
}
