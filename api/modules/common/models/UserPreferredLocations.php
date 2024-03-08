<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_preferred_locations}}".
 *
 * @property int $id Primary Key
 * @property string $preferred_location_enc_id Preferred Location Encrypted ID
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $preference_enc_id Foreign Key to User Preferences Table
 * @property string $created_on On which date User Preferred Location information was added to database
 * @property string $created_by By which User Preferred Location information was added
 * @property string $last_updated_on On which date User Preferred Location information was updated
 * @property string $last_updated_by By which User Preferred Location information was updated
 * @property int $is_deleted Is User Preferred Location Deleted (0 As False, 1 As True)
 *
 * @property Cities $cityEnc
 * @property UserPreferences $preferenceEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserPreferredLocations extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_preferred_locations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['preferred_location_enc_id', 'city_enc_id', 'preference_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['preferred_location_enc_id', 'city_enc_id', 'preference_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['preferred_location_enc_id'], 'unique'],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['preference_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPreferences::className(), 'targetAttribute' => ['preference_enc_id' => 'preference_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc() {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferenceEnc() {
        return $this->hasOne(UserPreferences::className(), ['preference_enc_id' => 'preference_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

}
