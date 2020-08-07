<?php

namespace common\models;

/**
 * This is the model class for table "{{%suggested_answered_questionnaire_fields}}".
 *
 * @property int $id Primary Key
 * @property string $answer_enc_id Answer Encrypted ID
 * @property string $answered_questionnaire_enc_id Foreign Key to Answered Questionnaire
 * @property string $field_enc_id Foreign Key to Questionnaire Fields Table
 * @property string $field_option_enc_id Foreign Key to Field Options Table
 * @property string $answer Field Answer
 * @property string $created_on On which date Field Answer information was added to database
 * @property string $created_by By which User Field Answer information was added
 * @property string $last_updated_on On which date Field Answer information was updated
 * @property string $last_updated_by By which User Field Answer information was updated
 * @property int $is_deleted Is Field Answer Deleted (0 As False, 1 As True)
 *
 * @property SuggestionQuestionnaireFieldOptions $createdBy
 */
class SuggestedAnsweredQuestionnaireFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suggested_answered_questionnaire_fields}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_enc_id', 'answered_questionnaire_enc_id', 'field_enc_id', 'created_on', 'created_by'], 'required'],
            [['answer'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['answer_enc_id', 'answered_questionnaire_enc_id', 'field_enc_id', 'field_option_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['answer_enc_id'], 'unique'],
            [['created_by', 'last_updated_by', 'field_enc_id', 'field_option_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SuggestionQuestionnaireFieldOptions::className(), 'targetAttribute' => ['created_by' => 'user_enc_id', 'last_updated_by' => 'user_enc_id', 'field_enc_id' => 'field_enc_id', 'field_option_enc_id' => 'field_option_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(SuggestionQuestionnaireFieldOptions::className(), ['user_enc_id' => 'last_updated_by', 'field_enc_id' => 'field_enc_id', 'field_option_enc_id' => 'field_option_enc_id']);
    }
}
