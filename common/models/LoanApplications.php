<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_applications}}".
 *
 * @property int $id
 * @property string $loan_app_enc_id
 * @property int $had_taken_addmission 1 for yes 0 for no
 * @property string $current_scheme_id
 * @property string $college_enc_id
 * @property string $college_course_enc_id organization_enc_id
 * @property string $loan_type_enc_id
 * @property string $applicant_name Course Name
 * @property string $employement_type
 * @property string $image
 * @property string $image_location
 * @property string $applicant_dob
 * @property string $applicant_current_city
 * @property string $degree
 * @property int $years Course Years
 * @property int $months Course Months
 * @property int $semesters course semesters
 * @property string $phone
 * @property string $email
 * @property string $candidate_status Interested, Not Interested, withDrawn
 * @property int $cibil_score cibil score
 * @property int $gender 1 for Male, 2 for Female,3 other
 * @property double $amount
 * @property double $yearly_income
 * @property double $amount_received
 * @property double $amount_due
 * @property double $scholarship
 * @property string $aadhaar_number
 * @property string $source
 * @property int $ask_guarantor_info 1 for yes 0 for no
 * @property string $managed_by_refferal Managed By Application
 * @property string $managed_by
 * @property string $lead_by_refferal Lead By Application
 * @property string $lead_by
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $status 0 as Pending, 1 as Approved, 2 as Rejected
 * @property int $loan_status 0 as New Lead, 1 as Accepted, 2 as Pre Verification, 3 as Under Process, 4 as Senctioned, 5 as Disbursed 10 as Rejected
 * @property string $loan_type
 * @property string $loan_purpose
 * @property int $is_deleted 0 as False, 1 as True
 * @property int $is_removed 0 as Permanently false 1 as Permanently True
 *
 * @property AssignedLoanProvider[] $assignedLoanProviders
 * @property EducationLoanPayments[] $educationLoanPayments
 * @property LoanApplicantResidentialInfo[] $loanApplicantResidentialInfos
 * @property LoanApplicationComments[] $loanApplicationComments
 * @property LoanApplicationCommissions[] $loanApplicationCommissions
 * @property LoanApplicationLogs[] $loanApplicationLogs
 * @property LoanApplicationOptions[] $loanApplicationOptions
 * @property LoanApplicationRecords[] $loanApplicationRecords
 * @property LoanApplicationSchoolFee[] $loanApplicationSchoolFees
 * @property LoanApplicationTeacherLoan[] $loanApplicationTeacherLoans
 * @property CollegeCourses $collegeCourseEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanTypes $loanTypeEnc
 * @property Organizations $collegeEnc
 * @property OrganizationLoanSchemes $currentScheme
 * @property Users $managedBy
 * @property Users $leadBy
 * @property LoanApplicationsCollegePreference[] $loanApplicationsCollegePreferences
 * @property LoanCandidateEducation[] $loanCandidateEducations
 * @property LoanCertificates[] $loanCertificates
 * @property LoanCoApplicants[] $loanCoApplicants
 * @property LoanPurpose[] $loanPurposes
 * @property LoanSanctionReports[] $loanSanctionReports
 * @property PathToClaimOrgLoanApplication[] $pathToClaimOrgLoanApplications
 * @property PathToOpenLeads[] $pathToOpenLeads
 * @property PathToUnclaimOrgLoanApplication[] $pathToUnclaimOrgLoanApplications
 * @property ReferralLoanApplicationTracking[] $referralLoanApplicationTrackings
 */
class LoanApplications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_applications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_app_enc_id', 'applicant_name', 'applicant_current_city', 'phone', 'email', 'amount', 'source'], 'required'],
            [['had_taken_addmission', 'years', 'months', 'semesters', 'cibil_score', 'gender', 'ask_guarantor_info', 'status', 'loan_status', 'is_deleted', 'is_removed'], 'integer'],
            [['employement_type', 'degree', 'candidate_status', 'source', 'loan_type'], 'string'],
            [['applicant_dob', 'created_on', 'updated_on'], 'safe'],
            [['amount', 'yearly_income', 'amount_received', 'amount_due', 'scholarship'], 'number'],
            [['loan_app_enc_id', 'current_scheme_id', 'college_enc_id', 'college_course_enc_id', 'loan_type_enc_id', 'applicant_name', 'image', 'image_location', 'applicant_current_city', 'email', 'managed_by_refferal', 'managed_by', 'lead_by_refferal', 'lead_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['aadhaar_number'], 'string', 'max' => 16],
            [['loan_purpose'], 'string', 'max' => 255],
            [['loan_app_enc_id'], 'unique'],
            [['college_course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['college_course_enc_id' => 'college_course_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanTypes::className(), 'targetAttribute' => ['loan_type_enc_id' => 'loan_type_enc_id']],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['current_scheme_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLoanSchemes::className(), 'targetAttribute' => ['current_scheme_id' => 'scheme_enc_id']],
            [['managed_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['managed_by' => 'user_enc_id']],
            [['lead_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['lead_by' => 'user_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'loan_app_enc_id' => Yii::t('common', 'Loan App Enc ID'),
            'had_taken_addmission' => Yii::t('common', 'Had Taken Addmission'),
            'current_scheme_id' => Yii::t('common', 'Current Scheme ID'),
            'college_enc_id' => Yii::t('common', 'College Enc ID'),
            'college_course_enc_id' => Yii::t('common', 'College Course Enc ID'),
            'loan_type_enc_id' => Yii::t('common', 'Loan Type Enc ID'),
            'applicant_name' => Yii::t('common', 'Applicant Name'),
            'employement_type' => Yii::t('common', 'Employement Type'),
            'image' => Yii::t('common', 'Image'),
            'image_location' => Yii::t('common', 'Image Location'),
            'applicant_dob' => Yii::t('common', 'Applicant Dob'),
            'applicant_current_city' => Yii::t('common', 'Applicant Current City'),
            'degree' => Yii::t('common', 'Degree'),
            'years' => Yii::t('common', 'Years'),
            'months' => Yii::t('common', 'Months'),
            'semesters' => Yii::t('common', 'Semesters'),
            'phone' => Yii::t('common', 'Phone'),
            'email' => Yii::t('common', 'Email'),
            'candidate_status' => Yii::t('common', 'Candidate Status'),
            'cibil_score' => Yii::t('common', 'Cibil Score'),
            'gender' => Yii::t('common', 'Gender'),
            'amount' => Yii::t('common', 'Amount'),
            'yearly_income' => Yii::t('common', 'Yearly Income'),
            'amount_received' => Yii::t('common', 'Amount Received'),
            'amount_due' => Yii::t('common', 'Amount Due'),
            'scholarship' => Yii::t('common', 'Scholarship'),
            'aadhaar_number' => Yii::t('common', 'Aadhaar Number'),
            'source' => Yii::t('common', 'Source'),
            'ask_guarantor_info' => Yii::t('common', 'Ask Guarantor Info'),
            'managed_by_refferal' => Yii::t('common', 'Managed By Refferal'),
            'managed_by' => Yii::t('common', 'Managed By'),
            'lead_by_refferal' => Yii::t('common', 'Lead By Refferal'),
            'lead_by' => Yii::t('common', 'Lead By'),
            'created_by' => Yii::t('common', 'Created By'),
            'created_on' => Yii::t('common', 'Created On'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'updated_on' => Yii::t('common', 'Updated On'),
            'status' => Yii::t('common', 'Status'),
            'loan_status' => Yii::t('common', 'Loan Status'),
            'loan_type' => Yii::t('common', 'Loan Type'),
            'loan_purpose' => Yii::t('common', 'Loan Purpose'),
            'is_deleted' => Yii::t('common', 'Is Deleted'),
            'is_removed' => Yii::t('common', 'Is Removed'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLoanProviders()
    {
        return $this->hasMany(AssignedLoanProvider::className(), ['loan_application_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationLoanPayments()
    {
        return $this->hasMany(EducationLoanPayments::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicantResidentialInfos()
    {
        return $this->hasMany(LoanApplicantResidentialInfo::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationComments()
    {
        return $this->hasMany(LoanApplicationComments::className(), ['loan_application_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationCommissions()
    {
        return $this->hasMany(LoanApplicationCommissions::className(), ['loan_application_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationLogs()
    {
        return $this->hasMany(LoanApplicationLogs::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationOptions()
    {
        return $this->hasMany(LoanApplicationOptions::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationRecords()
    {
        return $this->hasMany(LoanApplicationRecords::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationSchoolFees()
    {
        return $this->hasMany(LoanApplicationSchoolFee::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationTeacherLoans()
    {
        return $this->hasMany(LoanApplicationTeacherLoan::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCourseEnc()
    {
        return $this->hasOne(CollegeCourses::className(), ['college_course_enc_id' => 'college_course_enc_id']);
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
    public function getLoanTypeEnc()
    {
        return $this->hasOne(LoanTypes::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrentScheme()
    {
        return $this->hasOne(OrganizationLoanSchemes::className(), ['scheme_enc_id' => 'current_scheme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManagedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'managed_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'lead_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationsCollegePreferences()
    {
        return $this->hasMany(LoanApplicationsCollegePreference::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCandidateEducations()
    {
        return $this->hasMany(LoanCandidateEducation::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCertificates()
    {
        return $this->hasMany(LoanCertificates::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCoApplicants()
    {
        return $this->hasMany(LoanCoApplicants::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanPurposes()
    {
        return $this->hasMany(LoanPurpose::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanSanctionReports()
    {
        return $this->hasMany(LoanSanctionReports::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPathToClaimOrgLoanApplications()
    {
        return $this->hasMany(PathToClaimOrgLoanApplication::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPathToOpenLeads()
    {
        return $this->hasMany(PathToOpenLeads::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPathToUnclaimOrgLoanApplications()
    {
        return $this->hasMany(PathToUnclaimOrgLoanApplication::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferralLoanApplicationTrackings()
    {
        return $this->hasMany(ReferralLoanApplicationTracking::className(), ['loan_application_enc_id' => 'loan_app_enc_id']);
    }
}
