<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_supervisor}}".
 *
 * @property int $id
 * @property string $assigned_enc_id
 * @property string $supervisor_enc_id Foreign Key to Users Table
 * @property string $assigned_organization_enc_id Foreign Key to Organizations Table
 * @property string $assigned_user_enc_id Foreign Key to Users Table
 * @property int $is_supervising 0 as false, 1 as true
 * @property string $supervisor_role
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Users $supervisorEnc
 * @property Users $assignedUserEnc
 * @property Organizations $assignedOrganizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class AssignedSupervisor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_supervisor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_enc_id', 'supervisor_enc_id', 'supervisor_role', 'created_on', 'created_by'], 'required'],
            [['is_supervising'], 'integer'],
            [['supervisor_role'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['assigned_enc_id', 'supervisor_enc_id', 'assigned_organization_enc_id', 'assigned_user_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_enc_id'], 'unique'],
            [['supervisor_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['supervisor_enc_id' => 'user_enc_id']],
            [['assigned_user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['assigned_user_enc_id' => 'user_enc_id']],
            [['assigned_organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['assigned_organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisorEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'supervisor_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'assigned_user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'assigned_organization_enc_id']);
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
