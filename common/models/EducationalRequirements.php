<?php

namespace common\models;

/**
 * This is the model class for table "{{%educational_requirements}}".
 *
 * @property int $id Primary Key
 * @property string $educational_requirement_enc_id Educational Requirement Encrypted ID
 * @property string $educational_requirement Educational Requirement
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Educational Requirement information was added to database
 * @property string $created_by By which User Educational Requirement information was added
 * @property string $last_updated_on On which date Educational Requirement information was updated
 * @property string $last_updated_by By which User Educational Requirement information was updated
 * @property string $status Educational Requirement Status (Publish, Pending)
 * @property int $is_deleted Is Educational Requirement Deleted (0 As False, 1 As True)
 *
 * @property ApplicationEducationalRequirements[] $applicationEducationalRequirements
 * @property AssignedEducationalRequirements[] $assignedEducationalRequirements
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class EducationalRequirements extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%educational_requirements}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['educational_requirement_enc_id', 'educational_requirement', 'created_on', 'created_by'], 'required'],
            [['educational_requirement', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['educational_requirement_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['educational_requirement_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEducationalRequirements() {
        return $this->hasMany(ApplicationEducationalRequirements::className(), ['educational_requirement_enc_id' => 'educational_requirement_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedEducationalRequirements() {
        return $this->hasMany(AssignedEducationalRequirements::className(), ['educational_requirement_enc_id' => 'educational_requirement_enc_id']);
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
