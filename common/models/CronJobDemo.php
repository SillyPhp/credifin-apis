<?php

namespace common\models;



/**
 * This is the model class for table "{{%cron_job_demo}}".
 *
 * @property int $id Primary Key
 * @property string $test_enc_id
 * @property string $string
 */
class CronJobDemo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cron_job_demo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_enc_id', 'string'], 'required'],
            [['test_enc_id', 'string'], 'string', 'max' => 200],
            [['test_enc_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_enc_id' => 'Test Enc ID',
            'string' => 'String',
        ];
    }
}
