<?php

namespace common\models;


/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id Primary Key
 * @property string $user_enc_id User Encrypted ID
 * @property string $username Username
 * @property string $email Email
 * @property string $password Password
 * @property string $auth_key User Authentication Key for verification
 * @property string $first_name First Name
 * @property string $last_name Last Name (Optional)
 * @property string $user_type_enc_id Foreign Key to User Types Table
 * @property string $phone Phone
 * @property string $address Address
 * @property string $initials_color Initials Color
 * @property string $image User Image
 * @property string $image_location User Image Location
 * @property string $cover_image User Cover Image
 * @property string $cover_image_location User Cover Image Location
 * @property string $description User Info
 * @property string $objective
 * @property string $facebook Facebook URL
 * @property string $google Google+ URL
 * @property string $twitter Twitter URL
 * @property string $telegram Telegram URL
 * @property string $instagram Instagram URL
 * @property string $linkedin Linkedin URL
 * @property string $youtube Youtube URL
 * @property string $skype Skype Username
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $job_function Foreign Key to Categories Table
 * @property string $asigned_job_function Foreign Key to Assigned Categories Table
 * @property string $dob Date of Birth
 * @property string $experience Experience
 * @property int $gender Gender (1 as Male, 2 as Female, 3 as Transgender, 4 as Rather not say)
 * @property int $is_available Is Currently Available (0 as No, 1 as Yes)
 * @property string $user_of User Of
 * @property string $created_on On which date User information was added to database
 * @property string $last_updated_on On which date User information was updated
 * @property int $is_email_verified Is User Email Verified (0 as False, 1 as True)
 * @property int $is_phone_verified Is User Phone Verified (0 as False, 1 as True)
 * @property int $is_credential_change
 * @property string $status User Status (Active, Inactive, Pending)
 * @property string $last_visit user last login details
 * @property string $last_visit_through user last login through which method
 * @property string $signed_up_through from where user has first signed up
 * @property int $is_deleted Is User Deleted (0 as False, 1 as True)
 *
 * @property LoanApplications[] $loanApplications3
 * @property CreditLoanApplicationReports[] $creditLoanApplicationReports
 * @property IndianGovtDepartments[] $indianGovtDepartments
 * @property UsaDepartments[] $usaDepartments
 * @property UsaProfileCodes[] $usaProfileCodes
 * @property UsaProfileCodes[] $usaProfileCodes0
 * @property ApiJobs[] $apiJobs
 * @property ApiJobsPlacementCities[] $apiJobsPlacementCities
 * @property ApiJobsPlacementCities[] $apiJobsPlacementCities0
 * @property AppEmpBenefitTemplate[] $appEmpBenefitTemplates
 * @property AppEmpBenefitTemplate[] $appEmpBenefitTemplates0
 * @property AppInterviewQuestionnaireTemplate[] $appInterviewQuestionnaireTemplates
 * @property AppInterviewQuestionnaireTemplate[] $appInterviewQuestionnaireTemplates0
 * @property ApplicationEduReqTemplate[] $applicationEduReqTemplates
 * @property ApplicationEduReqTemplate[] $applicationEduReqTemplates0
 * @property ApplicationOptionsTemplate[] $applicationOptionsTemplates
 * @property ApplicationOptionsTemplate[] $applicationOptionsTemplates0
 * @property ApplicationSkillsTemplate[] $applicationSkillsTemplates
 * @property ApplicationSkillsTemplate[] $applicationSkillsTemplates0
 * @property ApplicationTemplateJobDescription[] $applicationTemplateJobDescriptions
 * @property ApplicationTemplateJobDescription[] $applicationTemplateJobDescriptions0
 * @property ApplicationTemplates[] $applicationTemplates
 * @property ApplicationTemplates[] $applicationTemplates0
 * @property ApplicationUnclaimOptions[] $applicationUnclaimOptions
 * @property ApplicationUnclaimOptions[] $applicationUnclaimOptions0
 * @property AppliedTrainingApplications[] $appliedTrainingApplications
 * @property AppliedTrainingApplications[] $appliedTrainingApplications0
 * @property AppliedTrainingBatches[] $appliedTrainingBatches
 * @property AppliedTrainingBatches[] $appliedTrainingBatches0
 * @property AssignedCategories[] $assignedCategories
 * @property AssignedCategories[] $assignedCategories0
 * @property AssignedCollegeCourses[] $assignedCollegeCourses
 * @property AssignedCollegeCourses[] $assignedCollegeCourses0
 * @property AssignedEducationalRequirements[] $assignedEducationalRequirements
 * @property AssignedEducationalRequirements[] $assignedEducationalRequirements0
 * @property AssignedFinancerLoanPartners[] $assignedFinancerLoanPartners
 * @property AssignedFinancerLoanPartners[] $assignedFinancerLoanPartners0
 * @property AssignedFinancerLoanPartners[] $assignedFinancerLoanPartners1
 * @property AssignedFinancerLoanTypes[] $assignedFinancerLoanTypes
 * @property AssignedFinancerLoanTypes[] $assignedFinancerLoanTypes0
 * @property AssignedFinancerLoanTypes[] $assignedFinancerLoanTypes1
 * @property AssignedIndianJobs[] $assignedIndianJobs
 * @property AssignedIndianJobs[] $assignedIndianJobs0
 * @property AssignedIndustries[] $assignedIndustries
 * @property AssignedIndustries[] $assignedIndustries0
 * @property AssignedJobDescription[] $assignedJobDescriptions
 * @property AssignedJobDescription[] $assignedJobDescriptions0
 * @property AssignedLoanProvider[] $assignedLoanProviders
 * @property AssignedLoanProvider[] $assignedLoanProviders0
 * @property AssignedOrganizationFeeComponent[] $assignedOrganizationFeeComponents
 * @property AssignedSkills[] $assignedSkills
 * @property AssignedSkills[] $assignedSkills0
 * @property AssignedStaticWidgets[] $assignedStaticWidgets
 * @property AssignedTags[] $assignedTags
 * @property AssignedTags[] $assignedTags0
 * @property AssignedUnclaimCollegeCourses[] $assignedUnclaimCollegeCourses
 * @property AssignedUnclaimCollegeCourses[] $assignedUnclaimCollegeCourses0
 * @property AssignedWebinarTo[] $assignedWebinarTos
 * @property Auth[] $auths
 * @property CandidateConsiderJobs[] $candidateConsiderJobs
 * @property CandidateRejection[] $candidateRejections
 * @property CandidateRejection[] $candidateRejections0
 * @property CandidateRejectionReasons[] $candidateRejectionReasons
 * @property CareerAdvicePostComments[] $careerAdvicePostComments
 * @property CareerAdvisePosts[] $careerAdvisePosts
 * @property CareerAdvisePosts[] $careerAdvisePosts0
 * @property Categories[] $categories
 * @property Categories[] $categories0
 * @property CategoryTags[] $categoryTags
 * @property CategoryTags[] $categoryTags0
 * @property ClassAccess[] $classAccesses
 * @property ClassAccess[] $classAccesses0
 * @property ClassNotes[] $classNotes
 * @property CollectedDocuments[] $collectedDocuments
 * @property CollegeCourses[] $collegeCourses
 * @property CollegeCourses[] $collegeCourses0
 * @property CollegeCoursesPool[] $collegeCoursesPools
 * @property CollegeCoursesPool[] $collegeCoursesPools0
 * @property CollegePlacementHighlights[] $collegePlacementHighlights
 * @property CollegePlacementHighlights[] $collegePlacementHighlights0
 * @property CollegeRecruitmentByCourse[] $collegeRecruitmentByCourses
 * @property CollegeRecruitmentByCourse[] $collegeRecruitmentByCourses0
 * @property CollegeScholarships[] $collegeScholarships
 * @property CollegeScholarships[] $collegeScholarships0
 * @property CollegeSections[] $collegeSections
 * @property CollegeSettings[] $collegeSettings
 * @property CollegeSettings[] $collegeSettings0
 * @property CollegeStudentsReview[] $collegeStudentsReviews
 * @property CollegeStudentsReview[] $collegeStudentsReviews0
 * @property Courses[] $courses
 * @property Currencies[] $currencies
 * @property Designations[] $designations
 * @property Designations[] $designations0
 * @property DevelopmentTracking[] $developmentTrackings
 * @property DevelopmentTracking[] $developmentTrackings0
 * @property DomainNames[] $domainNames
 * @property DomainNames[] $domainNames0
 * @property DomainRoutes[] $domainRoutes
 * @property DomainRoutes[] $domainRoutes0
 * @property EducationLoanPayments[] $educationLoanPayments
 * @property EducationLoanPayments[] $educationLoanPayments0
 * @property EducationalRequirements[] $educationalRequirements
 * @property EducationalRequirements[] $educationalRequirements0
 * @property EmailLogs[] $emailLogs
 * @property EmailTemplates[] $emailTemplates
 * @property EmailTemplates[] $emailTemplates0
 * @property EmployerReviews[] $employerReviews
 * @property EmployerReviews[] $employerReviews0
 * @property ErexxActivityTracks[] $erexxActivityTracks
 * @property ErexxActivityTracks[] $erexxActivityTracks0
 * @property ErexxCollegeRejectionReasons[] $erexxCollegeRejectionReasons
 * @property ErexxCollegeRejections[] $erexxCollegeRejections
 * @property ErexxEmployerApplications[] $erexxEmployerApplications
 * @property ErexxEmployerApplications[] $erexxEmployerApplications0
 * @property ErexxWhatsappInvitation[] $erexxWhatsappInvitations
 * @property ExternalNewsUpdate[] $externalNewsUpdates
 * @property ExternalNewsUpdate[] $externalNewsUpdates0
 * @property FeedSources[] $feedSources
 * @property Files[] $files
 * @property Files[] $files0
 * @property GitApplications[] $gitApplications
 * @property GitApplications[] $gitApplications0
 * @property GitOrganizations[] $gitOrganizations
 * @property GitOrganizations[] $gitOrganizations0
 * @property HiringProcessNotes[] $hiringProcessNotes
 * @property HiringProcessNotes[] $hiringProcessNotes0
 * @property HiringProcessTemplateFields[] $hiringProcessTemplateFields
 * @property HiringProcessTemplateFields[] $hiringProcessTemplateFields0
 * @property HiringProcessTemplates[] $hiringProcessTemplates
 * @property HiringProcessTemplates[] $hiringProcessTemplates0
 * @property IndianGovtJobs[] $indianGovtJobs
 * @property InstituteLeads[] $instituteLeads
 * @property InstituteLeads[] $instituteLeads0
 * @property InstituteLeadsPayments[] $instituteLeadsPayments
 * @property InstituteLeadsPayments[] $instituteLeadsPayments0
 * @property InstituteStudentsReview[] $instituteStudentsReviews
 * @property InstituteStudentsReview[] $instituteStudentsReviews0
 * @property JobDescription[] $jobDescriptions
 * @property JobDescription[] $jobDescriptions0
 * @property Labels[] $labels
 * @property Labels[] $labels0
 * @property LeadApplicationCalling[] $leadApplicationCallings
 * @property LeadApplicationCalling[] $leadApplicationCallings0
 * @property LeadsApplications[] $leadsApplications
 * @property LeadsApplications[] $leadsApplications0
 * @property LeadsApplications[] $leadsApplications1
 * @property LeadsApplications[] $leadsApplications2
 * @property LeadsApplications[] $leadsApplications3
 * @property LeadsCollegePreference[] $leadsCollegePreferences
 * @property LeadsCollegePreference[] $leadsCollegePreferences0
 * @property LeadsParentInformation[] $leadsParentInformations
 * @property LeadsParentInformation[] $leadsParentInformations0
 * @property LoanApplicantResidentialInfo[] $loanApplicantResidentialInfos
 * @property LoanApplicantResidentialInfo[] $loanApplicantResidentialInfos0
 * @property LoanApplicationLogs[] $loanApplicationLogs
 * @property LoanApplications[] $loanApplications
 * @property LoanApplications[] $loanApplications0
 * @property LoanApplicationsCollegePreference[] $loanApplicationsCollegePreferences
 * @property LoanApplicationsCollegePreference[] $loanApplicationsCollegePreferences0
 * @property LoanCandidateEducation[] $loanCandidateEducations
 * @property LoanCandidateEducation[] $loanCandidateEducations0
 * @property LoanCertificates[] $loanCertificates
 * @property LoanCertificates[] $loanCertificates0
 * @property LoanCoApplicants[] $loanCoApplicants
 * @property LoanCoApplicants[] $loanCoApplicants0
 * @property LoanDocuments[] $loanDocuments
 * @property LoanPurpose[] $loanPurposes
 * @property LoanSanctionReports[] $loanSanctionReports
 * @property LoanSanctionReports[] $loanSanctionReports0
 * @property MisAssignedMenuItems[] $misAssignedMenuItems
 * @property MisAssignedMenuItems[] $misAssignedMenuItems0
 * @property MisAssignedMenus[] $misAssignedMenuses
 * @property MisAssignedMenus[] $misAssignedMenuses0
 * @property MisEmailLogs[] $misEmailLogs
 * @property MisUserTasks[] $misUserTasks
 * @property MisUserTasks[] $misUserTasks0
 * @property MisUserTasks[] $misUserTasks1
 * @property MockBoards[] $mockBoards
 * @property MockCoursePool[] $mockCoursePools
 * @property MockCourses[] $mockCourses
 * @property MockLabelPool[] $mockLabelPools
 * @property MockLabels[] $mockLabels
 * @property MockLevels[] $mockLevels
 * @property MockQuizPool[] $mockQuizPools
 * @property MockQuizQuestionsPool[] $mockQuizQuestionsPools
 * @property MockQuizQuestionsPool[] $mockQuizQuestionsPools0
 * @property MockQuizzes[] $mockQuizzes
 * @property MockQuizzes[] $mockQuizzes0
 * @property MockSubjects[] $mockSubjects
 * @property MockSubjectsPool[] $mockSubjectsPools
 * @property MockTakenQuizzes[] $mockTakenQuizzes
 * @property NewsTags[] $newsTags
 * @property NewsTags[] $newsTags0
 * @property OnlineClassComments[] $onlineClassComments
 * @property OnlineClassComments[] $onlineClassComments0
 * @property OpenAssignedTitles[] $openAssignedTitles
 * @property OpenAssignedTitles[] $openAssignedTitles0
 * @property OrganizationFeeAmount[] $organizationFeeAmounts
 * @property OrganizationFeeComponents[] $organizationFeeComponents
 * @property OrganizationLabels[] $organizationLabels
 * @property OrganizationLabels[] $organizationLabels0
 * @property OrganizationLoanSchemes[] $organizationLoanSchemes
 * @property OrganizationQuestionnaire[] $organizationQuestionnaires
 * @property OrganizationQuestionnaire[] $organizationQuestionnaires0
 * @property Organizations[] $organizations
 * @property Organizations[] $organizations0
 * @property OrganizationsDatabase[] $organizationsDatabases
 * @property PathToClaimOrgLoanApplication[] $pathToClaimOrgLoanApplications
 * @property PathToOpenLeads[] $pathToOpenLeads
 * @property PollCounterr[] $pollCounterrs
 * @property PoolWebinarOutcomes[] $poolWebinarOutcomes
 * @property PostCategories[] $postCategories
 * @property PostCategories[] $postCategories0
 * @property PostComments[] $postComments
 * @property QuestionPoolTags[] $questionPoolTags
 * @property QuestionPoolTags[] $questionPoolTags0
 * @property QuestionnaireFieldOptions[] $questionnaireFieldOptions
 * @property QuestionnaireFieldOptions[] $questionnaireFieldOptions0
 * @property QuestionnaireFields[] $questionnaireFields
 * @property QuestionnaireFields[] $questionnaireFields0
 * @property QuestionnaireTemplates[] $questionnaireTemplates
 * @property QuestionnaireTemplates[] $questionnaireTemplates0
 * @property QuestionsPool[] $questionsPools
 * @property QuestionsPool[] $questionsPools0
 * @property QuestionsPoolAnswer[] $questionsPoolAnswers
 * @property QuestionsPoolAnswer[] $questionsPoolAnswers0
 * @property QuizAssignedGroup[] $quizAssignedGroups
 * @property QuizAssignedGroup[] $quizAssignedGroups0
 * @property QuizPool[] $quizPools
 * @property QuizPool[] $quizPools0
 * @property QuizQuestionsPool[] $quizQuestionsPools
 * @property QuizQuestionsPool[] $quizQuestionsPools0
 * @property Quizzes[] $quizzes
 * @property Quizzes[] $quizzes0
 * @property RatingQuestions[] $ratingQuestions
 * @property RatingQuestions[] $ratingQuestions0
 * @property RatingSystem[] $ratingSystems
 * @property RatingSystem[] $ratingSystems0
 * @property RatingSystemAnswers[] $ratingSystemAnswers
 * @property RatingSystemAnswers[] $ratingSystemAnswers0
 * @property RawDatabase[] $rawDatabases
 * @property Referral[] $referrals
 * @property Referral[] $referrals0
 * @property Organizations[] $organizationEncs
 * @property ReferralSignUpTracking[] $referralSignUpTrackings
 * @property RejectionReasons[] $rejectionReasons
 * @property ResumeTemplates[] $resumeTemplates
 * @property Reviews[] $reviews
 * @property SalaryReviews[] $salaryReviews
 * @property SalaryReviews[] $salaryReviews0
 * @property SchoolStudentsReview[] $schoolStudentsReviews
 * @property SchoolStudentsReview[] $schoolStudentsReviews0
 * @property Seo[] $seos
 * @property Seo[] $seos0
 * @property ShortlistedApplicants[] $shortlistedApplicants
 * @property ShortlistedApplicants[] $shortlistedApplicants0
 * @property ShortlistedApplicants[] $shortlistedApplicants1
 * @property Skills[] $skills
 * @property Skills[] $skills0
 * @property SkillsUpEmbedPosts[] $skillsUpEmbedPosts
 * @property SkillsUpEmbedPosts[] $skillsUpEmbedPosts0
 * @property SkillsUpPostAssignedBlogs[] $skillsUpPostAssignedBlogs
 * @property SkillsUpPostAssignedBlogs[] $skillsUpPostAssignedBlogs0
 * @property SkillsUpPostAssignedEmbeds[] $skillsUpPostAssignedEmbeds
 * @property SkillsUpPostAssignedEmbeds[] $skillsUpPostAssignedEmbeds0
 * @property SkillsUpPostAssignedIndustries[] $skillsUpPostAssignedIndustries
 * @property SkillsUpPostAssignedIndustries[] $skillsUpPostAssignedIndustries0
 * @property SkillsUpPostAssignedNews[] $skillsUpPostAssignedNews
 * @property SkillsUpPostAssignedNews[] $skillsUpPostAssignedNews0
 * @property SkillsUpPostAssignedSkills[] $skillsUpPostAssignedSkills
 * @property SkillsUpPostAssignedSkills[] $skillsUpPostAssignedSkills0
 * @property SkillsUpPostAssignedVideo[] $skillsUpPostAssignedVideos
 * @property SkillsUpPostAssignedVideo[] $skillsUpPostAssignedVideos0
 * @property SkillsUpPosts[] $skillsUpPosts
 * @property SkillsUpPosts[] $skillsUpPosts0
 * @property SkillsUpSources[] $skillsUpSources
 * @property SkillsUpSources[] $skillsUpSources0
 * @property SocialGroups[] $socialGroups
 * @property SocialGroups[] $socialGroups0
 * @property SocialLinks[] $socialLinks
 * @property SocialLinks[] $socialLinks0
 * @property SocialPlatforms[] $socialPlatforms
 * @property SocialPlatforms[] $socialPlatforms0
 * @property SpeakerExpertises[] $speakerExpertises
 * @property Speakers[] $speakers
 * @property Speakers[] $speakers0
 * @property Speakers[] $speakers1
 * @property StaticWidgets[] $staticWidgets
 * @property StaticWidgets[] $staticWidgets0
 * @property SubmittedVideos[] $submittedVideos
 * @property SubmittedVideos[] $submittedVideos0
 * @property SubmittedVideos[] $submittedVideos1
 * @property SuggestionAnsweredQuestionnaire[] $suggestionAnsweredQuestionnaires
 * @property SuggestionAnsweredQuestionnaire[] $suggestionAnsweredQuestionnaires0
 * @property SuggestionGroup[] $suggestionGroups
 * @property SuggestionGroup[] $suggestionGroups0
 * @property SuggestionQuestionnaire[] $suggestionQuestionnaires
 * @property SuggestionQuestionnaire[] $suggestionQuestionnaires0
 * @property SuggestionQuestionnaireFields[] $suggestionQuestionnaireFields
 * @property SuggestionQuestionnaireFields[] $suggestionQuestionnaireFields0
 * @property Tags[] $tags
 * @property Tags[] $tags0
 * @property Teachers[] $teachers
 * @property TitleMergedDb[] $titleMergedDbs
 * @property TitleMergedDb[] $titleMergedDbs0
 * @property Topics[] $topics
 * @property TrainingProgramApplication[] $trainingProgramApplications
 * @property TrainingProgramApplication[] $trainingProgramApplications0
 * @property TrainingProgramBatches[] $trainingProgramBatches
 * @property TrainingProgramBatches[] $trainingProgramBatches0
 * @property TrainingProgramBatchesBk[] $trainingProgramBatchesBks
 * @property TrainingProgramBatchesBk[] $trainingProgramBatchesBks0
 * @property TrainingProgramSkills[] $trainingProgramSkills
 * @property TrainingProgramSkills[] $trainingProgramSkills0
 * @property TwitterJobSkills[] $twitterJobSkills
 * @property TwitterJobSkills[] $twitterJobSkills0
 * @property TwitterJobs[] $twitterJobs
 * @property TwitterJobs[] $twitterJobs0
 * @property TwitterPlacementCities[] $twitterPlacementCities
 * @property TwitterPlacementCities[] $twitterPlacementCities0
 * @property UnclaimAssignedIndustries[] $unclaimAssignedIndustries
 * @property UnclaimAssignedIndustries[] $unclaimAssignedIndustries0
 * @property UnclaimOrganizationImages[] $unclaimOrganizationImages
 * @property UnclaimOrganizationImages[] $unclaimOrganizationImages0
 * @property UnclaimOrganizationLabels[] $unclaimOrganizationLabels
 * @property UnclaimOrganizationLabels[] $unclaimOrganizationLabels0
 * @property UnclaimOrganizationLocations[] $unclaimOrganizationLocations
 * @property UnclaimOrganizationLocations[] $unclaimOrganizationLocations0
 * @property UnclaimedOrganizations[] $unclaimedOrganizations
 * @property UserOtherDetails[] $userOtherDetails
 * @property UserRoles[] $userRoles
 * @property UserRoles[] $userRoles0
 * @property UserRoles[] $userRoles1
 * @property UserRoles[] $userRoles2
 * @property UserVerificationTokens[] $userVerificationTokens
 * @property UserWebinarInterest[] $userWebinarInterests
 * @property UserWebinarInterest[] $userWebinarInterests0
 * @property Organizations $organizationEnc
 * @property UserTypes $userTypeEnc
 * @property Cities $cityEnc
 * @property VideoSessions[] $videoSessions
 * @property Webinar[] $webinars
 * @property Webinar[] $webinars0
 * @property WebinarConversationMessages[] $webinarConversationMessages
 * @property WebinarConversationMessages[] $webinarConversationMessages0
 * @property WebinarConversations[] $webinarConversations
 * @property WebinarConversations[] $webinarConversations0
 * @property WebinarEvents[] $webinarEvents
 * @property WebinarEvents[] $webinarEvents0
 * @property WebinarModerators[] $webinarModerators
 * @property WebinarModerators[] $webinarModerators0
 * @property WebinarOutcomes[] $webinarOutcomes
 * @property WebinarOutcomes[] $webinarOutcomes0
 * @property WebinarPayments[] $webinarPayments
 * @property WebinarPayments[] $webinarPayments0
 * @property WebinarRegistrations[] $webinarRegistrations
 * @property WebinarRegistrations[] $webinarRegistrations0
 * @property WebinarRequest[] $webinarRequests
 * @property WebinarRequest[] $webinarRequests0
 * @property WebinarRequestSpeakers[] $webinarRequestSpeakers
 * @property WebinarRequestSpeakers[] $webinarRequestSpeakers0
 * @property WebinarSessions[] $webinarSessions
 * @property WebinarSpeakers[] $webinarSpeakers
 * @property WebinarSpeakers[] $webinarSpeakers0
 * @property SharedLoanApplications[] $sharedLoanApplications
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_enc_id', 'username', 'password', 'auth_key', 'first_name', 'user_type_enc_id', 'initials_color'], 'required'],
            [['description', 'objective', 'user_of', 'status', 'last_visit_through', 'signed_up_through'], 'string'],
            [['dob', 'created_on', 'last_updated_on', 'last_visit'], 'safe'],
            [['gender', 'is_available', 'is_email_verified', 'is_phone_verified', 'is_credential_change', 'is_deleted'], 'integer'],
            [['user_enc_id', 'auth_key', 'user_type_enc_id', 'address', 'image', 'image_location', 'cover_image', 'cover_image_location', 'city_enc_id', 'organization_enc_id', 'job_function', 'asigned_job_function'], 'string', 'max' => 100],
            [['username', 'email', 'facebook', 'google', 'twitter', 'telegram', 'instagram', 'linkedin', 'youtube', 'skype'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 200],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone', 'experience'], 'string', 'max' => 15],
            [['initials_color'], 'string', 'max' => 7],
            [['user_enc_id'], 'unique'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['user_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::className(), 'targetAttribute' => ['user_type_enc_id' => 'user_type_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessRoutes()
    {
        return $this->hasMany(AccessRoutes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessRoutes0()
    {
        return $this->hasMany(AccessRoutes::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnsweredQuestionnaires()
    {
        return $this->hasMany(AnsweredQuestionnaire::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnsweredQuestionnaires0()
    {
        return $this->hasMany(AnsweredQuestionnaire::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnsweredQuestionnaireFields()
    {
        return $this->hasMany(AnsweredQuestionnaireFields::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnsweredQuestionnaireFields0()
    {
        return $this->hasMany(AnsweredQuestionnaireFields::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndianGovtDepartments()
    {
        return $this->hasMany(IndianGovtDepartments::className(), ['last_retrieved_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsaDepartments()
    {
        return $this->hasMany(UsaDepartments::className(), ['last_retrieved_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsaProfileCodes()
    {
        return $this->hasMany(UsaProfileCodes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsaProfileCodes0()
    {
        return $this->hasMany(UsaProfileCodes::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppEmpBenefitTemplates()
    {
        return $this->hasMany(AppEmpBenefitTemplate::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppEmpBenefitTemplates0()
    {
        return $this->hasMany(AppEmpBenefitTemplate::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppInterviewQuestionnaireTemplates()
    {
        return $this->hasMany(AppInterviewQuestionnaireTemplate::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppInterviewQuestionnaireTemplates0()
    {
        return $this->hasMany(AppInterviewQuestionnaireTemplate::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEduReqTemplates()
    {
        return $this->hasMany(ApplicationEduReqTemplate::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEduReqTemplates0()
    {
        return $this->hasMany(ApplicationEduReqTemplate::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEducationalRequirements()
    {
        return $this->hasMany(ApplicationEducationalRequirements::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEducationalRequirements0()
    {
        return $this->hasMany(ApplicationEducationalRequirements::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEmployeeBenefits()
    {
        return $this->hasMany(ApplicationEmployeeBenefits::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEmployeeBenefits0()
    {
        return $this->hasMany(ApplicationEmployeeBenefits::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewLocations()
    {
        return $this->hasMany(ApplicationInterviewLocations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewLocations0()
    {
        return $this->hasMany(ApplicationInterviewLocations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewQuestionnaires()
    {
        return $this->hasMany(ApplicationInterviewQuestionnaire::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewQuestionnaires0()
    {
        return $this->hasMany(ApplicationInterviewQuestionnaire::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationJobDescriptions()
    {
        return $this->hasMany(ApplicationJobDescription::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationJobDescriptions0()
    {
        return $this->hasMany(ApplicationJobDescription::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationOptions()
    {
        return $this->hasMany(ApplicationOptions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationOptions0()
    {
        return $this->hasMany(ApplicationOptions::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationOptionsTemplates()
    {
        return $this->hasMany(ApplicationOptionsTemplate::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationOptionsTemplates0()
    {
        return $this->hasMany(ApplicationOptionsTemplate::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPlacementCities()
    {
        return $this->hasMany(ApplicationPlacementCities::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPlacementCities0()
    {
        return $this->hasMany(ApplicationPlacementCities::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPlacementLocations()
    {
        return $this->hasMany(ApplicationPlacementLocations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPlacementLocations0()
    {
        return $this->hasMany(ApplicationPlacementLocations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkills()
    {
        return $this->hasMany(ApplicationSkills::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkills0()
    {
        return $this->hasMany(ApplicationSkills::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkillsTemplates()
    {
        return $this->hasMany(ApplicationSkillsTemplate::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkillsTemplates0()
    {
        return $this->hasMany(ApplicationSkillsTemplate::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTemplateJobDescriptions()
    {
        return $this->hasMany(ApplicationTemplateJobDescription::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTemplateJobDescriptions0()
    {
        return $this->hasMany(ApplicationTemplateJobDescription::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTemplates()
    {
        return $this->hasMany(ApplicationTemplates::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTemplates0()
    {
        return $this->hasMany(ApplicationTemplates::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationUnclaimOptions()
    {
        return $this->hasMany(ApplicationUnclaimOptions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationUnclaimOptions0()
    {
        return $this->hasMany(ApplicationUnclaimOptions::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Applications::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications0()
    {
        return $this->hasMany(Applications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications1()
    {
        return $this->hasMany(Applications::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationLocations()
    {
        return $this->hasMany(AppliedApplicationLocations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationLocations0()
    {
        return $this->hasMany(AppliedApplicationLocations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationProcesses()
    {
        return $this->hasMany(AppliedApplicationProcess::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationProcesses0()
    {
        return $this->hasMany(AppliedApplicationProcess::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplications()
    {
        return $this->hasMany(AppliedApplications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplications0()
    {
        return $this->hasMany(AppliedApplications::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedTrainingApplications()
    {
        return $this->hasMany(AppliedTrainingApplications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedTrainingApplications0()
    {
        return $this->hasMany(AppliedTrainingApplications::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedTrainingBatches()
    {
        return $this->hasMany(AppliedTrainingBatches::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedTrainingBatches0()
    {
        return $this->hasMany(AppliedTrainingBatches::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategories()
    {
        return $this->hasMany(AssignedCategories::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategories0()
    {
        return $this->hasMany(AssignedCategories::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedEducationalRequirements()
    {
        return $this->hasMany(AssignedEducationalRequirements::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedEducationalRequirements0()
    {
        return $this->hasMany(AssignedEducationalRequirements::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedIndianJobs()
    {
        return $this->hasMany(AssignedIndianJobs::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedIndianJobs0()
    {
        return $this->hasMany(AssignedIndianJobs::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedIndustries()
    {
        return $this->hasMany(AssignedIndustries::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedIndustries0()
    {
        return $this->hasMany(AssignedIndustries::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedJobDescriptions()
    {
        return $this->hasMany(AssignedJobDescription::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedJobDescriptions0()
    {
        return $this->hasMany(AssignedJobDescription::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedSkills()
    {
        return $this->hasMany(AssignedSkills::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedSkills0()
    {
        return $this->hasMany(AssignedSkills::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedStaticWidgets()
    {
        return $this->hasMany(AssignedStaticWidgets::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTags()
    {
        return $this->hasMany(AssignedTags::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTags0()
    {
        return $this->hasMany(AssignedTags::className(), ['last_updated_by' => 'user_enc_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarkedHiringTemplates()
    {
        return $this->hasMany(BookmarkedHiringTemplates::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarkedHiringTemplates0()
    {
        return $this->hasMany(BookmarkedHiringTemplates::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarkedQuestionnaireTemplates()
    {
        return $this->hasMany(BookmarkedQuestionnaireTemplates::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarkedQuestionnaireTemplates0()
    {
        return $this->hasMany(BookmarkedQuestionnaireTemplates::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateJobTitles()
    {
        return $this->hasMany(CandidateJobTitle::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateRecords()
    {
        return $this->hasMany(CandidateRecords::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareerAdvises()
    {
        return $this->hasMany(CareerAdvise::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareerAdvises0()
    {
        return $this->hasMany(CareerAdvise::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareerQuestions()
    {
        return $this->hasMany(CareerQuestions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareerQuestions0()
    {
        return $this->hasMany(CareerQuestions::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedWebinarTos()
    {
        return $this->hasMany(AssignedWebinarTo::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareerAdvicePostComments()
    {
        return $this->hasMany(CareerAdvicePostComments::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareerAdvisePosts()
    {
        return $this->hasMany(CareerAdvisePosts::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareerAdvisePosts0()
    {
        return $this->hasMany(CareerAdvisePosts::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories0()
    {
        return $this->hasMany(Categories::className(), ['last_updated_by' => 'user_enc_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesLists()
    {
        return $this->hasMany(CategoriesList::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesLists0()
    {
        return $this->hasMany(CategoriesList::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitiesPriorities()
    {
        return $this->hasMany(CitiesPriority::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitiesPriorities0()
    {
        return $this->hasMany(CitiesPriority::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeStudentsReviews()
    {
        return $this->hasMany(CollegeStudentsReview::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeStudentsReviews0()
    {
        return $this->hasMany(CollegeStudentsReview::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contacts::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationMessages()
    {
        return $this->hasMany(ConversationMessages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationMessages0()
    {
        return $this->hasMany(ConversationMessages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationParticipants()
    {
        return $this->hasMany(ConversationParticipants::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationParticipants0()
    {
        return $this->hasMany(ConversationParticipants::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationParticipants1()
    {
        return $this->hasMany(ConversationParticipants::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversations()
    {
        return $this->hasMany(Conversations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversations0()
    {
        return $this->hasMany(Conversations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomForms()
    {
        return $this->hasMany(CustomForm::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomForms0()
    {
        return $this->hasMany(CustomForm::className(), ['created_by' => 'user_enc_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignations()
    {
        return $this->hasMany(Designations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignations0()
    {
        return $this->hasMany(Designations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainNames()
    {
        return $this->hasMany(DomainNames::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationLocations()
    {
        return $this->hasMany(DropResumeApplicationLocations::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationLocations0()
    {
        return $this->hasMany(DropResumeApplicationLocations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationLocations1()
    {
        return $this->hasMany(DropResumeApplicationLocations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationTitles()
    {
        return $this->hasMany(DropResumeApplicationTitles::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationTitles0()
    {
        return $this->hasMany(DropResumeApplicationTitles::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationTitles1()
    {
        return $this->hasMany(DropResumeApplicationTitles::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplications()
    {
        return $this->hasMany(DropResumeApplications::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplications0()
    {
        return $this->hasMany(DropResumeApplications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplications1()
    {
        return $this->hasMany(DropResumeApplications::className(), ['last_updated_by' => 'user_enc_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalRequirements()
    {
        return $this->hasMany(EducationalRequirements::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalRequirements0()
    {
        return $this->hasMany(EducationalRequirements::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalStreams()
    {
        return $this->hasMany(EducationalStreams::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalStreams0()
    {
        return $this->hasMany(EducationalStreams::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeBenefits()
    {
        return $this->hasMany(EmployeeBenefits::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeBenefits0()
    {
        return $this->hasMany(EmployeeBenefits::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications()
    {
        return $this->hasMany(EmployerApplications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications0()
    {
        return $this->hasMany(EmployerApplications::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerReviews()
    {
        return $this->hasMany(EmployerReviews::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerReviews0()
    {
        return $this->hasMany(EmployerReviews::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks0()
    {
        return $this->hasMany(Feedback::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowedOrganizations()
    {
        return $this->hasMany(FollowedOrganizations::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowedOrganizations0()
    {
        return $this->hasMany(FollowedOrganizations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowedOrganizations1()
    {
        return $this->hasMany(FollowedOrganizations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEncs()
    {
        return $this->hasMany(Organizations::className(), ['organization_enc_id' => 'organization_enc_id'])->viaTable('{{%followed_organizations}}', ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHiringProcessTemplateFields()
    {
        return $this->hasMany(HiringProcessTemplateFields::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHiringProcessTemplateFields0()
    {
        return $this->hasMany(HiringProcessTemplateFields::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHiringProcessTemplates()
    {
        return $this->hasMany(HiringProcessTemplates::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHiringProcessTemplates0()
    {
        return $this->hasMany(HiringProcessTemplates::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituteStudentsReviews()
    {
        return $this->hasMany(InstituteStudentsReview::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituteStudentsReviews0()
    {
        return $this->hasMany(InstituteStudentsReview::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewProcessFields()
    {
        return $this->hasMany(InterviewProcessFields::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewProcessFields0()
    {
        return $this->hasMany(InterviewProcessFields::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewSchedulers()
    {
        return $this->hasMany(InterviewScheduler::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewSchedulers0()
    {
        return $this->hasMany(InterviewScheduler::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewerRecords()
    {
        return $this->hasMany(InterviewerRecords::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewerRecords0()
    {
        return $this->hasMany(InterviewerRecords::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobDescriptions()
    {
        return $this->hasMany(JobDescription::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobDescriptions0()
    {
        return $this->hasMany(JobDescription::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningCornerResourceDiscussions()
    {
        return $this->hasMany(LearningCornerResourceDiscussion::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningCornerResourceDiscussions0()
    {
        return $this->hasMany(LearningCornerResourceDiscussion::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoComments()
    {
        return $this->hasMany(LearningVideoComments::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoLikes()
    {
        return $this->hasMany(LearningVideoLikes::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoTags()
    {
        return $this->hasMany(LearningVideoTags::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoTags0()
    {
        return $this->hasMany(LearningVideoTags::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideos()
    {
        return $this->hasMany(LearningVideos::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideos0()
    {
        return $this->hasMany(LearningVideos::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMisEmailLogs()
    {
        return $this->hasMany(MisEmailLogs::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewOrganizationReviews()
    {
        return $this->hasMany(NewOrganizationReviews::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewOrganizationReviews0()
    {
        return $this->hasMany(NewOrganizationReviews::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationAssignedCategories()
    {
        return $this->hasMany(OrganizationAssignedCategories::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationAssignedCategories0()
    {
        return $this->hasMany(OrganizationAssignedCategories::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationBlogInfoLocations()
    {
        return $this->hasMany(OrganizationBlogInfoLocations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationBlogInformations()
    {
        return $this->hasMany(OrganizationBlogInformation::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationBlogInformationImages()
    {
        return $this->hasMany(OrganizationBlogInformationImages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEmployeeBenefits()
    {
        return $this->hasMany(OrganizationEmployeeBenefits::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEmployeeBenefits0()
    {
        return $this->hasMany(OrganizationEmployeeBenefits::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEmployees()
    {
        return $this->hasMany(OrganizationEmployees::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEmployees0()
    {
        return $this->hasMany(OrganizationEmployees::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationImages()
    {
        return $this->hasMany(OrganizationImages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationImages0()
    {
        return $this->hasMany(OrganizationImages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationInterviewProcesses()
    {
        return $this->hasMany(OrganizationInterviewProcess::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationInterviewProcesses0()
    {
        return $this->hasMany(OrganizationInterviewProcess::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLocations()
    {
        return $this->hasMany(OrganizationLocations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLocations0()
    {
        return $this->hasMany(OrganizationLocations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationProductImages()
    {
        return $this->hasMany(OrganizationProductImages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationProductImages0()
    {
        return $this->hasMany(OrganizationProductImages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationProducts()
    {
        return $this->hasMany(OrganizationProducts::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationProducts0()
    {
        return $this->hasMany(OrganizationProducts::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationQuestionnaires()
    {
        return $this->hasMany(OrganizationQuestionnaire::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationQuestionnaires0()
    {
        return $this->hasMany(OrganizationQuestionnaire::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviewFeedbacks()
    {
        return $this->hasMany(OrganizationReviewFeedback::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviewFeedbacks0()
    {
        return $this->hasMany(OrganizationReviewFeedback::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviewFeedbacks1()
    {
        return $this->hasMany(OrganizationReviewFeedback::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviewLikeDislikes()
    {
        return $this->hasMany(OrganizationReviewLikeDislike::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviewLikeDislikes0()
    {
        return $this->hasMany(OrganizationReviewLikeDislike::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviews()
    {
        return $this->hasMany(OrganizationReviews::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviews0()
    {
        return $this->hasMany(OrganizationReviews::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationVideos()
    {
        return $this->hasMany(OrganizationVideos::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationVideos0()
    {
        return $this->hasMany(OrganizationVideos::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organizations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations0()
    {
        return $this->hasMany(Organizations::className(), ['last_updated_by' => 'user_enc_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategories::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories0()
    {
        return $this->hasMany(PostCategories::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostComments()
    {
        return $this->hasMany(PostComments::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEmbeddedImages()
    {
        return $this->hasMany(PostEmbeddedImages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEmbeddedImages0()
    {
        return $this->hasMany(PostEmbeddedImages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMedia()
    {
        return $this->hasMany(PostMedia::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMedia0()
    {
        return $this->hasMany(PostMedia::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTags::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags0()
    {
        return $this->hasMany(PostTags::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['author_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts0()
    {
        return $this->hasMany(Posts::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireFieldOptions()
    {
        return $this->hasMany(QuestionnaireFieldOptions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireFieldOptions0()
    {
        return $this->hasMany(QuestionnaireFieldOptions::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireFields()
    {
        return $this->hasMany(QuestionnaireFields::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireFields0()
    {
        return $this->hasMany(QuestionnaireFields::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireTemplateFieldOptions()
    {
        return $this->hasMany(QuestionnaireTemplateFieldOptions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireTemplateFieldOptions0()
    {
        return $this->hasMany(QuestionnaireTemplateFieldOptions::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireTemplateFields()
    {
        return $this->hasMany(QuestionnaireTemplateFields::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireTemplateFields0()
    {
        return $this->hasMany(QuestionnaireTemplateFields::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireTemplates()
    {
        return $this->hasMany(QuestionnaireTemplates::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireTemplates0()
    {
        return $this->hasMany(QuestionnaireTemplates::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizzes()
    {
        return $this->hasMany(Quizzes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizzes0()
    {
        return $this->hasMany(Quizzes::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestions()
    {
        return $this->hasMany(QuizQuestions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestions0()
    {
        return $this->hasMany(QuizQuestions::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrals()
    {
        return $this->hasMany(Referral::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrals0()
    {
        return $this->hasMany(Referral::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEncs0()
    {
        return $this->hasMany(Organizations::className(), ['organization_enc_id' => 'organization_enc_id'])->viaTable('{{%referral}}', ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferralSignUpTrackings()
    {
        return $this->hasMany(ReferralSignUpTracking::className(), ['sign_up_user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewedApplications()
    {
        return $this->hasMany(ReviewedApplications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewedApplications0()
    {
        return $this->hasMany(ReviewedApplications::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewsTypes()
    {
        return $this->hasMany(ReviewsType::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePrivileges()
    {
        return $this->hasMany(RolePrivileges::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Roles::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledInterviews()
    {
        return $this->hasMany(ScheduledInterview::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledInterviews0()
    {
        return $this->hasMany(ScheduledInterview::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolStudentsReviews()
    {
        return $this->hasMany(SchoolStudentsReview::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolStudentsReviews0()
    {
        return $this->hasMany(SchoolStudentsReview::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSelectedServices()
    {
        return $this->hasMany(SelectedServices::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSelectedServices0()
    {
        return $this->hasMany(SelectedServices::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeos()
    {
        return $this->hasMany(Seo::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeos0()
    {
        return $this->hasMany(Seo::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharingLinks()
    {
        return $this->hasMany(SharingLinks::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharingLinks0()
    {
        return $this->hasMany(SharingLinks::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedApplications()
    {
        return $this->hasMany(ShortlistedApplications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedApplications0()
    {
        return $this->hasMany(ShortlistedApplications::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedOrganizations()
    {
        return $this->hasMany(ShortlistedOrganizations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedOrganizations0()
    {
        return $this->hasMany(ShortlistedOrganizations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitemaps()
    {
        return $this->hasMany(Sitemap::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitemaps0()
    {
        return $this->hasMany(Sitemap::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitemapComments()
    {
        return $this->hasMany(SitemapComments::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitemapComments0()
    {
        return $this->hasMany(SitemapComments::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkills()
    {
        return $this->hasMany(Skills::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkills0()
    {
        return $this->hasMany(Skills::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialOwnedGroups()
    {
        return $this->hasMany(SocialOwnedGroups::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialOwnedGroups0()
    {
        return $this->hasMany(SocialOwnedGroups::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialPages()
    {
        return $this->hasMany(SocialPages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialPages0()
    {
        return $this->hasMany(SocialPages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialProfiles()
    {
        return $this->hasMany(SocialProfiles::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialProfiles0()
    {
        return $this->hasMany(SocialProfiles::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialPublicGroups()
    {
        return $this->hasMany(SocialPublicGroups::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialPublicGroups0()
    {
        return $this->hasMany(SocialPublicGroups::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpokenLanguages()
    {
        return $this->hasMany(SpokenLanguages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpokenLanguages0()
    {
        return $this->hasMany(SpokenLanguages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmittedVideos()
    {
        return $this->hasMany(SubmittedVideos::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmittedVideos0()
    {
        return $this->hasMany(SubmittedVideos::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags0()
    {
        return $this->hasMany(Tags::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopOrganizationsBlogs()
    {
        return $this->hasMany(TopOrganizationsBlogs::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopOrganizationsBlogsLists()
    {
        return $this->hasMany(TopOrganizationsBlogsList::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingApplications()
    {
        return $this->hasMany(TrainingApplications::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramBatches()
    {
        return $this->hasMany(TrainingProgramBatches::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramBatches0()
    {
        return $this->hasMany(TrainingProgramBatches::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramBatches1()
    {
        return $this->hasMany(TrainingProgramBatches::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingPrograms()
    {
        return $this->hasMany(TrainingPrograms::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingPrograms0()
    {
        return $this->hasMany(TrainingPrograms::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedFollowedOrganizations()
    {
        return $this->hasMany(UnclaimedFollowedOrganizations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedFollowedOrganizations0()
    {
        return $this->hasMany(UnclaimedFollowedOrganizations::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedFollowedOrganizations1()
    {
        return $this->hasMany(UnclaimedFollowedOrganizations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEncs1()
    {
        return $this->hasMany(UnclaimedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id'])->viaTable('{{%unclaimed_followed_organizations}}', ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedOrganizations()
    {
        return $this->hasMany(UnclaimedOrganizations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccessTokens()
    {
        return $this->hasMany(UserAccessTokens::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements()
    {
        return $this->hasMany(UserAchievements::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements0()
    {
        return $this->hasMany(UserAchievements::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements1()
    {
        return $this->hasMany(UserAchievements::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCoachingTutorials()
    {
        return $this->hasMany(UserCoachingTutorials::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCoachingTutorials0()
    {
        return $this->hasMany(UserCoachingTutorials::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEducations()
    {
        return $this->hasMany(UserEducation::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEducations0()
    {
        return $this->hasMany(UserEducation::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEducations1()
    {
        return $this->hasMany(UserEducation::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHobbies()
    {
        return $this->hasMany(UserHobbies::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHobbies0()
    {
        return $this->hasMany(UserHobbies::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHobbies1()
    {
        return $this->hasMany(UserHobbies::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInterests()
    {
        return $this->hasMany(UserInterests::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInterests0()
    {
        return $this->hasMany(UserInterests::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInterests1()
    {
        return $this->hasMany(UserInterests::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferences()
    {
        return $this->hasMany(UserPreferences::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferences0()
    {
        return $this->hasMany(UserPreferences::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredIndustries()
    {
        return $this->hasMany(UserPreferredIndustries::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredIndustries0()
    {
        return $this->hasMany(UserPreferredIndustries::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredJobProfiles()
    {
        return $this->hasMany(UserPreferredJobProfile::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredJobProfiles0()
    {
        return $this->hasMany(UserPreferredJobProfile::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredLocations()
    {
        return $this->hasMany(UserPreferredLocations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredLocations0()
    {
        return $this->hasMany(UserPreferredLocations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredSkills()
    {
        return $this->hasMany(UserPreferredSkills::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredSkills0()
    {
        return $this->hasMany(UserPreferredSkills::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPrivileges()
    {
        return $this->hasMany(UserPrivileges::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPrivileges0()
    {
        return $this->hasMany(UserPrivileges::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPrivileges1()
    {
        return $this->hasMany(UserPrivileges::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleEncs()
    {
        return $this->hasMany(Roles::className(), ['role_enc_id' => 'role_enc_id'])->viaTable('{{%user_privileges}}', ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResumes()
    {
        return $this->hasMany(UserResume::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResumes0()
    {
        return $this->hasMany(UserResume::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResumes1()
    {
        return $this->hasMany(UserResume::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSkills()
    {
        return $this->hasMany(UserSkills::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSkills0()
    {
        return $this->hasMany(UserSkills::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSpokenLanguages()
    {
        return $this->hasMany(UserSpokenLanguages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSpokenLanguages0()
    {
        return $this->hasMany(UserSpokenLanguages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks()
    {
        return $this->hasMany(UserTasks::className(), ['assigned_to' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks0()
    {
        return $this->hasMany(UserTasks::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks1()
    {
        return $this->hasMany(UserTasks::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserVerificationTokens()
    {
        return $this->hasMany(UserVerificationTokens::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserVerificationTokens0()
    {
        return $this->hasMany(UserVerificationTokens::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserWorkExperiences()
    {
        return $this->hasMany(UserWorkExperience::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserWorkExperiences0()
    {
        return $this->hasMany(UserWorkExperience::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserWorkExperiences1()
    {
        return $this->hasMany(UserWorkExperience::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTypeEnc()
    {
        return $this->hasOne(UserTypes::className(), ['user_type_enc_id' => 'user_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobFunction()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'job_function']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignedJobFunction()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'asigned_job_function']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWhatsappInvitationMessages()
    {
        return $this->hasMany(WhatsappInvitationMessages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWhatsappInvitationMessages0()
    {
        return $this->hasMany(WhatsappInvitationMessages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWhatsappInvitations()
    {
        return $this->hasMany(WhatsappInvitations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWhatsappInvitations0()
    {
        return $this->hasMany(WhatsappInvitations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYoutubeChannels()
    {
        return $this->hasMany(YoutubeChannels::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYoutubeChannels0()
    {
        return $this->hasMany(YoutubeChannels::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYoutubeChannels1()
    {
        return $this->hasMany(YoutubeChannels::className(), ['author_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOtherInfo()
    {
        return $this->hasOne(UserOtherDetails::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeachers()
    {
        return $this->hasMany(Teachers::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryTags()
    {
        return $this->hasMany(CategoryTags::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryTags0()
    {
        return $this->hasMany(CategoryTags::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassAccesses()
    {
        return $this->hasMany(ClassAccess::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassAccesses0()
    {
        return $this->hasMany(ClassAccess::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassNotes()
    {
        return $this->hasMany(ClassNotes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCourses()
    {
        return $this->hasMany(CollegeCourses::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCourses0()
    {
        return $this->hasMany(CollegeCourses::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeSections()
    {
        return $this->hasMany(CollegeSections::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeSettings()
    {
        return $this->hasMany(CollegeSettings::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeSettings0()
    {
        return $this->hasMany(CollegeSettings::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Courses::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencies()
    {
        return $this->hasMany(Currencies::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevelopmentTrackings()
    {
        return $this->hasMany(DevelopmentTracking::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevelopmentTrackings0()
    {
        return $this->hasMany(DevelopmentTracking::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainNames0()
    {
        return $this->hasMany(DomainNames::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainRoutes()
    {
        return $this->hasMany(DomainRoutes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainRoutes0()
    {
        return $this->hasMany(DomainRoutes::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailLogs()
    {
        return $this->hasMany(EmailLogs::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailTemplates()
    {
        return $this->hasMany(EmailTemplates::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailTemplates0()
    {
        return $this->hasMany(EmailTemplates::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxActivityTracks()
    {
        return $this->hasMany(ErexxActivityTracks::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxActivityTracks0()
    {
        return $this->hasMany(ErexxActivityTracks::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxEmployerApplications()
    {
        return $this->hasMany(ErexxEmployerApplications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxEmployerApplications0()
    {
        return $this->hasMany(ErexxEmployerApplications::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxWhatsappInvitations()
    {
        return $this->hasMany(ErexxWhatsappInvitation::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalNewsUpdates()
    {
        return $this->hasMany(ExternalNewsUpdate::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalNewsUpdates0()
    {
        return $this->hasMany(ExternalNewsUpdate::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles0()
    {
        return $this->hasMany(Files::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGitApplications()
    {
        return $this->hasMany(GitApplications::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGitApplications0()
    {
        return $this->hasMany(GitApplications::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGitOrganizations()
    {
        return $this->hasMany(GitOrganizations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGitOrganizations0()
    {
        return $this->hasMany(GitOrganizations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndianGovtJobs()
    {
        return $this->hasMany(IndianGovtJobs::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabels()
    {
        return $this->hasMany(Labels::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabels0()
    {
        return $this->hasMany(Labels::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMisAssignedMenuItems()
    {
        return $this->hasMany(MisAssignedMenuItems::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMisAssignedMenuItems0()
    {
        return $this->hasMany(MisAssignedMenuItems::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMisAssignedMenuses()
    {
        return $this->hasMany(MisAssignedMenus::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMisAssignedMenuses0()
    {
        return $this->hasMany(MisAssignedMenus::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMisUserTasks()
    {
        return $this->hasMany(MisUserTasks::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMisUserTasks0()
    {
        return $this->hasMany(MisUserTasks::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMisUserTasks1()
    {
        return $this->hasMany(MisUserTasks::className(), ['task_for' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockBoards()
    {
        return $this->hasMany(MockBoards::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockCoursePools()
    {
        return $this->hasMany(MockCoursePool::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockCourses()
    {
        return $this->hasMany(MockCourses::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockLabelPools()
    {
        return $this->hasMany(MockLabelPool::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockLabels()
    {
        return $this->hasMany(MockLabels::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockLevels()
    {
        return $this->hasMany(MockLevels::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockQuizPools()
    {
        return $this->hasMany(MockQuizPool::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockQuizQuestionsPools()
    {
        return $this->hasMany(MockQuizQuestionsPool::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockQuizQuestionsPools0()
    {
        return $this->hasMany(MockQuizQuestionsPool::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockQuizzes()
    {
        return $this->hasMany(MockQuizzes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockQuizzes0()
    {
        return $this->hasMany(MockQuizzes::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockSubjects()
    {
        return $this->hasMany(MockSubjects::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockSubjectsPools()
    {
        return $this->hasMany(MockSubjectsPool::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockTakenQuizzes()
    {
        return $this->hasMany(MockTakenQuizzes::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTags()
    {
        return $this->hasMany(NewsTags::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTags0()
    {
        return $this->hasMany(NewsTags::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineClassComments()
    {
        return $this->hasMany(OnlineClassComments::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineClassComments0()
    {
        return $this->hasMany(OnlineClassComments::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLabels()
    {
        return $this->hasMany(OrganizationLabels::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLabels0()
    {
        return $this->hasMany(OrganizationLabels::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationsDatabases()
    {
        return $this->hasMany(OrganizationsDatabase::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollCounterrs()
    {
        return $this->hasMany(PollCounterr::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoolWebinarOutcomes()
    {
        return $this->hasMany(PoolWebinarOutcomes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionPoolTags()
    {
        return $this->hasMany(QuestionPoolTags::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionPoolTags0()
    {
        return $this->hasMany(QuestionPoolTags::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsPools()
    {
        return $this->hasMany(QuestionsPool::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsPools0()
    {
        return $this->hasMany(QuestionsPool::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsPoolAnswers()
    {
        return $this->hasMany(QuestionsPoolAnswer::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsPoolAnswers0()
    {
        return $this->hasMany(QuestionsPoolAnswer::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAssignedGroups()
    {
        return $this->hasMany(QuizAssignedGroup::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAssignedGroups0()
    {
        return $this->hasMany(QuizAssignedGroup::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizPools()
    {
        return $this->hasMany(QuizPool::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizPools0()
    {
        return $this->hasMany(QuizPool::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestionsPools()
    {
        return $this->hasMany(QuizQuestionsPool::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestionsPools0()
    {
        return $this->hasMany(QuizQuestionsPool::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatingQuestions()
    {
        return $this->hasMany(RatingQuestions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatingQuestions0()
    {
        return $this->hasMany(RatingQuestions::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatingSystems()
    {
        return $this->hasMany(RatingSystem::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatingSystems0()
    {
        return $this->hasMany(RatingSystem::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatingSystemAnswers()
    {
        return $this->hasMany(RatingSystemAnswers::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatingSystemAnswers0()
    {
        return $this->hasMany(RatingSystemAnswers::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRawDatabases()
    {
        return $this->hasMany(RawDatabase::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumeTemplates()
    {
        return $this->hasMany(ResumeTemplates::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryReviews()
    {
        return $this->hasMany(SalaryReviews::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryReviews0()
    {
        return $this->hasMany(SalaryReviews::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialGroups()
    {
        return $this->hasMany(SocialGroups::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialGroups0()
    {
        return $this->hasMany(SocialGroups::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialLinks()
    {
        return $this->hasMany(SocialLinks::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialLinks0()
    {
        return $this->hasMany(SocialLinks::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialPlatforms()
    {
        return $this->hasMany(SocialPlatforms::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialPlatforms0()
    {
        return $this->hasMany(SocialPlatforms::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeakerExpertises()
    {
        return $this->hasMany(SpeakerExpertises::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeakers()
    {
        return $this->hasMany(Speakers::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeakers0()
    {
        return $this->hasMany(Speakers::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticWidgets()
    {
        return $this->hasMany(StaticWidgets::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticWidgets0()
    {
        return $this->hasMany(StaticWidgets::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmittedVideos1()
    {
        return $this->hasMany(SubmittedVideos::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionAnsweredQuestionnaires()
    {
        return $this->hasMany(SuggestionAnsweredQuestionnaire::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionAnsweredQuestionnaires0()
    {
        return $this->hasMany(SuggestionAnsweredQuestionnaire::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionGroups()
    {
        return $this->hasMany(SuggestionGroup::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionGroups0()
    {
        return $this->hasMany(SuggestionGroup::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionQuestionnaires()
    {
        return $this->hasMany(SuggestionQuestionnaire::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionQuestionnaires0()
    {
        return $this->hasMany(SuggestionQuestionnaire::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionQuestionnaireFields()
    {
        return $this->hasMany(SuggestionQuestionnaireFields::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionQuestionnaireFields0()
    {
        return $this->hasMany(SuggestionQuestionnaireFields::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topics::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramApplications()
    {
        return $this->hasMany(TrainingProgramApplication::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramApplications0()
    {
        return $this->hasMany(TrainingProgramApplication::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramBatchesBks()
    {
        return $this->hasMany(TrainingProgramBatchesBk::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramBatchesBks0()
    {
        return $this->hasMany(TrainingProgramBatchesBk::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramSkills()
    {
        return $this->hasMany(TrainingProgramSkills::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramSkills0()
    {
        return $this->hasMany(TrainingProgramSkills::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterJobSkills()
    {
        return $this->hasMany(TwitterJobSkills::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterJobSkills0()
    {
        return $this->hasMany(TwitterJobSkills::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterJobs()
    {
        return $this->hasMany(TwitterJobs::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterJobs0()
    {
        return $this->hasMany(TwitterJobs::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterPlacementCities()
    {
        return $this->hasMany(TwitterPlacementCities::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterPlacementCities0()
    {
        return $this->hasMany(TwitterPlacementCities::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimAssignedIndustries()
    {
        return $this->hasMany(UnclaimAssignedIndustries::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimAssignedIndustries0()
    {
        return $this->hasMany(UnclaimAssignedIndustries::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationImages()
    {
        return $this->hasMany(UnclaimOrganizationImages::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationImages0()
    {
        return $this->hasMany(UnclaimOrganizationImages::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationLabels()
    {
        return $this->hasMany(UnclaimOrganizationLabels::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationLabels0()
    {
        return $this->hasMany(UnclaimOrganizationLabels::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationLocations()
    {
        return $this->hasMany(UnclaimOrganizationLocations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationLocations0()
    {
        return $this->hasMany(UnclaimOrganizationLocations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOtherDetails()
    {
        return $this->hasMany(UserOtherDetails::className(), ['user_enc_id' => 'user_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRoles::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles0()
    {
        return $this->hasMany(UserRoles::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles1()
    {
        return $this->hasMany(UserRoles::className(), ['reporting_person' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles2()
    {
        return $this->hasMany(UserRoles::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoSessions()
    {
        return $this->hasMany(VideoSessions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarOutcomes()
    {
        return $this->hasMany(WebinarOutcomes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarOutcomes0()
    {
        return $this->hasMany(WebinarOutcomes::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRegistrations()
    {
        return $this->hasMany(WebinarRegistrations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRegistrations0()
    {
        return $this->hasMany(WebinarRegistrations::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarSpeakers()
    {
        return $this->hasMany(WebinarSpeakers::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarSpeakers0()
    {
        return $this->hasMany(WebinarSpeakers::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinars()
    {
        return $this->hasMany(Webinars::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinars0()
    {
        return $this->hasMany(Webinars::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedApplicants()
    {
        return $this->hasMany(ShortlistedApplicants::className(), ['candidate_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedApplicants0()
    {
        return $this->hasMany(ShortlistedApplicants::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedApplicants1()
    {
        return $this->hasMany(ShortlistedApplicants::className(), ['last_updated_by' => 'user_enc_id']);
    }

    public function getSkillsUpPosts0()
    {
        return $this->hasMany(SkillsUpPosts::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanPartners()
    {
        return $this->hasMany(AssignedFinancerLoanPartners::className(), ['loan_partner_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanPartners0()
    {
        return $this->hasMany(AssignedFinancerLoanPartners::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanPartners1()
    {
        return $this->hasMany(AssignedFinancerLoanPartners::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanTypess()
    {
        return $this->hasMany(AssignedFinancerLoanTypes::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanTypess0()
    {
        return $this->hasMany(AssignedFinancerLoanTypes::className(), ['updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedFinancerLoanTypess1()
    {
        return $this->hasMany(AssignedFinancerLoanTypes::className(), ['financer_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedLoanApplications()
    {
        return $this->hasMany(SharedLoanApplications::className(), ['shared_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplications3()
    {
        return $this->hasMany(LoanApplications::className(), ['lead_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreditLoanApplicationReports()
    {
        return $this->hasMany(CreditLoanApplicationReports::className(), ['created_by' => 'user_enc_id']);
    }
}

