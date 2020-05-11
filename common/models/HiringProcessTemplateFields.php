<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%hiring_process_template_fields}}".
 *
 * @property int $id Primary Key
 * @property string $field_enc_id Field Encrypted ID
 * @property string $field_name Field Name
 * @property string $field_label Field Label
 * @property string $field_class Field Class
 * @property string $placeholder Field Placeholder
 * @property string $icon Field Icon
 * @property string $icon_location Location of the Icon
 * @property string $help_text Help Text
 * @property string $field_type Type of field
 * @property string $option_display_array Field Options
 * @property string $html_code HTML Code
 * @property int $sequence Field Display Sequence
 * @property int $is_required Is Field Required (0 As No, 1 As Yes)
 * @property string $hiring_process_enc_id Foreign Key to Hiring Process Templates Table
 * @property string $created_on On which date Field information was added to database
 * @property string $created_by By which User Field information was added
 * @property string $last_updated_on On which date Field information was updated
 * @property string $last_updated_by By which User Field information was updated
 * @property int $is_deleted Is Field Deleted (0 As False, 1 As True)
 *
 * @property HiringProcessTemplates $hiringProcessEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class HiringProcessTemplateFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hiring_process_template_fields}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_enc_id', 'field_name', 'field_label', 'hiring_process_enc_id', 'created_by'], 'required'],
            [['field_type'], 'string'],
            [['sequence', 'is_required', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['field_enc_id', 'field_name', 'field_label', 'field_class', 'placeholder', 'icon', 'icon_location', 'hiring_process_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['help_text', 'option_display_array', 'html_code'], 'string', 'max' => 500],
            [['field_enc_id'], 'unique'],
            [['hiring_process_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => HiringProcessTemplates::className(), 'targetAttribute' => ['hiring_process_enc_id' => 'hiring_process_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHiringProcessEnc()
    {
        return $this->hasOne(HiringProcessTemplates::className(), ['hiring_process_enc_id' => 'hiring_process_enc_id']);
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }
}
