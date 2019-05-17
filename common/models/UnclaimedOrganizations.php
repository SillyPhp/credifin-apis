<?php

namespace common\models;

/**
 * This is the model class for table "{{%unclaimed_organizations}}".
 *
 * @property int $id Primary Key
 * @property string $organization_enc_id Organization Encrypted ID
 * @property string $organization_type_enc_id Foreign Key to Business Activities Table
 * @property string $name Organization Name
 * @property string $logo Organization Logo
 * @property string $logo_location Location of the Logo
 * @property string $slug Organization Slug
 * @property string $email Organization Email
 * @property string $website Organization Website
 * @property string $initials_color Intials Color
 * @property int $status Organization Status (Active, Inactive, Pending)
 * @property int $status Organization Status (1 Active, 0 Inactive, 2 Pending)
 * @property int $is_deleted 1 as false and 0 for true
 * @property string $created_by By which User Organization information was added
 * @property string $created_on On which date Organization information was added to database
 *
 * @property NewOrganizationReviews[] $newOrganizationReviews
 * @property UnclaimedFollowedOrganizations[] $unclaimedFollowedOrganizations
 * @property Users[] $userEncs
 * @property Users $createdBy
 * @property BusinessActivities $organizationTypeEnc
 */
class UnclaimedOrganizations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unclaimed_organizations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_enc_id', 'name', 'slug', 'initials_color', 'created_by'], 'required'],
            [['status'], 'integer'],
            [['status', 'is_deleted'], 'integer'],
            [['created_on'], 'safe'],
            [['organization_enc_id', 'organization_type_enc_id', 'name', 'logo', 'logo_location', 'slug', 'website', 'created_by'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['initials_color'], 'string', 'max' => 7],
            [['slug'], 'unique'],
            [['organization_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['organization_type_enc_id' => 'business_activity_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewOrganizationReviews()
    {
        return $this->hasMany(NewOrganizationReviews::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedFollowedOrganizations()
    {
        return $this->hasMany(UnclaimedFollowedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEncs()
    {
        return $this->hasMany(Users::className(), ['user_enc_id' => 'user_enc_id'])->viaTable('{{%unclaimed_followed_organizations}}', ['organization_enc_id' => 'organization_enc_id']);
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
    public function getOrganizationTypeEnc()
    {
        return $this->hasOne(BusinessActivities::className(), ['business_activity_enc_id' => 'organization_type_enc_id']);
    }
}
