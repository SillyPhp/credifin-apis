<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%scheduled_interview}}".
 *
 * @property int $id
 * @property string $scheduled_interview_enc_id
 * @property string $scheduled_interview_type_enc_id
 * @property string $application_enc_id
 * @property int $interview_mode 1 as Online, 2 as Inplace
 * @property string $interview_location_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $status 0 as Inactive, 1 as Active
 *
 * @property InterviewCandidates[] $interviewCandidates
 * @property InterviewDates[] $interviewDates
 * @property InterviewOptions[] $interviewOptions
 * @property Interviewers[] $interviewers
 * @property EmployerApplications $applicationEnc
 * @property InterviewTypes $scheduledInterviewTypeEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property ApplicationInterviewLocations $interviewLocationEnc
 */
class ScheduledInterview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%scheduled_interview}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scheduled_interview_enc_id', 'scheduled_interview_type_enc_id', 'application_enc_id', 'interview_mode', 'created_by'], 'required'],
            [['interview_mode', 'status'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['scheduled_interview_enc_id', 'scheduled_interview_type_enc_id', 'application_enc_id', 'interview_location_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['scheduled_interview_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['scheduled_interview_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterviewTypes::className(), 'targetAttribute' => ['scheduled_interview_type_enc_id' => 'interview_type_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['interview_location_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationInterviewLocations::className(), 'targetAttribute' => ['interview_location_enc_id' => 'interview_location_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewCandidates()
    {
        return $this->hasMany(InterviewCandidates::className(), ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewDates()
    {
        return $this->hasMany(InterviewDates::className(), ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewOptions()
    {
        return $this->hasMany(InterviewOptions::className(), ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewers()
    {
        return $this->hasMany(Interviewers::className(), ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']);
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
    public function getScheduledInterviewTypeEnc()
    {
        return $this->hasOne(InterviewTypes::className(), ['interview_type_enc_id' => 'scheduled_interview_type_enc_id']);
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
    public function getInterviewLocationEnc()
    {
        return $this->hasOne(ApplicationInterviewLocations::className(), ['interview_location_enc_id' => 'interview_location_enc_id']);
    }
}
