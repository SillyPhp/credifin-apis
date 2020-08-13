<?php
namespace common\models;


/**
 * This is the model class for table "{{%unclaim_organization_locations}}".
 *
 * @property int $id Primary Key
 * @property string $location_enc_id Location Encrypted ID
 * @property string $unclaim_organization_enc_id Foreign Key to Unclaim Organizations Table
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
 * @property Cities $cityEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property UnclaimedOrganizations $unclaimOrganizationEnc
 */
class UnclaimOrganizationLocations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unclaim_organization_locations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_enc_id', 'unclaim_organization_enc_id', 'location_name', 'created_by'], 'required'],
            [['description', 'status'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['sequence', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['location_enc_id', 'unclaim_organization_enc_id', 'website', 'address', 'city_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['location_name'], 'string', 'max' => 200],
            [['location_for', 'phone'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 50],
            [['postal_code'], 'string', 'max' => 7],
            [['location_enc_id'], 'unique'],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['unclaim_organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['unclaim_organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationEnc()
    {
        return $this->hasOne(UnclaimedOrganizations::className(), ['organization_enc_id' => 'unclaim_organization_enc_id']);
    }
}
