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
        ];
    }

}
