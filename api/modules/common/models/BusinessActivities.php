<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%business_activities}}".
 *
 * @property int $id Primary Key
 * @property string $business_activity_enc_id Business Activity Encrypted ID
 * @property string $business_activity Business Activity Name
 * @property string $icon_svg Icon in svg
 * @property string $icon_png Icon in png
 *
 * @property AssignedIndustries[] $assignedIndustries
 * @property Organizations[] $organizations
 * @property UnclaimedOrganizations[] $unclaimedOrganizations
 */
class BusinessActivities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%business_activities}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_activity_enc_id', 'business_activity'], 'required'],
            [['business_activity_enc_id'], 'string', 'max' => 100],
            [['business_activity'], 'string', 'max' => 30],
            [['icon_svg', 'icon_png'], 'string', 'max' => 50],
            [['business_activity_enc_id'], 'unique'],
            [['business_activity'], 'unique'],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedIndustries()
    {
        return $this->hasMany(AssignedIndustries::className(), ['business_activity_enc_id' => 'business_activity_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organizations::className(), ['business_activity_enc_id' => 'business_activity_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedOrganizations()
    {
        return $this->hasMany(UnclaimedOrganizations::className(), ['organization_type_enc_id' => 'business_activity_enc_id']);
    }
}