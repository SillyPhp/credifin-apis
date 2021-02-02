<?php
namespace common\models;

/**
 * This is the model class for table "{{%drop_resume_applied_applications}}".
 *
 * @property int $id Primary Key
 * @property string $applied_application_enc_id Application Encrypted ID
 * @property int $experience Experience (0 as No Experience, 1 as Less Than 1 Year, 2 as 1 Year, 3 as 2-3 Years, 4 as 3-5 Years, 5 as 5-10 Years, 6 as 10-20 Years, 7 as 20+ Years)
 * @property string $resume_enc_id linked with user resumes
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property int $status Application Status (0 as Pending, 1 as Shortlisted, 2 as Rejected)
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property UserResume $resumeEnc
 * @property DropResumeAppliedTitles[] $dropResumeAppliedTitles
 * @property DropResumeOrgApplication[] $dropResumeOrgApplications
 * @property DropResumeSelectedLocations[] $dropResumeSelectedLocations
 * @property Cities[] $cityEncs
 * @property DropResumeUnclaimOrgApplication[] $dropResumeUnclaimOrgApplications
 */
class DropResumeAppliedApplications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%drop_resume_applied_applications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['applied_application_enc_id', 'experience', 'created_by'], 'required'],
            [['experience', 'status', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['applied_application_enc_id', 'resume_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['applied_application_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['resume_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserResume::className(), 'targetAttribute' => ['resume_enc_id' => 'resume_enc_id']],
        ];
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
    public function getResumeEnc()
    {
        return $this->hasOne(UserResume::className(), ['resume_enc_id' => 'resume_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeAppliedTitles()
    {
        return $this->hasMany(DropResumeAppliedTitles::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeOrgApplications()
    {
        return $this->hasMany(DropResumeOrgApplication::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeSelectedLocations()
    {
        return $this->hasMany(DropResumeSelectedLocations::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEncs()
    {
        return $this->hasMany(Cities::className(), ['city_enc_id' => 'city_enc_id'])->viaTable('{{%drop_resume_selected_locations}}', ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeUnclaimOrgApplications()
    {
        return $this->hasMany(DropResumeUnclaimOrgApplication::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }
}
