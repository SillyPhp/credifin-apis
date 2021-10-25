<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%claim_serviceable_locations}}".
 *
 * @property int $id Primary Key
 * @property string $service_location_enc_id
 * @property string $organization_enc_id Foreign Key to OrganizationsTable
 * @property string $state_enc_id Foreign Key  of States
 * @property string $city_enc_id Foreign Key to  Cities
 * @property string $unclaim_college_enc_id Foreign Key  of Unclaimed_Organizations
 * @property string $claim_college_enc_id Foreign Key  of Organizations
 * @property string $type Type of service location
 * @property string $created_on
 * @property string $created_by By which User Industry information was added
 * @property string $last_updated_on On which date Industry information was updated
 * @property string $last_updated_by By which User Industry information was updated
 *
 * @property Organizations $organizationEnc
 * @property States $stateEnc
 * @property Cities $cityEnc
 * @property Organizations $claimCollegeEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ClaimServiceableLocations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%claim_serviceable_locations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_location_enc_id', 'organization_enc_id', 'type', 'created_by'], 'required'],
            [['type'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['service_location_enc_id', 'organization_enc_id', 'city_enc_id', 'unclaim_college_enc_id', 'claim_college_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['state_enc_id'], 'string', 'max' => 200],
            [['service_location_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['state_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_enc_id' => 'state_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['claim_college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['claim_college_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getStateEnc()
    {
        return $this->hasOne(States::className(), ['state_enc_id' => 'state_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'claim_college_enc_id']);
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
