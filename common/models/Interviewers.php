<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%interviewers}}".
 *
 * @property int $id
 * @property string $interviewer_enc_id
 * @property string $scheduled_interview_enc_id
 * @property int $status 1 as Pending, 2 as Accepted
 *
 * @property InterviewerDetail[] $interviewerDetails
 * @property ScheduledInterview $scheduledInterviewEnc
 */
class Interviewers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%interviewers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interviewer_enc_id', 'scheduled_interview_enc_id'], 'required'],
            [['status'], 'integer'],
            [['interviewer_enc_id', 'scheduled_interview_enc_id'], 'string', 'max' => 100],
            [['interviewer_enc_id'], 'unique'],
            [['scheduled_interview_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduledInterview::className(), 'targetAttribute' => ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewerDetails()
    {
        return $this->hasMany(InterviewerDetail::className(), ['interviewer_enc_id' => 'interviewer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledInterviewEnc()
    {
        return $this->hasOne(ScheduledInterview::className(), ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']);
    }
}
