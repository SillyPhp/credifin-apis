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
 * @property string $last_name Last Name
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
 * @property string $status User Status (Active, Inactive, Pending)
 * @property int $is_deleted Is User Deleted (0 as False, 1 as True)
 *
 * @property IndianGovtDepartments[] $indianGovtDepartments
 * @property UsaDepartments[] $usaDepartments
 * @property UsaProfileCodes[] $usaProfileCodes
 * @property UsaProfileCodes[] $usaProfileCodes0
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
 * @property AppliedTrainingApplications[] $appliedTrainingApplications
 * @property AppliedTrainingApplications[] $appliedTrainingApplications0
 * @property AppliedTrainingBatches[] $appliedTrainingBatches
 * @property AppliedTrainingBatches[] $appliedTrainingBatches0
 * @property AssignedCategories[] $assignedCategories
 * @property AssignedCategories[] $assignedCategories0
 * @property AssignedEducationalRequirements[] $assignedEducationalRequirements
 * @property AssignedEducationalRequirements[] $assignedEducationalRequirements0
 * @property AssignedIndianJobs[] $assignedIndianJobs
 * @property AssignedIndianJobs[] $assignedIndianJobs0
 * @property AssignedIndustries[] $assignedIndustries
 * @property AssignedIndustries[] $assignedIndustries0
 * @property AssignedJobDescription[] $assignedJobDescriptions
 * @property AssignedJobDescription[] $assignedJobDescriptions0
 * @property AssignedSkills[] $assignedSkills
 * @property AssignedSkills[] $assignedSkills0
 * @property AssignedStaticWidgets[] $assignedStaticWidgets
 * @property AssignedTags[] $assignedTags
 * @property AssignedTags[] $assignedTags0
 * @property AssignedWebinarTo[] $assignedWebinarTos
 * @property Auth[] $auths
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
 * @property CollegeCourses[] $collegeCourses
 * @property CollegeCourses[] $collegeCourses0
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
 * @property EducationalRequirements[] $educationalRequirements
 * @property EducationalRequirements[] $educationalRequirements0
 * @property EmailLogs[] $emailLogs
 * @property EmailTemplates[] $emailTemplates
 * @property EmailTemplates[] $emailTemplates0
 * @property EmployerReviews[] $employerReviews
 * @property EmployerReviews[] $employerReviews0
 * @property ErexxActivityTracks[] $erexxActivityTracks
 * @property ErexxActivityTracks[] $erexxActivityTracks0
 * @property ErexxEmployerApplications[] $erexxEmployerApplications
 * @property ErexxEmployerApplications[] $erexxEmployerApplications0
 * @property ErexxWhatsappInvitation[] $erexxWhatsappInvitations
 * @property ExternalNewsUpdate[] $externalNewsUpdates
 * @property ExternalNewsUpdate[] $externalNewsUpdates0
 * @property Files[] $files
 * @property Files[] $files0
 * @property GitApplications[] $gitApplications
 * @property GitApplications[] $gitApplications0
 * @property GitOrganizations[] $gitOrganizations
 * @property GitOrganizations[] $gitOrganizations0
 * @property HiringProcessTemplateFields[] $hiringProcessTemplateFields
 * @property HiringProcessTemplateFields[] $hiringProcessTemplateFields0
 * @property HiringProcessTemplates[] $hiringProcessTemplates
 * @property HiringProcessTemplates[] $hiringProcessTemplates0
 * @property IndianGovtJobs[] $indianGovtJobs
 * @property InstituteStudentsReview[] $instituteStudentsReviews
 * @property InstituteStudentsReview[] $instituteStudentsReviews0
 * @property JobDescription[] $jobDescriptions
 * @property JobDescription[] $jobDescriptions0
 * @property Labels[] $labels
 * @property Labels[] $labels0
 * @property MisAssignedMenuItems[] $misAssignedMenuItems
 * @property MisAssignedMenuItems[] $misAssignedMenuItems0
 * @property MisAssignedMenus[] $misAssignedMenuses
 * @property MisAssignedMenus[] $misAssignedMenuses0
 * @property MisEmailLogs[] $misEmailLogs
 * @property MisUserTasks[] $misUserTasks
 * @property MisUserTasks[] $misUserTasks0
 * @property MisUserTasks[] $misUserTasks1
 * @property NewsTags[] $newsTags
 * @property NewsTags[] $newsTags0
 * @property OnlineClassComments[] $onlineClassComments
 * @property OnlineClassComments[] $onlineClassComments0
 * @property OrganizationLabels[] $organizationLabels
 * @property OrganizationLabels[] $organizationLabels0
 * @property Organizations[] $organizations
 * @property Organizations[] $organizations0
 * @property OrganizationsDatabase[] $organizationsDatabases
 * @property PollCounterr[] $pollCounterrs
 * @property PoolWebinarOutcomes[] $poolWebinarOutcomes
 * @property PostCategories[] $postCategories
 * @property PostCategories[] $postCategories0
 * @property PostComments[] $postComments
 * @property QuestionPoolTags[] $questionPoolTags
 * @property QuestionPoolTags[] $questionPoolTags0
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
 * @property ResumeTemplates[] $resumeTemplates
 * @property Reviews[] $reviews
 * @property SalaryReviews[] $salaryReviews
 * @property SalaryReviews[] $salaryReviews0
 * @property SchoolStudentsReview[] $schoolStudentsReviews
 * @property SchoolStudentsReview[] $schoolStudentsReviews0
 * @property Seo[] $seos
 * @property Seo[] $seos0
 * @property Skills[] $skills
 * @property Skills[] $skills0
 * @property SocialGroups[] $socialGroups
 * @property SocialGroups[] $socialGroups0
 * @property SocialLinks[] $socialLinks
 * @property SocialLinks[] $socialLinks0
 * @property SocialPlatforms[] $socialPlatforms
 * @property SocialPlatforms[] $socialPlatforms0
 * @property SpeakerExpertises[] $speakerExpertises
 * @property Speakers[] $speakers
 * @property Speakers[] $speakers0
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
 * @property UserVerificationTokens[] $userVerificationTokens
 * @property Organizations $organizationEnc
 * @property UserTypes $userTypeEnc
 * @property VideoSessions[] $videoSessions
 * @property WebinarOutcomes[] $webinarOutcomes
 * @property WebinarOutcomes[] $webinarOutcomes0
 * @property WebinarRegistrations[] $webinarRegistrations
 * @property WebinarRegistrations[] $webinarRegistrations0
 * @property WebinarSpeakers[] $webinarSpeakers
 * @property WebinarSpeakers[] $webinarSpeakers0
 * @property Webinars[] $webinars
 * @property Webinars[] $webinars0
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
            [['user_enc_id', 'username', 'email', 'password', 'auth_key', 'first_name', 'last_name', 'user_type_enc_id', 'initials_color'], 'required'],
            [['description', 'objective', 'user_of', 'status'], 'string'],
            [['dob', 'created_on', 'last_updated_on'], 'safe'],
            [['gender', 'is_available', 'is_email_verified', 'is_phone_verified', 'is_deleted'], 'integer'],
            [['user_enc_id', 'auth_key', 'user_type_enc_id', 'address', 'image', 'image_location', 'cover_image', 'cover_image_location', 'city_enc_id', 'organization_enc_id', 'job_function', 'asigned_job_function'], 'string', 'max' => 100],
            [['username', 'email', 'facebook', 'google', 'twitter', 'instagram', 'linkedin', 'youtube', 'skype'], 'string', 'max' => 50],
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
        ];
    }

    /**
     * @inheritdoc
     */

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
        return $this->hasMany(AssignedEducationalRequirements::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedEducationalRequirements0()
    {
        return $this->hasMany(AssignedEducationalRequirements::className(), ['created_by' => 'user_enc_id']);
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
    public function getDomainNames()
    {
        return $this->hasMany(DomainNames::className(), ['created_by' => 'user_enc_id']);
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
    public function getIndianGovtJobs()
    {
        return $this->hasMany(IndianGovtJobs::className(), ['created_by' => 'user_enc_id']);
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
    public function getMisEmailLogs()
    {
        return $this->hasMany(MisEmailLogs::className(), ['created_by' => 'user_enc_id']);
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
    public function getOrganizations()
    {
        return $this->hasMany(Organizations::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations0()
    {
        return $this->hasMany(Organizations::className(), ['created_by' => 'user_enc_id']);
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
    public function getOrganizationEncs()
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
    public function getResumeTemplates()
    {
        return $this->hasMany(ResumeTemplates::className(), ['created_by' => 'user_enc_id']);
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
    public function getSubmittedVideos()
    {
        return $this->hasMany(SubmittedVideos::className(), ['contributor_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmittedVideos0()
    {
        return $this->hasMany(SubmittedVideos::className(), ['created_by' => 'user_enc_id']);
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
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags0()
    {
        return $this->hasMany(Tags::className(), ['last_updated_by' => 'user_enc_id']);
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
    public function getUnclaimedOrganizations()
    {
        return $this->hasMany(UnclaimedOrganizations::className(), ['created_by' => 'user_enc_id']);
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
    public function getUserVerificationTokens()
    {
        return $this->hasMany(UserVerificationTokens::className(), ['created_by' => 'user_enc_id']);
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
}
