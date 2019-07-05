<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%interview_dates}}".
 *
 * @property int $id
 * @property string $interview_dates_enc_id
 * @property string $scheduled_interview_enc_id
 * @property string $interview_date
 * @property int $is_deleted 0 as Deleted, 1 as Active
 */
class InterviewDates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%interview_dates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'interview_dates_enc_id', 'scheduled_interview_enc_id', 'interview_date'], 'required'],
            [['id', 'is_deleted'], 'integer'],
            [['interview_date'], 'safe'],
            [['interview_dates_enc_id', 'scheduled_interview_enc_id'], 'string', 'max' => 100],
        ];
    }
}
