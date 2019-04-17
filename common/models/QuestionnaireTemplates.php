<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%questionnaire_templates}}".
 *
 * @property int $id Primary Key
 * @property string $questionnaire_enc_id Questionnaire Encrypted ID
 * @property string $questionnaire_name Questionnaire Name
 * @property string $questionnaire_for Questionnaire For (Jobs, Internships, Trainings)
 * @property string $created_on On which date Questionnaire information was added to database
 * @property string $created_by By which User Questionnaire information was added
 * @property string $last_updated_on On which date Questionnaire information was updated
 * @property string $last_updated_by By which User Questionnaire information was updated
 * @property int $status Questionnaire Template Status (0 as Pending, 1 as Approved)
 * @property int $is_deleted Is Questionnaire Deleted (0 as False, 1 as True)
 *
 * @property BookmarkedQuestionnaireTemplates[] $bookmarkedQuestionnaireTemplates
 * @property Organizations[] $organizationEncs
 * @property QuestionnaireTemplateFields[] $questionnaireTemplateFields
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class QuestionnaireTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%questionnaire_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['questionnaire_enc_id', 'questionnaire_name', 'questionnaire_for', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['questionnaire_enc_id', 'questionnaire_name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['questionnaire_for'], 'string', 'max' => 15],
            [['questionnaire_enc_id'], 'unique'],
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
    public function getBookmarkedQuestionnaireTemplates()
    {
        return $this->hasMany(BookmarkedQuestionnaireTemplates::className(), ['questionnnaire_enc_id' => 'questionnaire_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEncs()
    {
        return $this->hasMany(Organizations::className(), ['organization_enc_id' => 'organization_enc_id'])->viaTable('{{%bookmarked_questionnaire_templates}}', ['questionnnaire_enc_id' => 'questionnaire_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireTemplateFields()
    {
        return $this->hasMany(QuestionnaireTemplateFields::className(), ['questionnaire_enc_id' => 'questionnaire_enc_id']);
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
