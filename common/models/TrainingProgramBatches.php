<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%training_program_batches}}".
 *
 * @property int $id Primary Key
 * @property string $batch_enc_id Training Program Batch Encrypted ID
 * @property string $application_enc_id Foreign Key to Training Programs
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $fees
 * @property int $fees_methods
 * @property string $seats
 * @property string $days
 * @property string $start_time Batch Start Timings
 * @property string $end_time Batch End Timings
 * @property string $created_on On which date Training Program Batch information was added to database
 * @property string $created_by By which User Training Program Batch information was added
 * @property string $last_updated_on On which date Training Program Batch information was updated
 * @property string $last_updated_by By which User Training Program information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Cities $cityEnc
 * @property TrainingProgramApplication $applicationEnc
 */
class TrainingProgramBatches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%training_program_batches}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['batch_enc_id', 'application_enc_id', 'city_enc_id', 'fees', 'fees_methods', 'seats', 'days', 'start_time', 'end_time', 'created_on', 'created_by'], 'required'],
            [['fees_methods'], 'integer'],
            [['start_time', 'end_time', 'created_on', 'last_updated_on'], 'safe'],
            [['batch_enc_id', 'application_enc_id', 'city_enc_id', 'fees', 'seats', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['days'], 'string', 'max' => 50],
            [['batch_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
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
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(TrainingProgramApplication::className(), ['application_enc_id' => 'application_enc_id']);
    }
}
