<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_tasks}}".
 *
 * @property int $id Primary Key
 * @property string $task_enc_id Task Encrypted ID
 * @property string $name Task Name
 * @property string $assigned_to Task Assigned To
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $status Task Status
 * @property int $is_completed Is Task Completed (0 as False & 1 as True)
 * @property int $is_deleted Is Task Deleted (0 as False & 1 as True)
 * @property string $created_on On which date Task information was added to database
 * @property string $created_by By which User Task information was added
 * @property string $last_updated_on On which date Task information was updated
 * @property string $last_updated_by By which User Task information was updated
 *
 * @property Users $assignedTo
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 */
class UserTasks extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_tasks}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['task_enc_id', 'name', 'created_on', 'created_by'], 'required'],
            [['status'], 'string'],
            [['is_completed', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['task_enc_id', 'name', 'assigned_to', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['task_enc_id'], 'unique'],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['assigned_to' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'assigned_to']);
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

}
