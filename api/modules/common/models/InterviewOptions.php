<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%interview_options}}".
 *
 * @property int $id
 * @property string $interview_options_enc_id
 * @property string $scheduled_interview_enc_id
 * @property string $process_field_enc_id
 * @property int $interview_duration duration in minutes per cnadidate
 * @property int $interview_rooms interview rooms per interview
 * @property int $number_of_candidates
 * @property int $interviewer_required 0 just notify, 1 request for acceptance
 * @property int $is_deleted 0 as Deleted, 1 as Active
 *
 * @property ScheduledInterview $scheduledInterviewEnc
 * @property InterviewProcessFields $processFieldEnc
 */
class InterviewOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%interview_options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interview_options_enc_id', 'scheduled_interview_enc_id'], 'required'],
            [['interview_duration', 'interview_rooms', 'number_of_candidates', 'interviewer_required', 'is_deleted'], 'integer'],
            [['interview_options_enc_id', 'scheduled_interview_enc_id', 'process_field_enc_id'], 'string', 'max' => 100],
            [['interview_options_enc_id'], 'unique'],
            [['scheduled_interview_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduledInterview::className(), 'targetAttribute' => ['scheduled_interview_enc_id' => 'scheduled_interview_enc_id']],
            [['process_field_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterviewProcessFields::className(), 'targetAttribute' => ['process_field_enc_id' => 'field_enc_id']],
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
    public function getProcessFieldEnc()
    {
        return $this->hasOne(InterviewProcessFields::className(), ['field_enc_id' => 'process_field_enc_id']);
    }
}
