<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organizations}}".
 *
 * @property int $id Primary Key
 * @property string $organization_enc_id Organization Encrypted ID
 * @property string $organization_type_enc_id Foreign Key to Organization Types Table
 * @property string $business_activity_enc_id Foreign Key to Business Activities Table
 * @property string $industry_enc_id Foreign Key to Industries Table
 * @property string $name Organization Name
 * @property string $slug Organization Slug
 * @property string $email Organization Email
 * @property string $initials_color Initials Color
 * @property string $logo Organization Logo
 * @property string $logo_location Location of the logo
 * @property string $cover_image Organization Cover Image
 * @property string $cover_image_location Location of the cover image
 * @property string $tag_line Tag Line
 * @property string $establishment_year Year of Establishment
 * @property string $description Organization Description
 * @property string $mission Organization Mission
 * @property string $vision Organization Vision
 * @property string $value Organization Values
 * @property string $website Organization Website
 * @property string $phone Contact Number
 * @property string $fax Fax Number
 * @property string $facebook Facebook URL
 * @property string $google Google+ URL
 * @property string $twitter Twitter URL
 * @property string $instagram Instagram URL
 * @property string $linkedin Linkedin URL
 * @property int $number_of_employees Number of Employees in the Organization
 * @property int $is_sponsored Is Organization Sponsored (0 as False, 1 as True)
 * @property int $is_featured Is Organization Featured (0 as False, 1 as True)
 * @property string $created_on On which date Organization information was added to database
 * @property string $created_by By which User Organization information was added
 * @property string $last_updated_on On which date Organization information was updated
 * @property string $last_updated_by By which User Organization information was updated
 * @property int $is_email_verified Is Organization Email Verified (0 as False, 1 as True)
 * @property int $is_phone_verified Is Organization Phone Verified (0 as False, 1 as True)
 * @property int $is_startup Is Organization a Startup (0 as No, 1 as Yes)
 * @property int $is_erexx_registered Is College Erexx Based (0 as False, 1 as True)
 * @property int $is_erexx_approved 0 as false, 1 as true
 * @property int $has_loan_featured 0 as false, 1 as true
 * @property int $has_skillup_featured 0 as false, 1 as true
 * @property int $has_placement_rights 1 for Has erexx rights
 * @property int $contact_status 1 as Contacted, 2 as Profile Completed, 3 Campus Hiring Started
 * @property string $status Organization Status (Active, Inactive, Pending)
 * @property int $is_claimed  0 as not, 1 as yes
 * @property int $is_deleted Is Organization Deleted (0 as False, 1 as True)
 *
 * @property AssignedCategories[] $assignedCategories
 * @property AssignedCollegeCourses[] $assignedCollegeCourses
 * @property AssignedFinancerDealers[] $assignedFinancerDealers
 * @property AssignedFinancerLoanType[] $assignedFinancerLoanTypes
 * @property AssignedFinancerLoanTypes[] $assignedFinancerLoanTypes0
 * @property AssignedLenderServices[] $assignedLenderServices
 * @property AssignedLoanProvider[] $assignedLoanProviders
 * @property AssignedOrganizationFeeComponent[] $assignedOrganizationFeeComponents
 * @property AssignedQuizTo[] $assignedQuizTos
 * @property AssignedSupervisor[] $assignedSupervisors
 * @property AssignedTags[] $assignedTags
 * @property AssignedWebinarTo[] $assignedWebinarTos
 * @property BankDetails[] $bankDetails
 * @property BookmarkedHiringTemplates[] $bookmarkedHiringTemplates
 * @property BookmarkedQuestionnaireTemplates[] $bookmarkedQuestionnaireTemplates
 * @property ClaimServiceableLocations[] $claimServiceableLocations
 * @property ClaimServiceableLocations[] $claimServiceableLocations0
 * @property CollegeCourses[] $collegeCourses
 * @property CollegeCutoff[] $collegeCutoffs
 * @property CollegeInfrastructureDetail[] $collegeInfrastructureDetails
 * @property CollegePlacementHighlights[] $collegePlacementHighlights
 * @property CollegeRecruitmentByCourse[] $collegeRecruitmentByCourses
 * @property CollegeScholarships[] $collegeScholarships
 * @property CollegeSettings[] $collegeSettings
 * @property ConversationParticipants[] $conversationParticipants
 * @property Credentials[] $credentials
 * @property Designations[] $designations
 * @property DropResumeOrgApplication[] $dropResumeOrgApplications
 * @property DropResumeUnselectedTitles[] $dropResumeUnselectedTitles
 * @property EducationalRequirements[] $educationalRequirements
 * @property EmailLogs[] $emailLogs
 * @property EmployeeBenefits[] $employeeBenefits
 * @property EmployerApplications[] $employerApplications
 * @property ErexxActivityTracks[] $erexxActivityTracks
 * @property ErexxCollaborators[] $erexxCollaborators
 * @property ErexxCollaborators[] $erexxCollaborators0
 * @property ErexxEmployerApplications[] $erexxEmployerApplications
 * @property ErexxWhatsappInvitation[] $erexxWhatsappInvitations
 * @property EsignAgreementDetails[] $esignAgreementDetails
 * @property EsignDocumentsTemplates[] $esignDocumentsTemplates
 * @property EsignOrganizationTracking[] $esignOrganizationTrackings
 * @property FinancerAssignedDesignations[] $financerAssignedDesignations
 * @property FinancerLoanNegativeLocation[] $financerLoanNegativeLocations
 * @property FinancerNoticeBoard[] $financerNoticeBoards
 * @property FinancerRewards[] $financerRewards
 * @property FinancerVehicleBrand[] $financerVehicleBrands
 * @property FinancerVehicleTypes[] $financerVehicleTypes
 * @property FollowedOrganizations[] $followedOrganizations
 * @property JobDescription[] $jobDescriptions
 * @property LoanApplicationLogs[] $loanApplicationLogs
 * @property LoanApplicationPartners[] $loanApplicationPartners
 * @property LoanApplicationPartners[] $loanApplicationPartners0
 * @property LoanApplications[] $loanApplications
 * @property LoanApplications[] $loanApplications0
 * @property LoanSanctionReports[] $loanSanctionReports
 * @property MockAssignedBoards[] $mockAssignedBoards
 * @property MockCourses[] $mockCourses
 * @property MockQuizPool[] $mockQuizPools
 * @property OpenAssignedTitles[] $openAssignedTitles
 * @property OrganizationApps[] $organizationApps
 * @property OrganizationAssignedCategories[] $organizationAssignedCategories
 * @property OrganizationBlogInformation[] $organizationBlogInformations
 * @property OrganizationEmployeeBenefits[] $organizationEmployeeBenefits
 * @property OrganizationEmployees[] $organizationEmployees
 * @property OrganizationFeeAmount[] $organizationFeeAmounts
 * @property OrganizationImages[] $organizationImages
 * @property OrganizationInterviewProcess[] $organizationInterviewProcesses
 * @property OrganizationLabels[] $organizationLabels
 * @property OrganizationLoanSchemes[] $organizationLoanSchemes
 * @property OrganizationLoanSchemes[] $organizationLoanSchemes0
 * @property OrganizationLocations[] $organizationLocations
 * @property OrganizationOtherDetails[] $organizationOtherDetails
 * @property OrganizationProducts[] $organizationProducts
 * @property OrganizationQuestionnaire[] $organizationQuestionnaires
 * @property OrganizationReviews[] $organizationReviews
 * @property OrganizationVideos[] $organizationVideos
 * @property Industries $industryEnc
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property OrganizationTypes $organizationTypeEnc
 * @property BusinessActivities $businessActivityEnc
 * @property QuizSponsors[] $quizSponsors
 * @property RatingSystem[] $ratingSystems
 * @property Referral[] $referrals
 * @property Users[] $userEncs
 * @property ReferralSignUpTracking[] $referralSignUpTrackings
 * @property RejectionReasons[] $rejectionReasons
 * @property Reviews[] $reviews
 * @property Roles[] $roles
 * @property SalaryReviews[] $salaryReviews
 * @property SelectedServices[] $selectedServices
 * @property ShortlistedApplicants[] $shortlistedApplicants
 * @property ShortlistedOrganizations[] $shortlistedOrganizations
 * @property Skills[] $skills
 * @property UserRoles[] $userRoles
 */
class Organizations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organizations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_enc_id', 'name', 'slug', 'initials_color', 'created_by'], 'required'],
            [['establishment_year', 'created_on', 'last_updated_on'], 'safe'],
            [['description', 'mission', 'vision', 'value', 'status'], 'string'],
            [['number_of_employees', 'is_sponsored', 'is_featured', 'is_email_verified', 'is_phone_verified', 'is_startup', 'is_erexx_registered', 'is_erexx_approved', 'has_loan_featured', 'has_skillup_featured', 'has_placement_rights', 'contact_status', 'is_claimed', 'is_deleted'], 'integer'],
            [['organization_enc_id', 'organization_type_enc_id', 'business_activity_enc_id', 'industry_enc_id', 'name', 'slug', 'logo', 'logo_location', 'cover_image', 'cover_image_location', 'tag_line', 'website', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['email', 'facebook', 'google', 'twitter', 'instagram', 'linkedin'], 'string', 'max' => 50],
            [['initials_color'], 'string', 'max' => 7],
            [['phone', 'fax'], 'string', 'max' => 15],
            [['slug'], 'unique'],
            [['organization_enc_id'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['industry_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['industry_enc_id' => 'industry_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationTypes::className(), 'targetAttribute' => ['organization_type_enc_id' => 'organization_type_enc_id']],
            [['business_activity_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['business_activity_enc_id' => 'business_activity_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategories()
    {
        return $this->hasMany(AssignedCategories::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCollegeCourses()
    {
        return $this->hasMany(AssignedCollegeCourses::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerDealers()
    {
        return $this->hasMany(AssignedFinancerDealers::className(), ['dealer_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanTypes()
    {
        return $this->hasMany(AssignedFinancerLoanType::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanTypes0()
    {
        return $this->hasMany(AssignedFinancerLoanTypes::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLenderServices()
    {
        return $this->hasMany(AssignedLenderServices::className(), ['provider_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLoanProviders()
    {
        return $this->hasMany(AssignedLoanProvider::className(), ['provider_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedOrganizationFeeComponents()
    {
        return $this->hasMany(AssignedOrganizationFeeComponent::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedQuizTos()
    {
        return $this->hasMany(AssignedQuizTo::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedSupervisors()
    {
        return $this->hasMany(AssignedSupervisor::className(), ['assigned_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTags()
    {
        return $this->hasMany(AssignedTags::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedWebinarTos()
    {
        return $this->hasMany(AssignedWebinarTo::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankDetails()
    {
        return $this->hasMany(BankDetails::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarkedHiringTemplates()
    {
        return $this->hasMany(BookmarkedHiringTemplates::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarkedQuestionnaireTemplates()
    {
        return $this->hasMany(BookmarkedQuestionnaireTemplates::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimServiceableLocations()
    {
        return $this->hasMany(ClaimServiceableLocations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimServiceableLocations0()
    {
        return $this->hasMany(ClaimServiceableLocations::className(), ['claim_college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCourses()
    {
        return $this->hasMany(CollegeCourses::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCutoffs()
    {
        return $this->hasMany(CollegeCutoff::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeInfrastructureDetails()
    {
        return $this->hasMany(CollegeInfrastructureDetail::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegePlacementHighlights()
    {
        return $this->hasMany(CollegePlacementHighlights::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeRecruitmentByCourses()
    {
        return $this->hasMany(CollegeRecruitmentByCourse::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeScholarships()
    {
        return $this->hasMany(CollegeScholarships::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeSettings()
    {
        return $this->hasMany(CollegeSettings::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationParticipants()
    {
        return $this->hasMany(ConversationParticipants::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCredentials()
    {
        return $this->hasMany(Credentials::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignations()
    {
        return $this->hasMany(Designations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeOrgApplications()
    {
        return $this->hasMany(DropResumeOrgApplication::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeUnselectedTitles()
    {
        return $this->hasMany(DropResumeUnselectedTitles::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalRequirements()
    {
        return $this->hasMany(EducationalRequirements::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailLogs()
    {
        return $this->hasMany(EmailLogs::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeBenefits()
    {
        return $this->hasMany(EmployeeBenefits::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications()
    {
        return $this->hasMany(EmployerApplications::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxActivityTracks()
    {
        return $this->hasMany(ErexxActivityTracks::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxCollaborators()
    {
        return $this->hasMany(ErexxCollaborators::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxCollaborators0()
    {
        return $this->hasMany(ErexxCollaborators::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxEmployerApplications()
    {
        return $this->hasMany(ErexxEmployerApplications::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxWhatsappInvitations()
    {
        return $this->hasMany(ErexxWhatsappInvitation::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignAgreementDetails()
    {
        return $this->hasMany(EsignAgreementDetails::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignDocumentsTemplates()
    {
        return $this->hasMany(EsignDocumentsTemplates::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignOrganizationTrackings()
    {
        return $this->hasMany(EsignOrganizationTracking::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerAssignedDesignations()
    {
        return $this->hasMany(FinancerAssignedDesignations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanNegativeLocations()
    {
        return $this->hasMany(FinancerLoanNegativeLocation::className(), ['financer_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerNoticeBoards()
    {
        return $this->hasMany(FinancerNoticeBoard::className(), ['financer_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerRewards()
    {
        return $this->hasMany(FinancerRewards::className(), ['financer_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerVehicleBrands()
    {
        return $this->hasMany(FinancerVehicleBrand::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerVehicleTypes()
    {
        return $this->hasMany(FinancerVehicleTypes::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowedOrganizations()
    {
        return $this->hasMany(FollowedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobDescriptions()
    {
        return $this->hasMany(JobDescription::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationLogs()
    {
        return $this->hasMany(LoanApplicationLogs::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationPartners()
    {
        return $this->hasMany(LoanApplicationPartners::className(), ['provider_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationPartners0()
    {
        return $this->hasMany(LoanApplicationPartners::className(), ['partner_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplications()
    {
        return $this->hasMany(LoanApplications::className(), ['college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplications0()
    {
        return $this->hasMany(LoanApplications::className(), ['assigned_dealer' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanSanctionReports()
    {
        return $this->hasMany(LoanSanctionReports::className(), ['loan_provider_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockAssignedBoards()
    {
        return $this->hasMany(MockAssignedBoards::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockCourses()
    {
        return $this->hasMany(MockCourses::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockQuizPools()
    {
        return $this->hasMany(MockQuizPool::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenAssignedTitles()
    {
        return $this->hasMany(OpenAssignedTitles::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationApps()
    {
        return $this->hasMany(OrganizationApps::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationAssignedCategories()
    {
        return $this->hasMany(OrganizationAssignedCategories::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationBlogInformations()
    {
        return $this->hasMany(OrganizationBlogInformation::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEmployeeBenefits()
    {
        return $this->hasMany(OrganizationEmployeeBenefits::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEmployees()
    {
        return $this->hasMany(OrganizationEmployees::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationFeeAmounts()
    {
        return $this->hasMany(OrganizationFeeAmount::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationImages()
    {
        return $this->hasMany(OrganizationImages::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationInterviewProcesses()
    {
        return $this->hasMany(OrganizationInterviewProcess::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLabels()
    {
        return $this->hasMany(OrganizationLabels::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLoanSchemes()
    {
        return $this->hasMany(OrganizationLoanSchemes::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLoanSchemes0()
    {
        return $this->hasMany(OrganizationLoanSchemes::className(), ['loan_provider_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLocations()
    {
        return $this->hasMany(OrganizationLocations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationOtherDetails()
    {
        return $this->hasMany(OrganizationOtherDetails::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationProducts()
    {
        return $this->hasMany(OrganizationProducts::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationQuestionnaires()
    {
        return $this->hasMany(OrganizationQuestionnaire::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviews()
    {
        return $this->hasMany(OrganizationReviews::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationVideos()
    {
        return $this->hasMany(OrganizationVideos::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustryEnc()
    {
        return $this->hasOne(Industries::className(), ['industry_enc_id' => 'industry_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
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
    public function getOrganizationTypeEnc()
    {
        return $this->hasOne(OrganizationTypes::className(), ['organization_type_enc_id' => 'organization_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessActivityEnc()
    {
        return $this->hasOne(BusinessActivities::className(), ['business_activity_enc_id' => 'business_activity_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSponsors()
    {
        return $this->hasMany(QuizSponsors::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatingSystems()
    {
        return $this->hasMany(RatingSystem::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrals()
    {
        return $this->hasMany(Referral::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEncs()
    {
        return $this->hasMany(Users::className(), ['user_enc_id' => 'user_enc_id'])->viaTable('{{%referral}}', ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferralSignUpTrackings()
    {
        return $this->hasMany(ReferralSignUpTracking::className(), ['sign_up_org_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRejectionReasons()
    {
        return $this->hasMany(RejectionReasons::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['claimed_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Roles::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryReviews()
    {
        return $this->hasMany(SalaryReviews::className(), ['company_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSelectedServices()
    {
        return $this->hasMany(SelectedServices::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedApplicants()
    {
        return $this->hasMany(ShortlistedApplicants::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedOrganizations()
    {
        return $this->hasMany(ShortlistedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkills()
    {
        return $this->hasMany(Skills::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRoles::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
