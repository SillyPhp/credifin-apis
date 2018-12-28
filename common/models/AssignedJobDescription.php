<?php

namespace common\models;

/**
 * This is the model class for table "{{%assigned_job_description}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_job_description_enc_id Assigned Job Description Encrypted ID
 * @property string $job_description_enc_id Foreign Key to Job Description Table
 * @property string $category_enc_id Foreign Key to Categories List Table
 * @property string $created_on On which date Assigned Job Description information was added to database
 * @property string $created_by By which User Assigned Job Description information was added
 * @property string $last_updated_on On which date Assigned Job Description information was updated
 * @property string $last_updated_by By which User Assigned Job Description information was updated
 * @property string $status Assigned Job Description Status (Approved, Pending)
 * @property int $is_deleted Is Assigned Job Description Deleted (0 As False, 1 As True)
 *
 * @property Categories $categoryEnc
 * @property JobDescription $jobDescriptionEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class AssignedJobDescription extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%assigned_job_description}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['assigned_job_description_enc_id', 'job_description_enc_id', 'category_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['is_deleted'], 'integer'],
            [['assigned_job_description_enc_id', 'job_description_enc_id', 'category_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_job_description_enc_id'], 'unique'],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
            [['job_description_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobDescription::className(), 'targetAttribute' => ['job_description_enc_id' => 'job_description_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryEnc() {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'category_enc_id']);
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
