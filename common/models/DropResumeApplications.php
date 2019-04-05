<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%drop_resume_applications}}".
 *
 * @property int $id Primary Key
 * @property string $applied_application_enc_id Application Encrypted ID
 * @property string $user_enc_id Foreign Key to Users Table
 * @property int $experience Experience (0 as No Experience, 1 as Less Than 1 Year, 2 as 1 Year, 3 as 2-3 Years, 4 as 3-5 Years, 5 as 5-10 Years, 6 as 10-20 Years, 7 as 20+ Years)
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property int $status Application Status (0 as Pending, 1 as Shortlisted, 2 as Rejected)
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property DropResumeApplicationLocations[] $dropResumeApplicationLocations
 * @property DropResumeApplicationTitles[] $dropResumeApplicationTitles
 * @property Users $userEnc
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class DropResumeApplications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%drop_resume_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applied_application_enc_id', 'user_enc_id', 'experience', 'created_by', 'last_updated_by'], 'required'],
            [['experience', 'status', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['applied_application_enc_id', 'user_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['applied_application_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationLocations()
    {
        return $this->hasMany(DropResumeApplicationLocations::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeApplicationTitles()
    {
        return $this->hasMany(DropResumeApplicationTitles::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
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
