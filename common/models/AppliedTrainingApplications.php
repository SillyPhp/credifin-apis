<?php

namespace common\models;

/**
 * This is the model class for table "{{%applied_training_applications}}".
 *
 * @property int $id Primary Key
 * @property string $applied_application_enc_id Application Encrypted ID
 * @property int $application_number Application Number
 * @property string $application_enc_id Foreign Key to Training Applications Table
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property string $status Application Status (Accepted, Rejected, Pending, Hired, Cancelled)
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property TrainingProgramApplication $applicationEnc
 * @property AppliedTrainingBatches[] $appliedTrainingBatches
 */
class AppliedTrainingApplications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%applied_training_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applied_application_enc_id', 'application_number', 'application_enc_id', 'created_on', 'created_by'], 'required'],
            [['application_number', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['applied_application_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['applied_application_enc_id'], 'unique'],
            [['application_number'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrainingProgramApplication::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
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
    public function getApplicationEnc()
    {
        return $this->hasOne(TrainingProgramApplication::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedTrainingBatches()
    {
        return $this->hasMany(AppliedTrainingBatches::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }
}
