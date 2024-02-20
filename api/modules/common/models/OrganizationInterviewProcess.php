<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_interview_process}}".
 *
 * @property int $id Primary Key
 * @property string $interview_process_enc_id Interview Process Encrypted ID
 * @property string $process_name Interview Process Name
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Interview Process information was added to database
 * @property string $created_by By which User Interview Process information was added
 * @property string $last_updated_on On which date Interview Process information was updated
 * @property string $last_updated_by By which User Interview Process information was updated
 * @property int $is_deleted Is Interview Process Deleted (0 as False, 1 as True)
 *
 * @property EmployerApplications[] $employerApplications
 * @property InterviewProcessFields[] $interviewProcessFields
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class OrganizationInterviewProcess extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%organization_interview_process}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['interview_process_enc_id', 'process_name', 'organization_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['interview_process_enc_id', 'process_name', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['interview_process_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['interview_process_enc_id' => 'interview_process_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewProcessFields() {
        return $this->hasMany(InterviewProcessFields::className(), ['interview_process_enc_id' => 'interview_process_enc_id']);
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
