<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_other_details}}".
 *
 * @property int $id
 * @property string $organization_other_details_enc_id
 * @property string $organization_enc_id Organization enc id
 * @property string $location_enc_id location enc id
 * @property string $affiliated_to university name
 *
 * @property Organizations $organizationEnc
 * @property Cities $locationEnc
 */
class OrganizationOtherDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_other_details}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_other_details_enc_id', 'organization_enc_id'], 'required'],
            [['organization_other_details_enc_id', 'organization_enc_id', 'location_enc_id', 'affiliated_to'], 'string', 'max' => 100],
            [['organization_other_details_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['location_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['location_enc_id' => 'city_enc_id']],
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
    public function getLocationEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'location_enc_id']);
    }
}
