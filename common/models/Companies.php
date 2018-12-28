<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%companies}}".
 *
 * @property int $id Primary Key
 * @property string $company_enc_id Company Encrypted ID
 * @property string $name Company Name
 * @property string $slug Company Slug
 * @property string $email Company Email
 * @property string $logo Company Logo
 * @property string $logo_location Location of the logo
 * @property string $cover_image Company Cover Image
 * @property string $cover_image_location Location of the cover image
 * @property string $description Company Description
 * @property string $mission Company Mission
 * @property string $vision Company Vision
 * @property string $value Company Values
 * @property string $website Company Website
 * @property string $phone Contact Number
 * @property string $fax Fax Number
 * @property string $address Company Address
 * @property string $postal_code Postal Code
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $created_on On which date Company information was added to database
 * @property string $created_by By which User Company information was added
 * @property string $last_updated_on On which date Company information was updated
 * @property string $last_updated_by By which User Company information was updated
 * @property string $status Company Status (Active, Inactive, Pending)
 * @property string $is_deleted Is Company Deleted (True, False)
 *
 * @property Cities $cityEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property CompanyLocations[] $companyLocations
 * @property EmployerApplications[] $employerApplications
 * @property Users[] $users
 */
class Companies extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%companies}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_enc_id', 'name', 'slug', 'email', 'phone', 'created_on', 'created_by'], 'required'],
            [['company_enc_id', 'name', 'email', 'slug', 'logo', 'logo_location','cover_image', 'cover_image_location', 'phone', 'fax', 'description', 'website', 'address', 'postal_code', 'created_on', 'created_by'], 'trim'],
            [['description', 'mission', 'vision', 'value', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['company_enc_id', 'name', 'slug', 'logo', 'logo_location', 'cover_image', 'cover_image_location','website', 'city_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['email', 'address'], 'string', 'max' => 50],
            [['phone', 'fax'], 'string', 'max' => 15],
            [['postal_code'], 'string', 'max' => 10],
            [['is_deleted'], 'string', 'max' => 5],
            [['company_enc_id'], 'unique'],
            [['email'], 'unique'],
            [['slug'], 'unique'],
            [['email'], 'email'],
            [['website'], 'url', 'defaultScheme' => 'http'],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
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
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyLocations() {
        return $this->hasMany(CompanyLocations::className(), ['company_enc_id' => 'company_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['company_enc_id' => 'company_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(Users::className(), ['company_enc_id' => 'company_enc_id']);
    }

}
