<?php
namespace common\models;

/**
 * This is the model class for table "{{%unclaimed_organizations}}".
 *
 * @property int $id Primary Key
 * @property string $organization_enc_id Organization Encrypted ID
 * @property string $organization_type_enc_id Foreign Key to Business Activities Table
 * @property string $city_enc_id Foreign Key to CitiesTable
 * @property string $name Organization Name
 * @property string $source source from where its created
 * @property string $logo Organization Logo
 * @property string $logo_location Location of the Logo
 * @property string $cover_image cover_image
 * @property string $cover_image_location cover_image_location
 * @property string $slug Organization Slug
 * @property string $email Organization Email
 * @property string $facebook_username Facebook
 * @property string $twitter_username twitter
 * @property string $linkedin_username Linkedin
 * @property string $tags Acheivments Or Seo Tags For Searching
 * @property string $phone organization phone no
 * @property string $description organization description
 * @property string $short_description minimum organization information
 * @property string $address Organization Full Address
 * @property string $postal_code Postal Code of address
 * @property string $website Organization Website
 * @property string $initials_color Intials Color
 * @property string $size Organization Size
 * @property int $status Organization Status (1 Active, 0 Inactive, 2 Pending)
 * @property int $is_deleted 1 as false and 0 for true
 * @property string $created_by By which User Organization information was added
 * @property string $created_on On which date Organization information was added to database
 * @property int $is_featured
 * @property Reviews[] $reviews
 * @property TrainingProgramApplication[] $trainingProgramApplications
 * @property TwitterJobs[] $twitterJobs
 * @property UnclaimAssignedIndustries[] $unclaimAssignedIndustries
 * @property UnclaimOrganizationImages[] $unclaimOrganizationImages
 * @property UnclaimOrganizationLocations[] $unclaimOrganizationLocations
 * @property Cities $cityEnc
 * @property Users $createdBy
 * @property BusinessActivities $organizationTypeEnc
 */
class UnclaimedOrganizations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unclaimed_organizations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_enc_id', 'name', 'slug', 'initials_color'], 'required'],
            [['source', 'description', 'short_description', 'address', 'size'], 'string'],
            [['status', 'is_deleted','is_featured'], 'integer'],
            [['created_on'], 'safe'],
            [['organization_enc_id', 'organization_type_enc_id', 'city_enc_id', 'name', 'logo', 'logo_location', 'cover_image', 'cover_image_location', 'slug', 'website', 'created_by'], 'string', 'max' => 100],
            [['email', 'facebook_username', 'twitter_username', 'linkedin_username'], 'string', 'max' => 50],
            [['tags'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 15],
            [['postal_code'], 'string', 'max' => 10],
            [['initials_color'], 'string', 'max' => 7],
            [['slug'], 'unique'],
            [['organization_enc_id'], 'unique'],
            [['facebook_username'], 'unique'],
            [['twitter_username'], 'unique'],
            [['linkedin_username'], 'unique'],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['organization_type_enc_id' => 'business_activity_enc_id']],
        ];
    }


    public function getEmployerApplications()
    {
        return $this->hasMany(EmployerApplications::className(), ['unclaimed_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewOrganizationReviews()
    {
        return $this->hasMany(NewOrganizationReviews::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['unclaimed_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedFollowedOrganizations()
    {
        return $this->hasMany(UnclaimedFollowedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEncs()
    {
        return $this->hasMany(Users::className(), ['user_enc_id' => 'user_enc_id'])->viaTable('{{%unclaimed_followed_organizations}}', ['organization_enc_id' => 'organization_enc_id']);
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
    public function getOrganizationTypeEnc()
    {
        return $this->hasOne(BusinessActivities::className(), ['business_activity_enc_id' => 'organization_type_enc_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramApplications()
    {
        return $this->hasMany(TrainingProgramApplication::className(), ['unclaimed_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterJobs()
    {
        return $this->hasMany(TwitterJobs::className(), ['unclaim_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimAssignedIndustries()
    {
        return $this->hasMany(UnclaimAssignedIndustries::className(), ['unclaim_oragnizations_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationImages()
    {
        return $this->hasMany(UnclaimOrganizationImages::className(), ['unclaim_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationLocations()
    {
        return $this->hasMany(UnclaimOrganizationLocations::className(), ['unclaim_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

}
