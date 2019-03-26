<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_locations}}".
 *
 * @property int $id Primary Key
 * @property string $location_enc_id Location Encrypted ID
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $location_name Location Name
 * @property string $location_for Location For (Office, Interview)
 * @property string $email Location Email
 * @property string $description Location Description
 * @property string $website Location Website
 * @property string $phone Contact Number
 * @property string $address Location Address
 * @property string $postal_code Postal Code
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property double $latitude Location Latitude
 * @property double $longitude Location Longitude
 * @property int $sequence Location Display Sequence
 * @property string $created_on On which date Organization Location information was added to database
 * @property string $created_by By which User Organization Location information was added
 * @property string $last_updated_on On which date Organization Location information was updated
 * @property string $last_updated_by By which User Organization Location information was updated
 * @property string $status Organization Location Status (Active, Inactive, Pending)
 * @property int $is_deleted Is Organization Location Deleted (0 as False, 1 as True)
 *
 * @property ApplicationInterviewLocations[] $applicationInterviewLocations
 * @property ApplicationPlacementLocations[] $applicationPlacementLocations
 * @property Cities $cityEnc
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class OrganizationLocations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_locations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_enc_id', 'organization_enc_id', 'location_name', 'location_for', 'address', 'city_enc_id', 'latitude', 'longitude', 'created_by'], 'required'],
            [['description', 'status'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['sequence', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['location_enc_id', 'organization_enc_id', 'website', 'address', 'city_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['location_name', 'email'], 'string', 'max' => 50],
            [['location_for', 'phone'], 'string', 'max' => 15],
            [['postal_code'], 'string', 'max' => 7],
            [['location_enc_id'], 'unique'],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationInterviewLocations()
    {
        return $this->hasMany(ApplicationInterviewLocations::className(), ['location_enc_id' => 'location_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPlacementLocations()
    {
        return $this->hasMany(ApplicationPlacementLocations::className(), ['location_enc_id' => 'location_enc_id']);
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
