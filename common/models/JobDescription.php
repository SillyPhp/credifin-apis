<?php

namespace common\models;

/**
 * This is the model class for table "{{%job_description}}".
 *
 * @property int $id Primary Key
 * @property string $job_description_enc_id Job Description Encrypted ID
 * @property string $job_description Job Description
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Job Description information was added to database
 * @property string $created_by By which User Job Description information was added
 * @property string $last_updated_on On which date Job Description information was updated
 * @property string $last_updated_by By which User Job Description information was updated
 * @property string $status Job Description Status (Publish, Pending)
 * @property int $is_deleted Is Job Description Deleted (0 As False, 1 As True)
 *
 * @property ApplicationJobDescription[] $applicationJobDescriptions
 * @property AssignedJobDescription[] $assignedJobDescriptions
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 */
class JobDescription extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%job_description}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['job_description_enc_id', 'job_description', 'created_on', 'created_by'], 'required'],
            [['job_description', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['job_description_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['job_description_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationJobDescriptions() {
        return $this->hasMany(ApplicationJobDescription::className(), ['job_description_enc_id' => 'job_description_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedJobDescriptions() {
        return $this->hasMany(AssignedJobDescription::className(), ['job_description_enc_id' => 'job_description_enc_id']);
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
    public function getOrganizationEnc() {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

}
