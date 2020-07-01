<?php

namespace common\models;

/**
 * This is the model class for table "{{%suggestion_group}}".
 *
 * @property int $id Primary Key
 * @property string $group_enc_id Questionnaire Group
 * @property string $group_name Questionnaire Name
 * @property string $created_on On which date Questionnaire information was added to database
 * @property string $created_by By which User Questionnaire information was added
 * @property string $last_updated_on On which date Questionnaire information was updated
 * @property string $last_updated_by By which User Questionnaire information was updated
 * @property int $is_deleted Is Questionnaire Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property SuggestionQuestionnaire[] $suggestionQuestionnaires
 */
class SuggestionGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suggestion_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_enc_id', 'group_name', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['group_enc_id', 'group_name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['group_enc_id'], 'unique'],
            [['group_name'], 'unique'],
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
    public function getSuggestionQuestionnaires()
    {
        return $this->hasMany(SuggestionQuestionnaire::className(), ['group_enc_id' => 'group_enc_id']);
    }
}
