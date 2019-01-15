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
 * @property string $user_of User Of
 * @property string $created_on On which date User information was added to database
 * @property string $last_updated_on On which date User information was updated
 * @property int $is_email_verified Is User Email Verified (0 as False, 1 as True)
 * @property int $is_phone_verified Is User Phone Verified (0 as False, 1 as True)
 * @property string $status User Status (Active, Inactive, Pending)
 * @property int $is_deleted Is User Deleted (0 as False, 1 as True)
 * @property string $access_token User Access Token
 * @property string $token_expiration_time Expiration Time of Token
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
 * @property Categories[] $categories
 * @property Categories[] $categories0
 * @property CategoriesList[] $categoriesLists
 * @property CategoriesList[] $categoriesLists0
 * @property Designations[] $designations
 * @property Designations[] $designations0
 * @property EducationalRequirements[] $educationalRequirements
 * @property EducationalRequirements[] $educationalRequirements0
 * @property EmployeeBenefits[] $employeeBenefits
 * @property EmployeeBenefits[] $employeeBenefits0
 * @property EmployerApplications[] $employerApplications
 * @property EmployerApplications[] $employerApplications0
 * @property Feedback[] $feedbacks
 * @property Feedback[] $feedbacks0
 * @property InterviewProcessFields[] $interviewProcessFields
 * @property InterviewProcessFields[] $interviewProcessFields0
 * @property InterviewScheduler[] $interviewSchedulers
 * @property InterviewScheduler[] $interviewSchedulers0
 * @property JobDescription[] $jobDescriptions
 * @property JobDescription[] $jobDescriptions0
 * @property LearningCornerResourceDiscussion[] $learningCornerResourceDiscussions
 * @property LearningCornerResourceDiscussion[] $learningCornerResourceDiscussions0
 * @property OrganizationEmployeeBenefits[] $organizationEmployeeBenefits
 * @property OrganizationEmployeeBenefits[] $organizationEmployeeBenefits0
 * @property OrganizationImages[] $organizationImages
 * @property OrganizationImages[] $organizationImages0
 * @property OrganizationInterviewProcess[] $organizationInterviewProcesses
 * @property OrganizationInterviewProcess[] $organizationInterviewProcesses0
 * @property OrganizationLocations[] $organizationLocations
 * @property OrganizationLocations[] $organizationLocations0
 * @property OrganizationQuestionnaire[] $organizationQuestionnaires
 * @property OrganizationQuestionnaire[] $organizationQuestionnaires0
 * @property OrganizationReviews[] $organizationReviews
 * @property OrganizationReviews[] $organizationReviews0
 * @property OrganizationVideos[] $organizationVideos
 * @property OrganizationVideos[] $organizationVideos0
 * @property Organizations[] $organizations
 * @property Organizations[] $organizations0
 * @property PostCategories[] $postCategories
 * @property PostCategories[] $postCategories0
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
 * @property SocialPages[] $socialPages
 * @property SocialPages[] $socialPages0
 * @property SocialProfiles[] $socialProfiles
 * @property SocialProfiles[] $socialProfiles0
 * @property SocialPublicGroups[] $socialPublicGroups
 * @property SocialPublicGroups[] $socialPublicGroups0
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
 * @property UserEducation[] $userEducations
 * @property UserEducation[] $userEducations0
 * @property UserEducation[] $userEducations1
 * @property UserPreferences[] $userPreferences
 * @property UserPreferences[] $userPreferences0
 * @property UserPreferredIndustries[] $userPreferredIndustries
 * @property UserPreferredIndustries[] $userPreferredIndustries0
 * @property UserPreferredLocations[] $userPreferredLocations
 * @property UserPreferredLocations[] $userPreferredLocations0
 * @property UserPreferredSkills[] $userPreferredSkills
 * @property UserPreferredSkills[] $userPreferredSkills0
 * @property UserResume[] $userResumes
 * @property UserResume[] $userResumes0
 * @property UserResume[] $userResumes1
 * @property UserSkills[] $userSkills
 * @property UserSkills[] $userSkills0
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
            [['user_enc_id', 'username', 'email', 'password', 'auth_key', 'first_name', 'last_name', 'user_type_enc_id', 'phone', 'initials_color', 'created_on'], 'required'],
            [['user_of', 'status'], 'string'],
            [['created_on', 'last_updated_on', 'token_expiration_time'], 'safe'],
            [['is_email_verified', 'is_phone_verified', 'is_deleted'], 'integer'],
            [['user_enc_id', 'auth_key', 'user_type_enc_id', 'address', 'image', 'image_location', 'cover_image', 'cover_image_location', 'city_enc_id', 'organization_enc_id', 'job_function', 'access_token'], 'string', 'max' => 100],
            [['username', 'email', 'facebook', 'google', 'twitter', 'instagram', 'linkedin', 'youtube', 'skype'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 200],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 15],
            [['initials_color'], 'string', 'max' => 7],
            [['description'], 'string', 'max' => 500],
            [['user_enc_id'], 'unique'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['access_token'], 'unique'],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['user_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::className(), 'targetAttribute' => ['user_type_enc_id' => 'user_type_enc_id']],
            [['job_function'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['job_function' => 'category_enc_id']],
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
        return $this->hasMany(AssignedIndustries::className(), ['industry_enc_id' => 'user_enc_id']);
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
}

