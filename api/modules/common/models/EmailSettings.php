<?php

namespace common\models;

/**
 * This is the model class for table "{{%email_settings}}".
 *
 * @property int $id
 * @property string $email_settings_enc_id
 * @property string $user_enc_id
 * @property string $organization_enc_id
 * @property int $email_category 0 as Jobs, 1 as Internships, 2 as Both
 * @property int $frequency 0 as daily, 1 as weekly, 2 as off
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 */
class EmailSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_settings_enc_id', 'user_enc_id', 'email_category', 'frequency', 'created_by'], 'required'],
            [['email_category', 'frequency'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['email_settings_enc_id', 'user_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
        ];
    }
}
