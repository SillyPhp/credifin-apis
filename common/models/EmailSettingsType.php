<?php

namespace common\models;

/**
 * This is the model class for table "{{%email_settings_type}}".
 *
 * @property int $id
 * @property string $email_settings_type_enc_id
 * @property string $email_settings_enc_id
 * @property string $email_type_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 */
class EmailSettingsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_settings_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_settings_type_enc_id', 'email_settings_enc_id', 'email_type_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['email_settings_type_enc_id', 'email_settings_enc_id', 'email_type_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
        ];
    }
}
