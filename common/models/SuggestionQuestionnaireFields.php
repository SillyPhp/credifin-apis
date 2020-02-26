<?php

namespace common\models;
/**
 * This is the model class for table "{{%suggestion_questionnaire_fields}}".
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
 * @property string $questionnaire_enc_id Foreign Key to Organization Questionnaire
 * @property string $created_on On which date Questionnaire Field information was added to database
 * @property string $created_by By which User Questionnaire Field information was added
 * @property string $last_updated_on On which date Questionnaire Field information was updated
 * @property string $last_updated_by By which User Questionnaire Field information was updated
 * @property int $is_deleted Is Questionnaire Field Deleted (0 As False, 1 As True)
 *
 * @property SuggestionQuestionnaireFieldOptions[] $suggestionQuestionnaireFieldOptions
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property SuggestionQuestionnaire $questionnaireEnc
 */
class SuggestionQuestionnaireFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suggestion_questionnaire_fields}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_enc_id', 'field_name', 'field_label', 'field_type', 'questionnaire_enc_id', 'created_by'], 'required'],
            [['field_type'], 'string'],
            [['sequence', 'is_required', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['field_enc_id', 'field_name', 'field_label', 'field_class', 'placeholder', 'icon', 'icon_location', 'questionnaire_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['help_text', 'option_display_array', 'html_code'], 'string', 'max' => 500],
            [['field_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['questionnaire_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SuggestionQuestionnaire::className(), 'targetAttribute' => ['questionnaire_enc_id' => 'questionnaire_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuggestionQuestionnaireFieldOptions()
    {
        return $this->hasMany(SuggestionQuestionnaireFieldOptions::className(), ['created_by' => 'user_enc_id', 'last_updated_by' => 'user_enc_id', 'field_enc_id' => 'field_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireEnc()
    {
        return $this->hasOne(SuggestionQuestionnaire::className(), ['questionnaire_enc_id' => 'questionnaire_enc_id']);
    }
}
