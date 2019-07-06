<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%interview_date_timings}}".
 *
 * @property int $id
 * @property string $interview_date_timing_enc_id
 * @property string $interview_dates_enc_id
 * @property string $from
 * @property string $to
 * @property int $is_deleted 0 as Deleted, 1 as Active
 */
class InterviewDateTimings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%interview_date_timings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interview_date_timing_enc_id', 'interview_dates_enc_id', 'from', 'to'], 'required'],
            [['from', 'to'], 'safe'],
            [['is_deleted'], 'integer'],
            [['interview_date_timing_enc_id', 'interview_dates_enc_id'], 'string', 'max' => 100],
        ];
    }

}
