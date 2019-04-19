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
 * @property AnsweredQuestionnaire[] $answeredQuestionnaires
 * @property AnsweredQuestionnaire[] $answeredQuestionnaires0
 * @property AnsweredQuestionnaireFields[] $answeredQuestionnaireFields
 * @property AnsweredQuestionnaireFields[] $answeredQuestionnaireFields0
 * @property ApplicationEducationalRequirements[] $applicationEducationalRequirements
 * @property ApplicationEducationalRequirements[] $applicationEducationalRequirements0
 * @property ApplicationEmployeeBenefits[] $applicationEmployeeBenefits
 * @property ApplicationEmployeeBenefits[] $applicationEmployeeBenefits0
 * @property ApplicationInterviewLocations[] $applicationInterviewLocations
 * @property ApplicationInterviewLocations[] $applicationInterviewLocations0
 * @property ApplicationInterviewQuestionnaire[] $applicationInterviewQuestionnaires
 * @property ApplicationInterviewQuestionnaire[] $applicationInterviewQuestionnaires0
 * @property ApplicationJobDescription[] $applicationJobDescriptions
 * @property ApplicationJobDescription[] $applicationJobDescriptions0
 * @property ApplicationOptions[] $applicationOptions
 * @property ApplicationOptions[] $applicationOptions0
 * @property ApplicationPlacementLocations[] $applicationPlacementLocations
 * @property ApplicationPlacementLocations[] $applicationPlacementLocations0
 * @property ApplicationSkills[] $applicationSkills
 * @property ApplicationSkills[] $applicationSkills0
 * @property ApplicationTemplateJobDescription[] $applicationTemplateJobDescriptions
 * @property ApplicationTemplateJobDescription[] $applicationTemplateJobDescriptions0
 * @property ApplicationTemplateOptions[] $applicationTemplateOptions
 * @property ApplicationTemplateOptions[] $applicationTemplateOptions0
 * @property ApplicationTemplates[] $applicationTemplates
 * @property ApplicationTemplates[] $applicationTemplates0
 * @property Applications[] $applications
 * @property Applications[] $applications0
 * @property Applications[] $applications1
 * @property AppliedApplicationLocations[] $appliedApplicationLocations
 * @property AppliedApplicationLocations[] $appliedApplicationLocations0
 * @property AppliedApplicationProcess[] $appliedApplicationProcesses
 * @property AppliedApplicationProcess[] $appliedApplicationProcesses0
 * @property AppliedApplications[] $appliedApplications
 * @property AppliedApplications[] $appliedApplications0
 * @property AssignedCategories[] $assignedCategories
 * @property AssignedCategories[] $assignedCategories0
 * @property AssignedEducationalRequirements[] $assignedEducationalRequirements
 * @property AssignedEducationalRequirements[] $assignedEducationalRequirements0
 * @property AssignedIndustries[] $assignedIndustries
 * @property AssignedIndustries[] $assignedIndustries0
 * @property AssignedJobDescription[] $assignedJobDescriptions
 * @property AssignedJobDescription[] $assignedJobDescriptions0
 * @property AssignedSkills[] $assignedSkills
 * @property AssignedSkills[] $assignedSkills0
 * @property AssignedTags[] $assignedTags
 * @property AssignedTags[] $assignedTags0
 * @property BookmarkedHiringTemplates[] $bookmarkedHiringTemplates
 * @property BookmarkedHiringTemplates[] $bookmarkedHiringTemplates0
 * @property BookmarkedQuestionnaireTemplates[] $bookmarkedQuestionnaireTemplates
 * @property BookmarkedQuestionnaireTemplates[] $bookmarkedQuestionnaireTemplates0
 * @property Categories[] $categories
 * @property Categories[] $categories0
 * @property CategoriesList[] $categoriesLists
 * @property CategoriesList[] $categoriesLists0
 * @property ConversationMessages[] $conversationMessages
 * @property ConversationMessages[] $conversationMessages0
 * @property ConversationParticipants[] $conversationParticipants
 * @property ConversationParticipants[] $conversationParticipants0
 * @property ConversationParticipants[] $conversationParticipants1
 * @property Conversations[] $conversations
 * @property Conversations[] $conversations0
 * @property CustomForm[] $customForms
 * @property CustomForm[] $customForms0
 * @property Designations[] $designations
 * @property Designations[] $designations0
 * @property DropResumeApplicationLocations[] $dropResumeApplicationLocations
 * @property DropResumeApplicationLocations[] $dropResumeApplicationLocations0
 * @property DropResumeApplicationLocations[] $dropResumeApplicationLocations1
 * @property DropResumeApplicationTitles[] $dropResumeApplicationTitles
 * @property DropResumeApplicationTitles[] $dropResumeApplicationTitles0
 * @property DropResumeApplicationTitles[] $dropResumeApplicationTitles1
 * @property DropResumeApplications[] $dropResumeApplications
 * @property DropResumeApplications[] $dropResumeApplications0
 * @property DropResumeApplications[] $dropResumeApplications1
 * @property EducationalRequirements[] $educationalRequirements
 * @property EducationalRequirements[] $educationalRequirements0
 * @property EmployeeBenefits[] $employeeBenefits
 * @property EmployeeBenefits[] $employeeBenefits0
 * @property EmployerApplications[] $employerApplications
 * @property EmployerApplications[] $employerApplications0
 * @property Feedback[] $feedbacks
 * @property Feedback[] $feedbacks0
 * @property FollowedOrganizations[] $followedOrganizations
 * @property FollowedOrganizations[] $followedOrganizations0
 * @property FollowedOrganizations[] $followedOrganizations1
 * @property Organizations[] $organizationEncs
 * @property HiringProcessTemplateFields[] $hiringProcessTemplateFields
 * @property HiringProcessTemplateFields[] $hiringProcessTemplateFields0
 * @property HiringProcessTemplates[] $hiringProcessTemplates
 * @property HiringProcessTemplates[] $hiringProcessTemplates0
 * @property InterviewProcessFields[] $interviewProcessFields
 * @property InterviewProcessFields[] $interviewProcessFields0
 * @property InterviewScheduler[] $interviewSchedulers
 * @property InterviewScheduler[] $interviewSchedulers0
 * @property JobDescription[] $jobDescriptions
 * @property JobDescription[] $jobDescriptions0
 * @property LearningCornerResourceDiscussion[] $learningCornerResourceDiscussions
 * @property LearningCornerResourceDiscussion[] $learningCornerResourceDiscussions0
 * @property LearningVideoTags[] $learningVideoTags
 * @property LearningVideoTags[] $learningVideoTags0
 * @property LearningVideos[] $learningVideos
 * @property LearningVideos[] $learningVideos0
 * @property OrganizationAssignedCategories[] $organizationAssignedCategories
 * @property OrganizationAssignedCategories[] $organizationAssignedCategories0
 * @property OrganizationEmployeeBenefits[] $organizationEmployeeBenefits
 * @property OrganizationEmployeeBenefits[] $organizationEmployeeBenefits0
 * @property OrganizationEmployees[] $organizationEmployees
 * @property OrganizationEmployees[] $organizationEmployees0
 * @property OrganizationImages[] $organizationImages
 * @property OrganizationImages[] $organizationImages0
 * @property OrganizationInterviewProcess[] $organizationInterviewProcesses
 * @property OrganizationInterviewProcess[] $organizationInterviewProcesses0
 * @property OrganizationLocations[] $organizationLocations
 * @property OrganizationLocations[] $organizationLocations0
 * @property OrganizationProductImages[] $organizationProductImages
 * @property OrganizationProductImages[] $organizationProductImages0
 * @property OrganizationProducts[] $organizationProducts
 * @property OrganizationProducts[] $organizationProducts0
 * @property OrganizationQuestionnaire[] $organizationQuestionnaires
 * @property OrganizationQuestionnaire[] $organizationQuestionnaires0
 * @property OrganizationReviewFeedback[] $organizationReviewFeedbacks
 * @property OrganizationReviewFeedback[] $organizationReviewFeedbacks0
 * @property OrganizationReviewFeedback[] $organizationReviewFeedbacks1
 * @property OrganizationReviews[] $reviewEncs
 * @property OrganizationReviews[] $organizationReviews
 * @property OrganizationReviews[] $organizationReviews0
 * @property OrganizationVideos[] $organizationVideos
 * @property OrganizationVideos[] $organizationVideos0
 * @property Organizations[] $organizations
 * @property Organizations[] $organizations0
 * @property PostCategories[] $postCategories
 * @property PostCategories[] $postCategories0
 * @property PostEmbeddedImages[] $postEmbeddedImages
 * @property PostEmbeddedImages[] $postEmbeddedImages0
 * @property PostMedia[] $postMedia
 * @property PostMedia[] $postMedia0
 * @property PostTags[] $postTags
 * @property PostTags[] $postTags0
 * @property Posts[] $posts
 * @property Posts[] $posts0
 * @property QuestionnaireFieldOptions[] $questionnaireFieldOptions
 * @property QuestionnaireFieldOptions[] $questionnaireFieldOptions0
 * @property QuestionnaireFields[] $questionnaireFields
 * @property QuestionnaireFields[] $questionnaireFields0
 * @property QuestionnaireTemplateFieldOptions[] $questionnaireTemplateFieldOptions
 * @property QuestionnaireTemplateFieldOptions[] $questionnaireTemplateFieldOptions0
 * @property QuestionnaireTemplateFields[] $questionnaireTemplateFields
 * @property QuestionnaireTemplateFields[] $questionnaireTemplateFields0
 * @property QuestionnaireTemplates[] $questionnaireTemplates
 * @property QuestionnaireTemplates[] $questionnaireTemplates0
 * @property ReviewedApplications[] $reviewedApplications
 * @property ReviewedApplications[] $reviewedApplications0
 * @property SelectedServices[] $selectedServices
 * @property SelectedServices[] $selectedServices0
 * @property Seo[] $seos
 * @property Seo[] $seos0
 * @property SharingLinks[] $sharingLinks
 * @property SharingLinks[] $sharingLinks0
 * @property ShortlistedApplications[] $shortlistedApplications
 * @property ShortlistedApplications[] $shortlistedApplications0
 * @property ShortlistedOrganizations[] $shortlistedOrganizations
 * @property ShortlistedOrganizations[] $shortlistedOrganizations0
 * @property Sitemap[] $sitemaps
 * @property Sitemap[] $sitemaps0
 * @property SitemapComments[] $sitemapComments
 * @property SitemapComments[] $sitemapComments0
 * @property Skills[] $skills
 * @property Skills[] $skills0
 * @property SocialOwnedGroups[] $socialOwnedGroups
 * @property SocialOwnedGroups[] $socialOwnedGroups0
 * @property SocialPages[] $socialPages
 * @property SocialPages[] $socialPages0
 * @property SocialProfiles[] $socialProfiles
 * @property SocialProfiles[] $socialProfiles0
 * @property SocialPublicGroups[] $socialPublicGroups
 * @property SocialPublicGroups[] $socialPublicGroups0
 * @property SpokenLanguages[] $spokenLanguages
 * @property SpokenLanguages[] $spokenLanguages0
 * @property SubmittedVideos[] $submittedVideos
 * @property SubmittedVideos[] $submittedVideos0
 * @property Tags[] $tags
 * @property Tags[] $tags0
 * @property TrainingApplications[] $trainingApplications
 * @property TrainingProgramBatches[] $trainingProgramBatches
 * @property TrainingProgramBatches[] $trainingProgramBatches0
 * @property TrainingProgramBatches[] $trainingProgramBatches1
 * @property TrainingPrograms[] $trainingPrograms
 * @property TrainingPrograms[] $trainingPrograms0
 * @property UserAccessTokens[] $userAccessTokens
 * @property UserAchievements[] $userAchievements
 * @property UserAchievements[] $userAchievements0
 * @property UserAchievements[] $userAchievements1
 * @property UserCoachingTutorials[] $userCoachingTutorials
 * @property UserCoachingTutorials[] $userCoachingTutorials0
 * @property UserEducation[] $userEducations
 * @property UserEducation[] $userEducations0
 * @property UserEducation[] $userEducations1
 * @property UserHobbies[] $userHobbies
 * @property UserHobbies[] $userHobbies0
 * @property UserHobbies[] $userHobbies1
 * @property UserInterests[] $userInterests
 * @property UserInterests[] $userInterests0
 * @property UserInterests[] $userInterests1
 * @property UserPreferences[] $userPreferences
 * @property UserPreferences[] $userPreferences0
 * @property UserPreferredIndustries[] $userPreferredIndustries
 * @property UserPreferredIndustries[] $userPreferredIndustries0
 * @property UserPreferredJobProfile[] $userPreferredJobProfiles
 * @property UserPreferredJobProfile[] $userPreferredJobProfiles0
 * @property UserPreferredLocations[] $userPreferredLocations
 * @property UserPreferredLocations[] $userPreferredLocations0
 * @property UserPreferredSkills[] $userPreferredSkills
 * @property UserPreferredSkills[] $userPreferredSkills0
 * @property UserResume[] $userResumes
 * @property UserResume[] $userResumes0
 * @property UserResume[] $userResumes1
 * @property UserSkills[] $userSkills
 * @property UserSkills[] $userSkills0
 * @property UserSpokenLanguages[] $userSpokenLanguages
 * @property UserSpokenLanguages[] $userSpokenLanguages0
 * @property UserTasks[] $userTasks
 * @property UserTasks[] $userTasks0
 * @property UserTasks[] $userTasks1
 * @property UserVerificationTokens[] $userVerificationTokens
 * @property UserVerificationTokens[] $userVerificationTokens0
 * @property UserWorkExperience[] $userWorkExperiences
 * @property UserWorkExperience[] $userWorkExperiences0
 * @property UserWorkExperience[] $userWorkExperiences1
 * @property Cities $cityEnc
 * @property Organizations $organizationEnc
 * @property UserTypes $userTypeEnc
 * @property Categories $jobFunction
 * @property AssignedCategories $asignedJobFunction
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
            [['user_enc_id', 'username', 'email', 'password', 'auth_key', 'first_name', 'last_name', 'user_type_enc_id', 'phone', 'initials_color'], 'required'],
            [['dob', 'created_on', 'last_updated_on'], 'safe'],
            [['gender', 'is_available', 'is_email_verified', 'is_phone_verified', 'is_deleted'], 'integer'],
            [['user_of', 'status'], 'string'],
            [['user_enc_id', 'auth_key', 'user_type_enc_id', 'address', 'image', 'image_location', 'cover_image', 'cover_image_location', 'city_enc_id', 'organization_enc_id', 'job_function', 'asigned_job_function'], 'string', 'max' => 100],
            [['username', 'email', 'facebook', 'google', 'twitter', 'instagram', 'linkedin', 'youtube', 'skype'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 200],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone', 'experience'], 'string', 'max' => 15],
            [['initials_color'], 'string', 'max' => 7],
            [['description'], 'string', 'max' => 500],
            [['user_enc_id'], 'unique'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['user_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::className(), 'targetAttribute' => ['user_type_enc_id' => 'user_type_enc_id']],
            [['job_function'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['job_function' => 'category_enc_id']],
            [['asigned_job_function'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['asigned_job_function' => 'assigned_category_enc_id']],
        ];
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
    public function getApplicationTemplateOptions()
    {
        return $this->hasMany(ApplicationTemplateOptions::className(), ['created_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTemplateOptions0()
    {
        return $this->hasMany(ApplicationTemplateOptions::className(), ['last_updated_by' => 'user_enc_id']);
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
    public function getReviewEncs()
    {
        return $this->hasMany(OrganizationReviews::className(), ['review_enc_id' => 'review_enc_id'])->viaTable('{{%organization_review_feedback}}', ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviews()
    {
        return $this->hasMany(OrganizationReviews::className(), ['last_updated_by' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationReviews0()
    {
        return $this->hasMany(OrganizationReviews::className(), ['created_by' => 'user_enc_id']);
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
}