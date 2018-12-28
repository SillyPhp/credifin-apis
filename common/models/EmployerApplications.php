<?php

namespace common\models;

/**
 * This is the model class for table "{{%employer_applications}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Application Encrypted ID
 * @property int $application_number Application Number
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $application_type_enc_id Foreign Key to Application Types Table
 * @property string $slug Application Slug
 * @property string $description Application Description
 * @property string $title Foreign Key to Assigned Categories Table
 * @property string $designation_enc_id Foreign Key to Designations Table
 * @property string $type Type (Full Time, Part Time, Work from Home)
 * @property string $preferred_industry Foreign Key to Industries Table
 * @property string $questionnaire_enc_id Foreign Key to Questionnaires Table
 * @property string $interview_process_enc_id Foreign Key to Organization Interview Process
 * @property string $timings_from Timings From
 * @property string $timings_to Timings To
 * @property string $joining_date Joining Date
 * @property string $last_date Last Date to Apply
 * @property string $experience Minimum Experience Required
 * @property string $preferred_gender Preferred Gender (1 as Male, 2 as Female, 3 as Both) 
 * @property string $fill_questionnaire_on Fill Questionnaire (1 as at the time of application, 2 as after initial approval of the application)
 * @property int $is_sponsored Is Application Sponsored (0 as False, 1 as True)
 * @property int $is_featured Is Application Featured (0 as False, 1 as True)
 * @property string $published_on On which date application was published
 * @property string $image Application Image
 * @property string $image_location Application Image Path
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
 * @property ApplicationPlacementLocations[] $applicationPlacementLocations
 * @property ApplicationSkills[] $applicationSkills
 * @property AppliedApplications[] $appliedApplications
 * @property ApplicationTypes $applicationTypeEnc
 * @property AssignedCategories $title
 * @property Industries $preferredIndustry
 * @property OrganizationInterviewProcess $interviewProcessEnc
 * @property Designations $designationEnc
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property OrganizationQuestionnaire $questionnaireEnc
 * @property InterviewScheduler[] $interviewSchedulers
 * @property ReviewedApplications[] $reviewedApplications
 * @property ShortlistedApplications[] $shortlistedApplications
 */
class EmployerApplications extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%employer_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['application_enc_id', 'application_number', 'organization_enc_id', 'application_type_enc_id', 'slug', 'title', 'designation_enc_id', 'type', 'preferred_industry', 'timings_from', 'timings_to', 'joining_date', 'last_date', 'experience', 'preferred_gender', 'published_on', 'image', 'image_location', 'created_on', 'created_by'], 'required'],
            [['application_number', 'is_sponsored', 'is_featured', 'is_deleted'], 'integer'],
            [['description', 'type', 'experience', 'preferred_gender', 'fill_questionnaire_on', 'status'], 'string'],
            [['timings_from', 'timings_to', 'joining_date', 'last_date', 'published_on', 'created_on', 'last_updated_on'], 'safe'],
            [['application_enc_id', 'organization_enc_id', 'application_type_enc_id', 'slug', 'title', 'designation_enc_id', 'preferred_industry', 'questionnaire_enc_id', 'interview_process_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_enc_id'], 'unique'],
            [['application_number'], 'unique'],
            [['slug'], 'unique'],
            [['application_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTypes::className(), 'targetAttribute' => ['application_type_enc_id' => 'application_type_enc_id']],
            [['title'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['title' => 'assigned_category_enc_id']],
            [['preferred_industry'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['preferred_industry' => 'industry_enc_id']],
            [['interview_process_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationInterviewProcess::className(), 'targetAttribute' => ['interview_process_enc_id' => 'interview_process_enc_id']],
            [['designation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation_enc_id' => 'designation_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['questionnaire_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationQuestionnaire::className(), 'targetAttribute' => ['questionnaire_enc_id' => 'questionnaire_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEducationalRequirements() {
        return $this->hasMany(ApplicationEducationalRequirements::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEmployeeBenefits() {
        return $this->hasMany(ApplicationEmployeeBenefits::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewLocations() {
        return $this->hasMany(ApplicationInterviewLocations::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewQuestionnaires() {
        return $this->hasMany(ApplicationInterviewQuestionnaire::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationJobDescriptions() {
        return $this->hasMany(ApplicationJobDescription::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationOptions() {
        return $this->hasMany(ApplicationOptions::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPlacementLocations() {
        return $this->hasMany(ApplicationPlacementLocations::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkills() {
        return $this->hasMany(ApplicationSkills::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplications() {
        return $this->hasMany(AppliedApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTypeEnc() {
        return $this->hasOne(ApplicationTypes::className(), ['application_type_enc_id' => 'application_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle() {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'title']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferredIndustry() {
        return $this->hasOne(Industries::className(), ['industry_enc_id' => 'preferred_industry']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewProcessEnc() {
        return $this->hasOne(OrganizationInterviewProcess::className(), ['interview_process_enc_id' => 'interview_process_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignationEnc() {
        return $this->hasOne(Designations::className(), ['designation_enc_id' => 'designation_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc() {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireEnc() {
        return $this->hasOne(OrganizationQuestionnaire::className(), ['questionnaire_enc_id' => 'questionnaire_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewSchedulers() {
        return $this->hasMany(InterviewScheduler::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewedApplications() {
        return $this->hasMany(ReviewedApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortlistedApplications() {
        return $this->hasMany(ShortlistedApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

}
