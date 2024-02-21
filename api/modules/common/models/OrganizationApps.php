<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_apps}}".
 *
 * @property int $id
 * @property string $app_enc_id app encrypted id
 * @property string $organization_enc_id organization id who created
 * @property string $app_name app name
 * @property string $app_description app description
 * @property string $app_icon app icon
 * @property string $app_icon_location icon location
 * @property string $assigned_to assigned user for this app
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property OrganizationAppFields[] $organizationAppFields
 * @property OrganizationAppUsers[] $organizationAppUsers
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class OrganizationApps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_apps}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_enc_id', 'organization_enc_id', 'app_name', 'assigned_to', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['app_enc_id', 'organization_enc_id', 'app_icon', 'app_icon_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['app_name'], 'string', 'max' => 150],
            [['app_description'], 'string', 'max' => 250],
            [['assigned_to'], 'string', 'max' => 50],
            [['app_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationAppFields()
    {
        return $this->hasMany(OrganizationAppFields::className(), ['app_enc_id' => 'app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationAppUsers()
    {
        return $this->hasMany(OrganizationAppUsers::className(), ['app_enc_id' => 'app_enc_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
