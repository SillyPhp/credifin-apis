<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%test_data}}".
 *
 * @property int $id Primary Id
 * @property string $application_number Loan Account Number
 * @property string $old_application_number
 * @property string $created_on Created On
 */
class TestData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_number'], 'required'],
            [['created_on'], 'safe'],
            [['application_number', 'old_application_number'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_number' => 'Application Number',
            'old_application_number' => 'Old Application Number',
            'created_on' => 'Created On',
        ];
    }
}
