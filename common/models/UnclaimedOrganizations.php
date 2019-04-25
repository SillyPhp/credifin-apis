<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%unclaimed_organizations}}".
 *
 * @property int $id
 * @property string $organization_enc_id unclaimed_organizations id
 * @property string $organization_type_enc_id organization type
 * @property string $name name of the organizations
 * @property string $logo
 * @property string $logo_location
 * @property string $slug slug for organizations
 * @property string $email email
 * @property string $website website of organizations
 * @property string $initials_color intials color for organizations
 * @property int $status
 * @property string $created_by user id
 * @property string $created_on date
 *
 * @property NewOrganizationReviews[] $newOrganizationReviews
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
            [['created_on'], 'safe'],
            [['organization_enc_id', 'organization_type_enc_id', 'name', 'logo', 'logo_location', 'slug', 'website', 'created_by'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['initials_color'], 'string', 'max' => 7],
            [['slug'], 'unique'],
            [['organization_enc_id'], 'unique'],
            [['email'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['organization_type_enc_id' => 'business_activity_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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
