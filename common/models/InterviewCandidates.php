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
 * @property int $status 0 as Not Sent, 1 as Pending, 2 as Accepted
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
            [['status'], 'integer'],
            [['interview_candidate_enc_id', 'scheduled_interview_enc_id', 'applied_application_enc_id'], 'string', 'max' => 100],
        ];
    }

}
