<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%employer_applications}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Application Encrypted ID
 * @property int $application_number Application Number
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $unclaimed_organization_enc_id Foreign Key to unclaimed Organizations Table
 * @property string $application_type_enc_id Foreign Key to Application Types Table
 * @property string $slug Application Slug
 * @property string $description Application Description
 * @property string $body Application Html Content
 * @property int $source 1 for ey 2 for git 3 for muse
 * @property string $unique_source_id source ids for apis
 * @property string $title Foreign Key to Assigned Categories Table
 * @property string $designation_enc_id Foreign Key to Designations Table
 * @property string $type Type (Full Time, Part Time, Work From Home, Contract)
 * @property string $preferred_industry Foreign Key to Industries Table
 * @property string $interview_process_enc_id Foreign Key to Organization Interview Process
 * @property string $timings_from Timings From
 * @property string $timings_to Timings To
 * @property string $joining_date Joining Date
 * @property string $last_date Last Date to Apply
 * @property string $experience Minimum Experience Required
 * @property string $minimum_exp Minimum Experience Required
 * @property string $maximum_exp Maximum Experience Required
 * @property string $preferred_gender Preferred Gender (1 as Male, 2 as Female, 3 as Both)
 * @property int $is_sponsored Is Application Sponsored (0 as False, 1 as True)
 * @property int $is_featured Is Application Featured (0 as False, 1 as True)
 * @property int $for_careers Is Application for Careers (0 as False, 1 as True)
 * @property string $published_on On which date application was published
 * @property string $image Application Image
 * @property string $image_location Application Image Path
 * @property int $application_for 0 for Both, 1 for Empower Youth, 2 for Erexx
 * @property int $for_all_colleges 0 for choosed colleges, 1 for all colleges
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property string $status Application Status (Draft, Active, Inactive, Pending)
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property ApplicationEducationalRequirements[] $applicationEducationalRequirements
 * @property ApplicationEmployeeBenefits[] $applicationEmployeeBenefits
 * @property ApplicationInterviewLocations[] $applicationInterviewLocations
 * @property ApplicationInterviewQuestionnaire[] $applicationInterviewQuestionnaires
 * @property ApplicationJobDescription[] $applicationJobDescriptions
 * @property ApplicationOptions[] $applicationOptions
 * @property ApplicationPlacementCities[] $applicationPlacementCities
 * @property ApplicationPlacementLocations[] $applicationPlacementLocations
 * @property ApplicationSkills[] $applicationSkills
 * @property ApplicationUnclaimOptions[] $applicationUnclaimOptions
 * @property AppliedApplications[] $appliedApplications
 * @property DropResumeApplicationTitles[] $dropResumeApplicationTitles
 * @property DropResumeApplications[] $dropResumeApplications
 * @property ApplicationTypes $applicationTypeEnc
// * @property AssignedCategories $title
 * @property AssignedCategories $title0
 * @property Industries $preferredIndustry
 * @property OrganizationInterviewProcess $interviewProcessEnc
 * @property Designations $designationEnc
 * @property UnclaimedOrganizations $unclaimedOrganizationEnc
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property InterviewScheduler[] $interviewSchedulers
 * @property OrganizationBlogInformationApplications[] $organizationBlogInformationApplications
 * @property ReviewedApplications[] $reviewedApplications
 * @property ScheduledInterview[] $scheduledInterviews
 * @property ShortlistedApplications[] $shortlistedApplications
 */
class EmployerApplications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employer_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_enc_id', 'application_number', 'application_type_enc_id', 'slug', 'title', 'type', 'timings_from', 'timings_to', 'joining_date', 'last_date', 'preferred_gender', 'published_on', 'image'], 'required'],
            [['application_number','source','is_sponsored', 'is_featured', 'for_careers', 'application_for', 'for_all_colleges', 'is_deleted'], 'integer'],
            [['description', 'body', 'type', 'experience','minimum_exp','maximum_exp','preferred_gender', 'status'], 'string'],
            [['timings_from', 'timings_to', 'joining_date', 'last_date', 'published_on', 'created_on', 'last_updated_on'], 'safe'],
            [['application_enc_id', 'organization_enc_id', 'unclaimed_organization_enc_id', 'application_type_enc_id', 'title', 'designation_enc_id', 'preferred_industry', 'interview_process_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['unique_source_id'], 'string', 'max' => 500],
            [['application_enc_id'], 'unique'],
            [['application_number'], 'unique'],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 255],
            [['application_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTypes::className(), 'targetAttribute' => ['application_type_enc_id' => 'application_type_enc_id']],
            [['title'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['title' => 'assigned_category_enc_id']],
            [['preferred_industry'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['preferred_industry' => 'industry_enc_id']],
            [['interview_process_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationInterviewProcess::className(), 'targetAttribute' => ['interview_process_enc_id' => 'interview_process_enc_id']],
            [['designation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation_enc_id' => 'designation_enc_id']],
            [['unclaimed_organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['unclaimed_organization_enc_id' => 'organization_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEducationalRequirements()
    {
        return $this->hasMany(ApplicationEducationalRequirements::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEmployeeBenefits()
    {
        return $this->hasMany(ApplicationEmployeeBenefits::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewLocations()
    {
        return $this->hasMany(ApplicationInterviewLocations::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewQuestionnaires()
    {
        return $this->hasMany(ApplicationInterviewQuestionnaire::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationJobDescriptions()
    {
        return $this->hasMany(ApplicationJobDescription::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationOptions()
    {
        return $this->hasMany(ApplicationOptions::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPlacementCities()
    {
        return $this->hasMany(ApplicationPlacementCities::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPlacementLocations()
    {
        return $this->hasMany(ApplicationPlacementLocations::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkills()
    {
        return $this->hasMany(ApplicationSkills::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationUnclaimOptions()
    {
        return $this->hasMany(ApplicationUnclaimOptions::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplications()
    {
        return $this->hasMany(AppliedApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationTitles()
    {
        return $this->hasMany(DropResumeApplicationTitles::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplications()
    {
        return $this->hasMany(DropResumeApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTypeEnc()
    {
        return $this->hasOne(ApplicationTypes::className(), ['application_type_enc_id' => 'application_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'title']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle0()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'title']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferredIndustry()
    {
        return $this->hasOne(Industries::className(), ['industry_enc_id' => 'preferred_industry']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewProcessEnc()
    {
        return $this->hasOne(OrganizationInterviewProcess::className(), ['interview_process_enc_id' => 'interview_process_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignationEnc()
    {
        return $this->hasOne(Designations::className(), ['designation_enc_id' => 'designation_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedOrganizationEnc()
    {
        return $this->hasOne(UnclaimedOrganizations::className(), ['organization_enc_id' => 'unclaimed_organization_enc_id']);
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
    public function getInterviewSchedulers()
    {
        return $this->hasMany(InterviewScheduler::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationBlogInformationApplications()
    {
        return $this->hasMany(OrganizationBlogInformationApplications::className(), ['blog_information_enc_id' => 'blog_information_enc_id', 'created_by' => 'user_enc_id', 'application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewedApplications()
    {
        return $this->hasMany(ReviewedApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledInterviews()
    {
        return $this->hasMany(ScheduledInterview::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedApplications()
    {
        return $this->hasMany(ShortlistedApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxEmployerApplications()
    {
        return $this->hasMany(ErexxEmployerApplications::className(), ['employer_application_enc_id' => 'application_enc_id']);
    }
}
