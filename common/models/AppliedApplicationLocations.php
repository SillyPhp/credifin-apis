<?php

namespace common\models;

/**
 * This is the model class for table "{{%applied_application_locations}}".
 *
 * @property int $id Primary Key
 * @property string $application_location_enc_id Applied Application Location Encrypted ID
 * @property string $applied_application_enc_id Foreign Key to Applied Applications Table
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $created_on On which date Application Location information was added to database
 * @property string $created_by By which User Application Location information was added
 * @property string $last_updated_on On which date Application Location information was updated
 * @property string $last_updated_by By which User Application Location information was updated
 *
 * @property AppliedApplications $appliedApplicationEnc
 * @property Cities $cityEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class AppliedApplicationLocations extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%applied_application_locations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['application_location_enc_id', 'applied_application_enc_id', 'city_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['application_location_enc_id', 'applied_application_enc_id', 'city_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_location_enc_id'], 'unique'],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc() {
        return $this->hasOne(AppliedApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
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
