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
 * @property int $number_of_candidates
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
            [['number_of_candidates'], 'integer'],
            [['interview_options_enc_id', 'scheduled_interview_enc_id', 'process_field_enc_id'], 'string', 'max' => 100],
        ];
    }
}
