<?php

namespace common\models;


/**
 * This is the model class for table "{{%assigned_loan_provider}}".
 *
 * @property int $id
 * @property string $assigned_loan_provider_enc_id assigned_loan_schemes_enc_id
 * @property string $loan_application_enc_id linked to loan application
 * @property string $institute_lead_enc_id linked to Institute Loan Application
 * @property string $provider_enc_id linked to organization_enc_id
 * @property string $scheme_enc_id linked to organization schemes
 * @property string $assigned_lender_service_enc_id Assigned Lender Service
 * @property int $status assigned to loan status table with status value
 * @property string $remarks ANy remarks or reason for rejection or any status change
 * @property string $branch_enc_id branch id
 * @property double $bdo_approved_amount BDO approved amount
 * @property double $tl_approved_amount TL approved amount
 * @property double $soft_approval soft approvel
 * @property double $soft_sanction soft sanction
 * @property double $valuation valuation
 * @property double $disbursement_approved disbursement approved
 * @property double $insurance_charges insurance and incident charges
 * @property string $created_by linked to user table
 * @property string $created_on created on
 * @property string $updated_on updated on
 * @property string $updated_by linked to user table
 * @property string $loan_status_updated_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Organizations $providerEnc
 * @property OrganizationLoanSchemes $schemeEnc
 * @property LoanApplications $loanApplicationEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property InstituteLeads $instituteLeadEnc
 * @property AssignedLenderServices $assignedLenderServiceEnc
 * @property OrganizationLocations $branchEnc
 * @property LoanStatus $status0
 */
class AssignedLoanProvider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_loan_provider}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_loan_provider_enc_id', 'provider_enc_id'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['remarks'], 'string'],
            [['bdo_approved_amount', 'tl_approved_amount', 'soft_approval', 'soft_sanction', 'valuation', 'disbursement_approved', 'insurance_charges'], 'number'],
            [['created_on', 'updated_on', 'loan_status_updated_on'], 'safe'],
            [['assigned_loan_provider_enc_id', 'loan_application_enc_id', 'institute_lead_enc_id', 'provider_enc_id', 'scheme_enc_id', 'assigned_lender_service_enc_id', 'branch_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_loan_provider_enc_id'], 'unique'],
            [['provider_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['provider_enc_id' => 'organization_enc_id']],
            [['scheme_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLoanSchemes::className(), 'targetAttribute' => ['scheme_enc_id' => 'scheme_enc_id']],
            [['loan_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_application_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['institute_lead_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstituteLeads::className(), 'targetAttribute' => ['institute_lead_enc_id' => 'lead_enc_id']],
            [['assigned_lender_service_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedLenderServices::className(), 'targetAttribute' => ['assigned_lender_service_enc_id' => 'assigned_lender_service_enc_id']],
            [['branch_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLocations::className(), 'targetAttribute' => ['branch_enc_id' => 'location_enc_id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => LoanStatus::className(), 'targetAttribute' => ['status' => 'value']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assigned_loan_provider_enc_id' => 'Assigned Loan Provider Enc ID',
            'loan_application_enc_id' => 'Loan Application Enc ID',
            'institute_lead_enc_id' => 'Institute Lead Enc ID',
            'provider_enc_id' => 'Provider Enc ID',
            'scheme_enc_id' => 'Scheme Enc ID',
            'assigned_lender_service_enc_id' => 'Assigned Lender Service Enc ID',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'branch_enc_id' => 'Branch Enc ID',
            'bdo_approved_amount' => 'Bdo Approved Amount',
            'tl_approved_amount' => 'Tl Approved Amount',
            'soft_approval' => 'Soft Approval',
            'soft_sanction' => 'Soft Sanction',
            'valuation' => 'Valuation',
            'disbursement_approved' => 'Disbursement Approved',
            'insurance_charges' => 'Insurance Charges',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
            'loan_status_updated_on' => 'Loan Status Updated On',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviderEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'provider_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchemeEnc()
    {
        return $this->hasOne(OrganizationLoanSchemes::className(), ['scheme_enc_id' => 'scheme_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_application_enc_id']);
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
    public function getInstituteLeadEnc()
    {
        return $this->hasOne(InstituteLeads::className(), ['lead_enc_id' => 'institute_lead_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLenderServiceEnc()
    {
        return $this->hasOne(AssignedLenderServices::className(), ['assigned_lender_service_enc_id' => 'assigned_lender_service_enc_id']);
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
    public function getStatus0()
    {
        return $this->hasOne(LoanStatus::className(), ['value' => 'status']);
    }
}
