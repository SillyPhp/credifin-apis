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
 * @property string $status Organization Status (Active, Inactive, Pending)
 * @property int $is_deleted Is Organization Deleted (0 as False, 1 as True)
 *
 * @property AssignedTags[] $assignedTags
 * @property BookmarkedHiringTemplates[] $bookmarkedHiringTemplates
 * @property HiringProcessTemplates[] $hiringProcessEncs
 * @property BookmarkedQuestionnaireTemplates[] $bookmarkedQuestionnaireTemplates
 * @property QuestionnaireTemplates[] $questionnnaireEncs
 * @property ConversationParticipants[] $conversationParticipants
 * @property Designations[] $designations
 * @property EducationalRequirements[] $educationalRequirements
 * @property EmployeeBenefits[] $employeeBenefits
 * @property EmployerApplications[] $employerApplications
 * @property FollowedOrganizations[] $followedOrganizations
 * @property Users[] $userEncs
 * @property JobDescription[] $jobDescriptions
 * @property OrganizationAssignedCategories[] $organizationAssignedCategories
 * @property OrganizationBlogInformation[] $organizationBlogInformations
 * @property OrganizationEmployeeBenefits[] $organizationEmployeeBenefits
 * @property OrganizationEmployees[] $organizationEmployees
 * @property OrganizationImages[] $organizationImages
 * @property OrganizationInterviewProcess[] $organizationInterviewProcesses
 * @property OrganizationLocations[] $organizationLocations
 * @property OrganizationProducts[] $organizationProducts
 * @property OrganizationQuestionnaire[] $organizationQuestionnaires
 * @property OrganizationReviews[] $organizationReviews
 * @property OrganizationVideos[] $organizationVideos
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property BusinessActivities $businessActivityEnc
 * @property Industries $industryEnc
 * @property OrganizationTypes $organizationTypeEnc
 * @property Referral[] $referrals
 * @property Users[] $userEncs0
 * @property ReferralSignUpTracking[] $referralSignUpTrackings
 * @property Reviews[] $reviews
 * @property Roles[] $roles
 * @property SelectedServices[] $selectedServices
 * @property ShortlistedOrganizations[] $shortlistedOrganizations
 * @property Skills[] $skills
 * @property UserOtherDetails[] $userOtherDetails
 * @property UserTasks[] $userTasks
 * @property UserVerificationTokens[] $userVerificationTokens
 * @property Users[] $users
 */

class Organizations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organizations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_enc_id', 'name', 'slug', 'email', 'initials_color', 'phone', 'created_by'], 'required'],
            [['establishment_year', 'created_on', 'last_updated_on'], 'safe'],
            [['description', 'mission', 'vision', 'value', 'status'], 'string'],
            [['number_of_employees', 'is_sponsored', 'is_featured', 'is_email_verified', 'is_phone_verified', 'is_startup', 'is_erexx_registered', 'is_deleted'], 'integer'],
            [['organization_enc_id', 'organization_type_enc_id', 'business_activity_enc_id', 'industry_enc_id', 'name', 'slug', 'logo', 'logo_location', 'cover_image', 'cover_image_location', 'tag_line', 'website', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['email', 'facebook', 'google', 'twitter', 'instagram', 'linkedin'], 'string', 'max' => 50],
            [['initials_color'], 'string', 'max' => 7],
            [['phone', 'fax'], 'string', 'max' => 15],
            [['email'], 'unique'],
            [['slug'], 'unique'],
            [['organization_enc_id'], 'unique'],
            [['phone'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['business_activity_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['business_activity_enc_id' => 'business_activity_enc_id']],
            [['industry_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['industry_enc_id' => 'industry_enc_id']],
            [['organization_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationTypes::className(), 'targetAttribute' => ['organization_type_enc_id' => 'organization_type_enc_id']],
        ];
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
    public function getBookmarkedHiringTemplates()
    {
        return $this->hasMany(BookmarkedHiringTemplates::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHiringProcessEncs()
    {
        return $this->hasMany(HiringProcessTemplates::className(), ['hiring_process_enc_id' => 'hiring_process_enc_id'])->viaTable('{{%bookmarked_hiring_templates}}', ['organization_enc_id' => 'organization_enc_id']);
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
    public function getQuestionnnaireEncs()
    {
        return $this->hasMany(QuestionnaireTemplates::className(), ['questionnaire_enc_id' => 'questionnnaire_enc_id'])->viaTable('{{%bookmarked_questionnaire_templates}}', ['organization_enc_id' => 'organization_enc_id']);
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
    public function getDesignations()
    {
        return $this->hasMany(Designations::className(), ['organization_enc_id' => 'organization_enc_id']);
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
    public function getFollowedOrganizations()
    {
        return $this->hasMany(FollowedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEncs()
    {
        return $this->hasMany(Users::className(), ['user_enc_id' => 'user_enc_id'])->viaTable('{{%followed_organizations}}', ['organization_enc_id' => 'organization_enc_id']);
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
    public function getOrganizationLocations()
    {
        return $this->hasMany(OrganizationLocations::className(), ['organization_enc_id' => 'organization_enc_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
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
    public function getBusinessActivityEnc()
    {
        return $this->hasOne(BusinessActivities::className(), ['business_activity_enc_id' => 'business_activity_enc_id']);
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
    public function getOrganizationTypeEnc()
    {
        return $this->hasOne(OrganizationTypes::className(), ['organization_type_enc_id' => 'organization_type_enc_id']);
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
    public function getUserEncs0()
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
    public function getSelectedServices()
    {
        return $this->hasMany(SelectedServices::className(), ['organization_enc_id' => 'organization_enc_id']);
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
    public function getUserOtherDetails()
    {
        return $this->hasMany(UserOtherDetails::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks()
    {
        return $this->hasMany(UserTasks::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserVerificationTokens()
    {
        return $this->hasMany(UserVerificationTokens::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}