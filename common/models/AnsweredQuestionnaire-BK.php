<?php

namespace common\models;

/**
 * This is the model class for table "{{%answered_questionnaire}}".
 *
 * @property int $id Primary Key
 * @property string $answered_questionnaire_enc_id Answered Questionnaire Encrypted ID
 * @property string $applied_application_enc_id Foreign Key to Applied Applications Table
 * @property string $questionnaire_enc_id Foreign Key to Organization Questionnaire
 * @property string $created_on On which date Answer information was added to database
 * @property string $created_by By which User Answer information was added
 * @property string $last_updated_on On which date Answer information was updated
 * @property string $last_updated_by By which User Answer information was updated
 * @property int $is_deleted Is Answer Deleted (0 as False, 1 as True)
 *
 * @property AppliedApplications $appliedApplicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property OrganizationQuestionnaire $questionnaireEnc
 * @property AnsweredQuestionnaireFields[] $answeredQuestionnaireFields
 */
class AnsweredQuestionnaire extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%answered_questionnaire}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['answered_questionnaire_enc_id', 'applied_application_enc_id', 'questionnaire_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['answered_questionnaire_enc_id', 'applied_application_enc_id', 'questionnaire_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['answered_questionnaire_enc_id'], 'unique'],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['questionnaire_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationQuestionnaire::className(), 'targetAttribute' => ['questionnaire_enc_id' => 'questionnaire_enc_id']],
        ];
    }
    
//    public function fields(){
//        return [
//            //Let's assume you need these 3 fields instead of all the fields
//            //you select the fields you want here
//            'answered_questionnaire_enc_id', 
//           'applied_application_enc_id', 
//            'questionnaire_enc_id',
//            'answeredQuestionnaireFields'
//            /*'answeredQuestionnaireFields'=>function(){
//            return [
//                'answeredQuestionnaireFields'=>$this->answeredQuestionnaireFields,
//                'fieldEnc'=>$this->answeredQuestionnaireFields->fieldEnc
//                    ];
//            }*/
//        ];
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc() {
        return $this->hasOne(AppliedApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
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
    public function getQuestionnaireEnc() {
        return $this->hasOne(OrganizationQuestionnaire::className(), ['questionnaire_enc_id' => 'questionnaire_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnsweredQuestionnaireFields() {
        return $this->hasMany(AnsweredQuestionnaireFields::className(), ['answered_questionnaire_enc_id' => 'answered_questionnaire_enc_id']);
    }

}
