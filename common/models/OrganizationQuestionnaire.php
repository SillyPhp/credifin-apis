<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_questionnaire}}".
 *
 * @property int $id Primary Key
 * @property string $questionnaire_enc_id Questionnaire Encrypted ID
 * @property string $questionnaire_name Questionnaire Name
 * @property string $questionnaire_for Questionnaire For (Jobs, Internships, Trainings)
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Questionnaire information was added to database
 * @property string $created_by By which User Questionnaire information was added
 * @property string $last_updated_on On which date Questionnaire information was updated
 * @property string $last_updated_by By which User Questionnaire information was updated
 * @property int $is_deleted Is Questionnaire Deleted (0 as False, 1 as True)
 *
 * @property EmployerApplications[] $employerApplications
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 * @property QuestionnaireFields[] $questionnaireFields
 */
class OrganizationQuestionnaire extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%organization_questionnaire}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['questionnaire_enc_id', 'questionnaire_name', 'questionnaire_for', 'organization_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['questionnaire_enc_id', 'questionnaire_name', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['questionnaire_for'], 'string', 'max' => 15],
            [['questionnaire_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['questionnaire_enc_id' => 'questionnaire_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc() {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireFields() {
        return $this->hasMany(QuestionnaireFields::className(), ['questionnaire_enc_id' => 'questionnaire_enc_id']);
    }

}
