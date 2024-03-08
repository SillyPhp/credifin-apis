<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%bookmarked_questionnaire_templates}}".
 *
 * @property int $id Primary Key
 * @property string $bookmared_enc_id Bookmarked Encrypted ID
 * @property string $questionnnaire_enc_id Foreign Key to Questionnaire Templates Table
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property int $is_bookmared Bookmark Status (0 as Not Bookmarked, 1 as Bookmarked)
 * @property string $created_on On which date Questionnaire Template information was added to database
 * @property string $created_by By which User Questionnaire Template information was added
 * @property string $last_updated_on On which date Questionnaire Template information was updated
 * @property string $last_updated_by By which User Questionnaire Template information was updated
 *
 * @property QuestionnaireTemplates $questionnnaireEnc
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class BookmarkedQuestionnaireTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bookmarked_questionnaire_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bookmared_enc_id', 'questionnnaire_enc_id', 'organization_enc_id', 'created_by'], 'required'],
            [['is_bookmared'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['bookmared_enc_id', 'questionnnaire_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['bookmared_enc_id'], 'unique'],
            [['questionnnaire_enc_id', 'organization_enc_id'], 'unique', 'targetAttribute' => ['questionnnaire_enc_id', 'organization_enc_id']],
            [['questionnnaire_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionnaireTemplates::className(), 'targetAttribute' => ['questionnnaire_enc_id' => 'questionnaire_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
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
    public function getQuestionnnaireEnc()
    {
        return $this->hasOne(QuestionnaireTemplates::className(), ['questionnaire_enc_id' => 'questionnnaire_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
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
