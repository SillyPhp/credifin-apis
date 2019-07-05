<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%interviewers}}".
 *
 * @property int $id
 * @property string $interviewers_enc_id
 * @property string $scheduled_interview_enc_id
 * @property int $status 1 as Pending, 2 as Accepted
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
            [['interviewers_enc_id', 'scheduled_interview_enc_id'], 'required'],
            [['status'], 'integer'],
            [['interviewers_enc_id', 'scheduled_interview_enc_id'], 'string', 'max' => 100],
        ];
    }
}
