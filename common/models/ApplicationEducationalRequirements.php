<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%application_educational_requirements}}".
 *
 * @property int $id Primary Key
 * @property string $application_educational_requirement_enc_id Application Educational Requirement Encrypted ID
 * @property string $educational_requirement_enc_id Foreign Key to Educational Requirements Table
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property string $created_on On which date Application Educational Requirement information was added to database
 * @property string $created_by By which User Application Educational Requirement information was added
 * @property string $last_updated_on On which date Application Educational Requirement information was updated
 * @property string $last_updated_by By which User Application Educational Requirement information was updated
 * @property int $is_deleted Is Application Educational Requirement Deleted (0 As False, 1 As True)
 *
 * @property EducationalRequirements $educationalRequirementEnc
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationEducationalRequirements extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_educational_requirements}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['application_educational_requirement_enc_id', 'educational_requirement_enc_id', 'application_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['application_educational_requirement_enc_id', 'educational_requirement_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_educational_requirement_enc_id'], 'unique'],
            [['educational_requirement_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationalRequirements::className(), 'targetAttribute' => ['educational_requirement_enc_id' => 'educational_requirement_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalRequirementEnc() {
        return $this->hasOne(EducationalRequirements::className(), ['educational_requirement_enc_id' => 'educational_requirement_enc_id']);
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
