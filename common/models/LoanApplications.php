<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_applications}}".
 *
 * @property int $id
 * @property string $loan_app_enc_id
 * @property string $parent_application_enc_id loan parent application enc id
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
 * @property string $candidate_status New Lead, On Going, Accepted, Document Uploaded, On Hold, withDrawn, Non Responsive, Rejected, Done, defferds
 * @property string $candidate_sub_status Sent Again,Trying Again,Initial Call,Credit Call,Case Forwarded,Case Confirmed,IELTS,Admission,Offer Letter,No Document Required,Partial
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
 * @property string $deadline
 * @property string $intake
 * @property string $aadhaar_link_phone_number Aadhar Link Phone Number
 * @property string $managed_by_refferal Managed By Application
 * @property string $managed_by
 * @property string $lead_by_refferal Lead By Application
 * @property string $lead_by
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property string $updated_by
 * @property string $updated_on
 * @property string $lead_application_enc_id Lead application Link
 * @property int $status 0 as Pending, 1 as Approved, 2 as Rejected, 3 as Verified
 * @property int $loan_status 0 as New Lead, 1 as Accepted, 2 as Pre Verification, 3 as Under Process, 4 as Senctioned, 5 as Disbursed, 6 as Completed, 10 as Rejected
 * @property string $loan_type
 * @property string $loan_purpose
 * @property string $lender_reasons
 * @property int $is_deleted 0 as False, 1 as True
 * @property int $is_removed 0 as Permanently false 1 as Permanently True
 *
 * @property AssignedLoanProvider[] $assignedLoanProviders
 * @property EducationLoanPayments[] $educationLoanPayments
 * @property LoanApplicantResidentialInfo[] $loanApplicantResidentialInfos
 * @property LoanApplicationComments[] $loanApplicationComments
 * @property LoanApplicationCommissions[] $loanApplicationCommissions
 * @property LoanApplicationLogs[] $loanApplicationLogs
 * @property LoanApplicationNotifications[] $loanApplicationNotifications
 * @property LoanApplicationOptions[] $loanApplicationOptions
 * @property LoanApplicationRecords[] $loanApplicationRecords
 * @property LoanApplicationSchoolFee[] $loanApplicationSchoolFees
 * @property LoanApplicationTeacherLoan[] $loanApplicationTeacherLoans
 * @property CollegeCourses $collegeCourseEnc
 * @property LeadsApplications $leadApplicationEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanTypes $loanTypeEnc
 * @property Organizations $collegeEnc
 * @property OrganizationLoanSchemes $currentScheme
 * @property Users $managedBy
 * @property Users $leadBy
 * @property LoanApplications $parentApplicationEnc
 * @property LoanApplications[] $loanApplications
 * @property LoanApplicationsCollegePreference[] $loanApplicationsCollegePreferences
 * @property LoanCandidateEducation[] $loanCandidateEducations
 * @property LoanCertificates[] $loanCertificates
 * @property LoanCoApplicants[] $loanCoApplicants
 * @property LoanDisbursementSchedule[] $loanDisbursementSchedules
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
            [['loan_app_enc_id', 'applicant_name', 'phone', 'amount', 'source'], 'required'],
            [['had_taken_addmission', 'years', 'months', 'semesters', 'cibil_score', 'gender', 'ask_guarantor_info', 'status', 'loan_status', 'is_deleted', 'is_removed'], 'integer'],
            [['employement_type', 'degree', 'candidate_status', 'candidate_sub_status', 'source', 'loan_type', 'lender_reasons'], 'string'],
            [['applicant_dob', 'deadline', 'intake', 'created_on', 'updated_on'], 'safe'],
            [['amount', 'yearly_income', 'amount_received', 'amount_due', 'scholarship'], 'number'],
            [['loan_app_enc_id', 'parent_application_enc_id', 'current_scheme_id', 'college_enc_id', 'college_course_enc_id', 'loan_type_enc_id', 'applicant_name', 'image', 'image_location', 'applicant_current_city', 'email', 'managed_by_refferal', 'managed_by', 'lead_by_refferal', 'lead_by', 'created_by', 'updated_by', 'lead_application_enc_id'], 'string', 'max' => 100],
            [['phone', 'aadhaar_link_phone_number'], 'string', 'max' => 15],
            [['aadhaar_number'], 'string', 'max' => 16],
            [['loan_purpose'], 'string', 'max' => 255],
            [['loan_app_enc_id'], 'unique'],
            [['college_course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['college_course_enc_id' => 'college_course_enc_id']],
            [['lead_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeadsApplications::className(), 'targetAttribute' => ['lead_application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanTypes::className(), 'targetAttribute' => ['loan_type_enc_id' => 'loan_type_enc_id']],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['current_scheme_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLoanSchemes::className(), 'targetAttribute' => ['current_scheme_id' => 'scheme_enc_id']],
            [['managed_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['managed_by' => 'user_enc_id']],
            [['lead_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['lead_by' => 'user_enc_id']],
            [['parent_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['parent_application_enc_id' => 'loan_app_enc_id']],
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
    public function getLoanApplicationNotifications()
    {
        return $this->hasMany(LoanApplicationNotifications::className(), ['loan_application_enc_id' => 'loan_app_enc_id']);
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
    public function getLeadApplicationEnc()
    {
        return $this->hasOne(LeadsApplications::className(), ['application_enc_id' => 'lead_application_enc_id']);
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
    public function getParentApplicationEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'parent_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplications()
    {
        return $this->hasMany(LoanApplications::className(), ['parent_application_enc_id' => 'loan_app_enc_id']);
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
    public function getLoanDisbursementSchedules()
    {
        return $this->hasMany(LoanDisbursementSchedule::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
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