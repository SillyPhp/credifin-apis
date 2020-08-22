<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_applications}}".
 *
 * @property int $id
 * @property string $loan_app_enc_id
 * @property string $current_scheme_id
 * @property string $college_enc_id
 * @property string $college_course_enc_id organization_enc_id
 * @property string $loan_type_enc_id
 * @property string $applicant_name Course Name
 * @property string $applicant_dob
 * @property string $applicant_current_city
 * @property string $degree
 * @property int $years Course Years
 * @property int $semesters course semesters
 * @property string $phone
 * @property string $email
 * @property int $gender 1 for Male, 2 for Female
 * @property double $amount
 * @property double $amount_received
 * @property double $amount_due
 * @property double $scholarship
 * @property string $aadhaar_number
 * @property string $source
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $status 0 as Pending, 1 as Approved, 2 as Rejected
 * @property int $loan_status 0 as New Lead, 1 as Accepted, 2 as Pre Verification, 3 as Under Process, 4 as Senctioned, 5 as Disbursed 10 as Rejected
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property EducationLoanPayments[] $educationLoanPayments
 * @property LoanApplicationLogs[] $loanApplicationLogs
 * @property CollegeCourses $collegeCourseEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanTypes $loanTypeEnc
 * @property Organizations $collegeEnc
 * @property OrganizationLoanSchemes $currentScheme
 * @property LoanCandidateEducation[] $loanCandidateEducations
 * @property LoanCertificates[] $loanCertificates
 * @property LoanCoApplicants[] $loanCoApplicants
 * @property LoanPurpose[] $loanPurposes
 * @property LoanSanctionReports[] $loanSanctionReports
 * @property PathToClaimOrgLoanApplication[] $pathToClaimOrgLoanApplications
 * @property PathToUnclaimOrgLoanApplication[] $pathToUnclaimOrgLoanApplications
 */
class LoanApplications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_app_enc_id', 'applicant_name', 'applicant_dob', 'applicant_current_city', 'degree', 'years', 'semesters', 'phone', 'email', 'gender', 'amount', 'aadhaar_number', 'source', 'created_on'], 'required'],
            [['applicant_dob', 'created_on', 'updated_on'], 'safe'],
            [['degree', 'source'], 'string'],
            [['years', 'semesters', 'gender', 'status', 'loan_status', 'is_deleted'], 'integer'],
            [['amount', 'amount_received', 'amount_due', 'scholarship'], 'number'],
            [['loan_app_enc_id', 'current_scheme_id', 'college_enc_id', 'college_course_enc_id', 'loan_type_enc_id', 'applicant_name', 'applicant_current_city', 'email', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['aadhaar_number'], 'string', 'max' => 16],
            [['college_course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['college_course_enc_id' => 'college_course_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanTypes::className(), 'targetAttribute' => ['loan_type_enc_id' => 'loan_type_enc_id']],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['current_scheme_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLoanSchemes::className(), 'targetAttribute' => ['current_scheme_id' => 'scheme_enc_id']],
        ];
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
    public function getLoanApplicationLogs()
    {
        return $this->hasMany(LoanApplicationLogs::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
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
    public function getPathToUnclaimOrgLoanApplications()
    {
        return $this->hasMany(PathToUnclaimOrgLoanApplication::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }
}
