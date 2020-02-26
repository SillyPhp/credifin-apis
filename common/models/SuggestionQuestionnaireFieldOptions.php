<?php

namespace dsbedutech\models;

use Yii;

/**
 * This is the model class for table "{{%suggestion_questionnaire_field_options}}".
 *
 * @property int $id Primary Key
 * @property string $field_option_enc_id Field Option Encrypted ID
 * @property string $field_option Field Option
 * @property string $field_enc_id Foreign Key to Questionnaire Fields Table
 * @property string $created_on On which date Questionnaire Field Option information was added to database
 * @property string $created_by By which User Questionnaire Field Option information was added
 * @property string $last_updated_on On which date Questionnaire Field Option information was updated
 * @property string $last_updated_by By which User Questionnaire Field Option information was updated
 * @property int $is_deleted Is Questionnaire Field Option Deleted (0 As False, 1 As True)
 *
 * @property SuggestionQuestionnaireFields $createdBy
 */
class SuggestionQuestionnaireFieldOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suggestion_questionnaire_field_options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_option_enc_id', 'field_option', 'field_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['field_option_enc_id', 'field_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['field_option'], 'string', 'max' => 50],
            [['field_option_enc_id'], 'unique'],
            [['created_by', 'last_updated_by', 'field_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SuggestionQuestionnaireFields::className(), 'targetAttribute' => ['created_by' => 'user_enc_id', 'last_updated_by' => 'user_enc_id', 'field_enc_id' => 'field_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dsbedutech', 'ID'),
            'field_option_enc_id' => Yii::t('dsbedutech', 'Field Option Enc ID'),
            'field_option' => Yii::t('dsbedutech', 'Field Option'),
            'field_enc_id' => Yii::t('dsbedutech', 'Field Enc ID'),
            'created_on' => Yii::t('dsbedutech', 'Created On'),
            'created_by' => Yii::t('dsbedutech', 'Created By'),
            'last_updated_on' => Yii::t('dsbedutech', 'Last Updated On'),
            'last_updated_by' => Yii::t('dsbedutech', 'Last Updated By'),
            'is_deleted' => Yii::t('dsbedutech', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(SuggestionQuestionnaireFields::className(), ['user_enc_id' => 'last_updated_by', 'field_enc_id' => 'field_enc_id']);
    }
}
