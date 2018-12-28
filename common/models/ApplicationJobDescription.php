<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%application_job_description}}".
 *
 * @property int $id Primary Key
 * @property string $application_job_description_enc_id Application Job Description Encrypted ID
 * @property string $job_description_enc_id Foreign Key to Job Description Table
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property string $created_on On which date Application Job Description information was added to database
 * @property string $created_by By which User Application Job Description information was added
 * @property string $last_updated_on On which date Application Job Description information was updated
 * @property string $last_updated_by By which User Application Job Description information was updated
 * @property int $is_deleted Is Application Job Description Deleted (0 As False, 1 As True)
 *
 * @property EmployerApplications $applicationEnc
 * @property JobDescription $jobDescriptionEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationJobDescription extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_job_description}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['application_job_description_enc_id', 'job_description_enc_id', 'application_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['application_job_description_enc_id', 'job_description_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_job_description_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['job_description_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobDescription::className(), 'targetAttribute' => ['job_description_enc_id' => 'job_description_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc() {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobDescriptionEnc() {
        return $this->hasOne(JobDescription::className(), ['job_description_enc_id' => 'job_description_enc_id']);
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

}
