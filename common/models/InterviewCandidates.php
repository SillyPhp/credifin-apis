<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%interview_candidates}}".
 *
 * @property int $id
 * @property string $interview_candidate_enc_id
 * @property string $scheduled_interview_enc_id
 * @property string $applied_application_enc_id
 * @property string $interview_date_timing_enc_id
 * @property string $process_field_enc_id
 * @property int $status 0 as Not Sent, 1 as Pending, 2 as Accepted
 * @property int $is_deleted 0 as Deleted, 1 as Active
 *
 * @property ScheduledInterview $scheduledInterviewEnc
 * @property AppliedApplications $appliedApplicationEnc
 * @property InterviewDateTimings $interviewDateTimingEnc
 */
class InterviewCandidates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%interview_candidates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interview_candidate_enc_id', 'scheduled_interview_enc_id', 'applied_application_enc_id'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['interview_candidate_enc_id', 'scheduled_interview_enc_id', 'applied_application_enc_id', 'interview_date_timing_enc_id', 'process_field_enc_id'], 'string', 'max' => 100],
            [['interview_candidate_enc_id'], 'unique'],
            [['scheduled_interview_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduledInterview::className(), 'targetAttribute' => ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['interview_date_timing_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterviewDateTimings::className(), 'targetAttribute' => ['interview_date_timing_enc_id' => 'interview_date_timing_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledInterviewEnc()
    {
        return $this->hasOne(ScheduledInterview::className(), ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc()
    {
        return $this->hasOne(AppliedApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewDateTimingEnc()
    {
        return $this->hasOne(InterviewDateTimings::className(), ['interview_date_timing_enc_id' => 'interview_date_timing_enc_id']);
    }
}
