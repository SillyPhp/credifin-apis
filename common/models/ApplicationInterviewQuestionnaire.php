<?php

namespace common\models;

/**
 * This is the model class for table "{{%application_interview_questionnaire}}".
 *
 * @property int $id Primary Key
 * @property string $interview_questionnaire_enc_id Interview Questionnaire Encrypted ID
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property string $field_enc_id Foreign Key to Interview Process Fields Table
 * @property string $questionnaire_enc_id Foreign Key to Organization Questionnaire Table
 * @property string $created_on On which date Application Interview Questionnaire information was added to database
 * @property string $created_by By which User Application Interview Questionnaire information was added
 * @property string $last_updated_on On which date Application Interview Questionnaire information was updated
 * @property string $last_updated_by By which User Application Interview Questionnaire information was updated
 * @property int $is_deleted Is Application Interview Questionnaire Deleted (0 As False, 1 As True)
 *
 * @property EmployerApplications $applicationEnc
 * @property InterviewProcessFields $fieldEnc
 * @property OrganizationQuestionnaire $questionnaireEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationInterviewQuestionnaire extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_interview_questionnaire}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['interview_questionnaire_enc_id', 'application_enc_id', 'field_enc_id', 'questionnaire_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['interview_questionnaire_enc_id', 'application_enc_id', 'field_enc_id', 'questionnaire_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['interview_questionnaire_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['field_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterviewProcessFields::className(), 'targetAttribute' => ['field_enc_id' => 'field_enc_id']],
            [['questionnaire_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationQuestionnaire::className(), 'targetAttribute' => ['questionnaire_enc_id' => 'questionnaire_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc() {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldEnc() {
        return $this->hasOne(InterviewProcessFields::className(), ['field_enc_id' => 'field_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaireEnc() {
        return $this->hasOne(OrganizationQuestionnaire::className(), ['questionnaire_enc_id' => 'questionnaire_enc_id']);
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

}
