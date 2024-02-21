<?php

namespace common\models;

/**
 * This is the model class for table "{{%suggestion_questionnaire}}".
 *
 * @property int $id Primary Key
 * @property string $questionnaire_enc_id Questionnaire Encrypted ID
 * @property string $questionnaire_name Questionnaire Name
 * @property string $group_enc_id Questionnaire Group
 * @property string $created_on On which date Questionnaire information was added to database
 * @property string $created_by By which User Questionnaire information was added
 * @property string $last_updated_on On which date Questionnaire information was updated
 * @property string $last_updated_by By which User Questionnaire information was updated
 * @property int $is_deleted Is Questionnaire Deleted (0 as False, 1 as True)
 *
 * @property SuggestionGroup $groupEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property SuggestionQuestionnaireFields[] $suggestionQuestionnaireFields
 */
class SuggestionQuestionnaire extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suggestion_questionnaire}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['questionnaire_enc_id', 'questionnaire_name', 'group_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['questionnaire_enc_id', 'questionnaire_name', 'group_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['questionnaire_enc_id'], 'unique'],
            [['group_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SuggestionGroup::className(), 'targetAttribute' => ['group_enc_id' => 'group_enc_id']],
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
    public function getGroupEnc()
    {
        return $this->hasOne(SuggestionGroup::className(), ['group_enc_id' => 'group_enc_id']);
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
    public function getSuggestionQuestionnaireFields()
    {
        return $this->hasMany(SuggestionQuestionnaireFields::className(), ['questionnaire_enc_id' => 'questionnaire_enc_id']);
    }
}
