<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%application_interview_locations}}".
 *
 * @property int $id Primary Key
 * @property string $interview_location_enc_id Interview Location Encrypted ID
 * @property string $location_enc_id Foreign Key to Organization Locations Table
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property string $created_on On which date Application Interview Location information was added to database
 * @property string $created_by By which User Application Interview Location information was added
 * @property string $last_updated_on On which date Application Interview Location information was updated
 * @property string $last_updated_by By which User Application Interview Location information was updated
 * @property int $is_deleted Is Application Interview Location Deleted (0 As False, 1 As True)
 *
 * @property EmployerApplications $applicationEnc
 * @property OrganizationLocations $locationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationInterviewLocations extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_interview_locations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['interview_location_enc_id', 'location_enc_id', 'application_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['interview_location_enc_id', 'location_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['interview_location_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['location_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLocations::className(), 'targetAttribute' => ['location_enc_id' => 'location_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc() {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationEnc() {
        return $this->hasOne(OrganizationLocations::className(), ['location_enc_id' => 'location_enc_id']);
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
