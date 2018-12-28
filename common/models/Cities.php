<?php

namespace common\models;

/**
 * This is the model class for table "{{%cities}}".
 *
 * @property int $id Primary Key
 * @property string $city_enc_id City Encrypted ID
 * @property string $name City Name
 * @property string $state_enc_id Foreign Key to States Table
 *
 * @property Applications[] $applications
 * @property AppliedApplicationLocations[] $appliedApplicationLocations
 * @property States $stateEnc
 * @property Companies[] $companies
 * @property JobsData[] $jobsDatas
 * @property OrganizationLocations[] $organizationLocations
 * @property RegisteredStudents[] $registeredStudents
 * @property TrainingApplicationOtherInformation[] $trainingApplicationOtherInformations
 * @property TrainingProgramBatches[] $trainingProgramBatches
 * @property UserPreferredLocations[] $userPreferredLocations
 * @property UserWorkExperience[] $userWorkExperiences
 * @property Users[] $users
 */
class Cities extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%cities}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['city_enc_id', 'name', 'state_enc_id'], 'required'],
            [['city_enc_id', 'state_enc_id'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 30],
            [['city_enc_id'], 'unique'],
            [['state_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_enc_id' => 'state_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications() {
        return $this->hasMany(Applications::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationLocations() {
        return $this->hasMany(AppliedApplicationLocations::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStateEnc() {
        return $this->hasOne(States::className(), ['state_enc_id' => 'state_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies() {
        return $this->hasMany(Companies::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobsDatas() {
        return $this->hasMany(JobsData::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLocations() {
        return $this->hasMany(OrganizationLocations::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisteredStudents() {
        return $this->hasMany(RegisteredStudents::className(), ['location' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingApplicationOtherInformations() {
        return $this->hasMany(TrainingApplicationOtherInformation::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramBatches() {
        return $this->hasMany(TrainingProgramBatches::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredLocations() {
        return $this->hasMany(UserPreferredLocations::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserWorkExperiences() {
        return $this->hasMany(UserWorkExperience::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(Users::className(), ['city_enc_id' => 'city_enc_id']);
    }

}
