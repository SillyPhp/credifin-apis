<?php

namespace common\models;


/**
 * This is the model class for table "{{%suggestion_answered_questionnaire}}".
 *
 * @property int $id Primary Key
 * @property string $answered_questionnaire_enc_id Answered Questionnaire Encrypted ID
 * @property string $questionnaire_enc_id Foreign Key to Organization Questionnaire
 * @property string $created_on On which date Answer information was added to database
 * @property string $created_by By which User Answer information was added
 * @property string $last_updated_on On which date Answer information was updated
 * @property string $last_updated_by By which User Answer information was updated
 * @property int $is_deleted Is Answer Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property SuggestionQuestionnaire $questionnaireEnc
 */
class SuggestionAnsweredQuestionnaire extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suggestion_answered_questionnaire}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answered_questionnaire_enc_id', 'questionnaire_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['answered_questionnaire_enc_id', 'questionnaire_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['answered_questionnaire_enc_id'], 'unique'],
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
