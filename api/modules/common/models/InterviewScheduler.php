<?php

namespace common\models;

/**
 * This is the model class for table "{{%interview_scheduler}}".
 *
 * @property int $id Primary Key
 * @property string $interview_enc_id Interview Encrypted ID
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property string $start_date Start Date of interview
 * @property string $end_date End Date of interview
 * @property string $color Interview Color
 * @property string $location Interview Location
 * @property string $notes Interview Notes
 * @property string $created_on On which date Interview information was added to database
 * @property string $created_by By which User Interview information was added
 * @property string $last_updated_on On which date Interview information was updated
 * @property string $last_updated_by By which User Interview information was updated
 * @property int $is_deleted Is Interview Deleted (0 as False, 1 as True)
 *
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class InterviewScheduler extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%interview_scheduler}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['interview_enc_id', 'start_date', 'end_date', 'color', 'created_on', 'created_by'], 'required'],
            [['start_date', 'end_date', 'created_on', 'last_updated_on'], 'safe'],
            [['notes'], 'string'],
            [['is_deleted'], 'integer'],
            [['interview_enc_id', 'application_enc_id', 'location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 7],
            [['interview_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
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
