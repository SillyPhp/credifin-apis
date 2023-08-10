<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cities}}".
 *
 * @property int $id Primary Key
 * @property string $city_enc_id City Encrypted ID
 * @property string $name City Name
 * @property string $city_code
 * @property string $state_enc_id Foreign Key to States Table
 *
 * @property ApiJobsPlacementCities[] $apiJobsPlacementCities
 * @property States $stateEnc
 * @property ClaimServiceableLocations[] $claimServiceableLocations
 * @property CollegeStudentsReview[] $collegeStudentsReviews
 * @property DropResumeSelectedLocations[] $dropResumeSelectedLocations
 * @property DropResumeAppliedApplications[] $appliedApplicationEncs
 * @property EmployerReviews[] $employerReviews
 * @property InstituteStudentsReview[] $instituteStudentsReviews
 * @property LoanApplicantResidentialInfo[] $loanApplicantResidentialInfos
 * @property OrganizationLocations[] $organizationLocations
 * @property OrganizationOtherDetails[] $organizationOtherDetails
 * @property Products[] $products
 * @property SalaryReviews[] $salaryReviews
 * @property SchoolStudentsReview[] $schoolStudentsReviews
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cities}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_enc_id', 'name', 'state_enc_id'], 'required'],
            [['city_enc_id', 'city_code', 'state_enc_id'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 30],
            [['city_enc_id'], 'unique'],
            [['state_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_enc_id' => 'state_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_enc_id' => 'City Enc ID',
            'name' => 'Name',
            'city_code' => 'City Code',
            'state_enc_id' => 'State Enc ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApiJobsPlacementCities()
    {
        return $this->hasMany(ApiJobsPlacementCities::className(), ['city_enc_id' => 'city_enc_id']);
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
    public function getClaimServiceableLocations()
    {
        return $this->hasMany(ClaimServiceableLocations::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeStudentsReviews()
    {
        return $this->hasMany(CollegeStudentsReview::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeSelectedLocations()
    {
        return $this->hasMany(DropResumeSelectedLocations::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEncs()
    {
        return $this->hasMany(DropResumeAppliedApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id'])->viaTable('{{%drop_resume_selected_locations}}', ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerReviews()
    {
        return $this->hasMany(EmployerReviews::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituteStudentsReviews()
    {
        return $this->hasMany(InstituteStudentsReview::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicantResidentialInfos()
    {
        return $this->hasMany(LoanApplicantResidentialInfo::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLocations()
    {
        return $this->hasMany(OrganizationLocations::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationOtherDetails()
    {
        return $this->hasMany(OrganizationOtherDetails::className(), ['location_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryReviews()
    {
        return $this->hasMany(SalaryReviews::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolStudentsReviews()
    {
        return $this->hasMany(SchoolStudentsReview::className(), ['city_enc_id' => 'city_enc_id']);
    }
}
