<?php

namespace common\models;


/**
 * This is the model class for table "{{%applied_training_batches}}".
 *
 * @property int $id Primary Key
 * @property string $applied_batches_application_enc_id Application Encrypted ID
 * @property string $applied_application_enc_id Foreign Key to Training Applications Table
 * @property string $batch_enc_id
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property string $status Application Status (Accepted, Rejected, Pending, Hired, Cancelled)
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property AppliedTrainingApplications $appliedApplicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property TrainingProgramBatches $batchEnc
 */
class AppliedTrainingBatches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%applied_training_batches}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applied_batches_application_enc_id', 'applied_application_enc_id', 'batch_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['is_deleted'], 'integer'],
            [['applied_batches_application_enc_id', 'applied_application_enc_id', 'batch_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['applied_batches_application_enc_id'], 'unique'],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedTrainingApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['batch_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrainingProgramBatches::className(), 'targetAttribute' => ['batch_enc_id' => 'batch_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc()
    {
        return $this->hasOne(AppliedTrainingApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
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
    public function getBatchEnc()
    {
        return $this->hasOne(TrainingProgramBatches::className(), ['batch_enc_id' => 'batch_enc_id']);
    }
}
