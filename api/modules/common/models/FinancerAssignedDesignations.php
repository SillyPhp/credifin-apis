<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_assigned_designations}}".
 *
 * @property int $id
 * @property string $assigned_designation_enc_id
 * @property string $designation
 * @property string $organization_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted
 *
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class FinancerAssignedDesignations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_assigned_designations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_designation_enc_id', 'designation', 'organization_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_designation_enc_id', 'designation', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_designation_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assigned_designation_enc_id' => 'Assigned Designation Enc ID',
            'designation' => 'Designation',
            'organization_enc_id' => 'Organization Enc ID',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'last_updated_on' => 'Last Updated On',
            'last_updated_by' => 'Last Updated By',
            'is_deleted' => 'Is Deleted',
        ];
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
