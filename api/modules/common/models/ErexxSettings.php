<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%erexx_settings}}".
 *
 * @property int $id
 * @property string $setting_enc_id
 * @property string $title
 * @property string $setting
 * @property string $status
 *
 * @property CollegeSettings[] $collegeSettings
 */
class ErexxSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%erexx_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_enc_id', 'title', 'setting'], 'required'],
            [['status'], 'string'],
            [['setting_enc_id'], 'string', 'max' => 100],
            [['title', 'setting'], 'string', 'max' => 50],
            [['setting_enc_id'], 'unique'],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeSettings()
    {
        return $this->hasMany(CollegeSettings::className(), ['setting_enc_id' => 'setting_enc_id']);
    }
}
