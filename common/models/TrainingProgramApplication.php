<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%training_program_application}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Application Encrypted ID
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $unclaimed_organization_enc_id
 * @property string $application_number
 * @property string $profile_enc_id
 * @property string $title
 * @property string $application_type_enc_id Foreign Key to Application Types Table
 * @property string $slug Application Slug
 * @property string $description Application Description
 * @property string $training_duration Training Period
 * @property string $training_duration_type Training Period in(1 as Monthly, 2 as Weekly, 3 as Annually 4 One Time)
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property AppliedTrainingApplications[] $appliedTrainingApplications
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property AssignedCategories $title0
 * @property ApplicationTypes $applicationTypeEnc
 * @property UnclaimedOrganizations $unclaimedOrganizationEnc
 * @property Organizations $organizationEnc
 * @property Categories $profileEnc
 * @property TrainingProgramBatches[] $trainingProgramBatches
 * @property TrainingProgramSkills[] $trainingProgramSkills
 */
class TrainingProgramApplication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%training_program_application}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_enc_id', 'organization_enc_id', 'application_number', 'profile_enc_id', 'title', 'application_type_enc_id', 'slug', 'training_duration', 'training_duration_type', 'created_by'], 'required'],
            [['description', 'training_duration_type'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['application_enc_id', 'organization_enc_id', 'unclaimed_organization_enc_id', 'application_number', 'profile_enc_id', 'title', 'application_type_enc_id', 'slug', 'training_duration', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['application_number'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['title'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['title' => 'assigned_category_enc_id']],
            [['application_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTypes::className(), 'targetAttribute' => ['application_type_enc_id' => 'application_type_enc_id']],
            [['unclaimed_organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['unclaimed_organization_enc_id' => 'organization_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['profile_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['profile_enc_id' => 'category_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedTrainingApplications()
    {
        return $this->hasMany(AppliedTrainingApplications::className(), ['application_enc_id' => 'application_enc_id']);
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
    public function getTitle0()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'title']);
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
    public function getProfileEnc()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'profile_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramBatches()
    {
        return $this->hasMany(TrainingProgramBatches::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramSkills()
    {
        return $this->hasMany(TrainingProgramSkills::className(), ['application_enc_id' => 'application_enc_id']);
    }
}
