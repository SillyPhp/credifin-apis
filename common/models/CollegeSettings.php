<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_settings}}".
 *
 * @property int $id
 * @property string $college_settings_enc_id encrypted id
 * @property string $college_enc_id college encrypted id
 * @property string $setting_enc_id setting encrypted id
 * @property int $value 1 manual,2 auto
 * @property string $created_by created by user id
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property Organizations $collegeEnc
 * @property ErexxSettings $settingEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class CollegeSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%college_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['college_settings_enc_id', 'college_enc_id', 'setting_enc_id', 'created_by'], 'required'],
            [['value'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['college_settings_enc_id', 'college_enc_id', 'setting_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['college_settings_enc_id'], 'unique'],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['setting_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ErexxSettings::className(), 'targetAttribute' => ['setting_enc_id' => 'setting_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingEnc()
    {
        return $this->hasOne(ErexxSettings::className(), ['setting_enc_id' => 'setting_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
