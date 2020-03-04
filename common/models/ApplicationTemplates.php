<?php
namespace common\models;
/**
 * This is the model class for table "{{%application_templates}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Application Encrypted ID
 * @property string $application_type_enc_id Foreign Key to Application Types Table
 * @property string $description Application Description
 * @property string $title Foreign Key to Assigned Categories Table
 * @property string $designation_enc_id Foreign Key to Designations Table
 * @property string $type Type (Full Time, Part Time, Work from Home)
 * @property string $preferred_industry Foreign Key to Industries Table
 * @property string $interview_process_enc_id Foreign Key to Organization Interview Process
 * @property string $timings_from Timings From
 * @property string $timings_to Timings To
 * @property string $image
 * @property string $image_location
 * @property string $joining_date Joining Date
 * @property string $last_date Last Date to Apply
 * @property string $experience Minimum Experience Required
 * @property string $preferred_gender Preferred Gender (1 as Male, 2 as Female, 3 as Both)
 * @property int $has_questionnaire Has Questionnaire (0 as No, 1 as Yes)
 * @property int $has_benefits Has Benefits (0 as No, 1 as Yes)
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property string $status Application Status (Draft, Active, Inactive, Pending)
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property AppEmpBenefitTemplate[] $appEmpBenefitTemplates
 * @property AppInterviewQuestionnaireTemplate[] $appInterviewQuestionnaireTemplates
 * @property ApplicationEduReqTemplate[] $applicationEduReqTemplates
 * @property ApplicationOptionsTemplate[] $applicationOptionsTemplates
 * @property ApplicationSkillsTemplate[] $applicationSkillsTemplates
 * @property ApplicationTemplateJobDescription[] $applicationTemplateJobDescriptions
 * @property ApplicationTypes $applicationTypeEnc
 * @property AssignedCategories $title0
 * @property Industries $preferredIndustry
 * @property Designations $designationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application_templates}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_enc_id', 'application_type_enc_id', 'title', 'type', 'timings_from', 'timings_to', 'preferred_gender', 'created_by'], 'required'],
            [['description', 'type', 'experience', 'preferred_gender', 'status'], 'string'],
            [['timings_from', 'timings_to', 'joining_date', 'last_date', 'created_on', 'last_updated_on'], 'safe'],
            [['has_questionnaire', 'has_benefits', 'is_deleted'], 'integer'],
            [['application_enc_id', 'application_type_enc_id', 'title', 'designation_enc_id', 'preferred_industry', 'interview_process_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_enc_id'], 'unique'],
            [['image', 'image_location'], 'string', 'max' => 100],
            [['application_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTypes::className(), 'targetAttribute' => ['application_type_enc_id' => 'application_type_enc_id']],
            [['title'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['title' => 'assigned_category_enc_id']],
            [['preferred_industry'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['preferred_industry' => 'industry_enc_id']],
            [['designation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation_enc_id' => 'designation_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppInterviewQuestionnaireTemplates()
    {
        return $this->hasMany(AppInterviewQuestionnaireTemplate::className(), ['application_enc_id' => 'application_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEduReqTemplates()
    {
        return $this->hasMany(ApplicationEduReqTemplate::className(), ['application_enc_id' => 'application_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationOptionsTemplates()
    {
        return $this->hasMany(ApplicationOptionsTemplate::className(), ['application_enc_id' => 'application_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkillsTemplates()
    {
        return $this->hasMany(ApplicationSkillsTemplate::className(), ['application_enc_id' => 'application_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTemplateJobDescriptions()
    {
        return $this->hasMany(ApplicationTemplateJobDescription::className(), ['application_enc_id' => 'application_enc_id']);
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
    public function getDesignationEnc()
    {
        return $this->hasOne(Designations::className(), ['designation_enc_id' => 'designation_enc_id']);
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
}