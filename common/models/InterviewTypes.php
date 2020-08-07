<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%interview_types}}".
 *
 * @property int $id
 * @property string $interview_type_enc_id
 * @property string $name
 */
class InterviewTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%interview_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interview_type_enc_id', 'name'], 'required'],
            [['interview_type_enc_id', 'name'], 'string', 'max' => 100],
        ];
    }

}
