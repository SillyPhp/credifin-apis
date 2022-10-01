<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%unclaimed_organizations}}".
 *
 * @property int $id Primary Key
 * @property string $organization_enc_id Organization Encrypted ID
 * @property string $organization_type_enc_id Foreign Key to Business Activities Table
 * @property string $city_enc_id Foreign Key to CitiesTable
 * @property string $name Organization Name
 * @property int $source 0 as EY, 1 as GIT, 2 as MUSE, 3 as Education Loans 4 as Education colleges
 * @property string $logo Organization Logo
 * @property string $logo_location Location of the Logo
 * @property string $cover_image cover_image
 * @property string $cover_image_location cover_image_location
 * @property string $slug Organization Slug
 * @property string $email Organization Email
 * @property string $facebook_username Facebook
 * @property string $twitter_username twitter
 * @property string $linkedin_username Linkedin
 * @property string $instagram_username Instagram
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
 * @property int $is_featured
 * @property int $is_popular 0 as false 1 as true
 * @property string $created_by By which User Organization information was added
 * @property string $created_on On which date Organization information was added to database
 * @property int $is_moved 0 as false, 1 as true
 *
 * @property ApiJobs[] $apiJobs
 * @property AssignedCategories[] $assignedCategories
 * @property AssignedUnclaimAffiliation[] $assignedUnclaimAffiliations
 * @property AssignedUnclaimAffiliation[] $assignedUnclaimAffiliations0
 * @property AssignedUnclaimCollegeCourses[] $assignedUnclaimCollegeCourses
 * @property AssignedUnclaimUserContacts[] $assignedUnclaimUserContacts
 * @property ClaimServiceableLocations[] $claimServiceableLocations
 * @property DropResumeUnclaimOrgApplication[] $dropResumeUnclaimOrgApplications
 * @property GitApplications[] $gitApplications
 * @property QuizSponsors[] $quizSponsors
 * @property Reviews[] $reviews
 * @property Speakers[] $speakers
 * @property TrainingProgramApplication[] $trainingProgramApplications
 * @property TwitterJobs[] $twitterJobs
 * @property UnclaimAssignedIndustries[] $unclaimAssignedIndustries
 * @property UnclaimOrganizationImages[] $unclaimOrganizationImages
 * @property UnclaimOrganizationLabels[] $unclaimOrganizationLabels
 * @property UnclaimOrganizationLocations[] $unclaimOrganizationLocations
 * @property UnclaimServiceableLocations[] $unclaimServiceableLocations
 * @property Cities $cityEnc
 * @property Users $createdBy
 * @property BusinessActivities $organizationTypeEnc
 * @property WebinarSponsors[] $webinarSponsors
 */
class UnclaimedOrganizations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%unclaimed_organizations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_enc_id', 'name', 'slug', 'initials_color'], 'required'],
            [['source', 'status', 'is_deleted', 'is_featured', 'is_popular', 'is_moved'], 'integer'],
            [['description', 'short_description', 'address'], 'string'],
            [['created_on'], 'safe'],
            [['organization_enc_id', 'organization_type_enc_id', 'city_enc_id', 'logo', 'logo_location', 'cover_image', 'cover_image_location', 'created_by'], 'string', 'max' => 100],
            [['name', 'slug'], 'string', 'max' => 255],
            [['email', 'facebook_username', 'twitter_username', 'linkedin_username', 'instagram_username', 'size'], 'string', 'max' => 50],
            [['tags', 'website'], 'string', 'max' => 200],
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApiJobs()
    {
        return $this->hasMany(ApiJobs::className(), ['unclaim_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategories()
    {
        return $this->hasMany(AssignedCategories::className(), ['unclaim_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimAffiliations()
    {
        return $this->hasMany(AssignedUnclaimAffiliation::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimAffiliations0()
    {
        return $this->hasMany(AssignedUnclaimAffiliation::className(), ['assigned_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimCollegeCourses()
    {
        return $this->hasMany(AssignedUnclaimCollegeCourses::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimUserContacts()
    {
        return $this->hasMany(AssignedUnclaimUserContacts::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimServiceableLocations()
    {
        return $this->hasMany(ClaimServiceableLocations::className(), ['unclaim_college_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeUnclaimOrgApplications()
    {
        return $this->hasMany(DropResumeUnclaimOrgApplication::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGitApplications()
    {
        return $this->hasMany(GitApplications::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSponsors()
    {
        return $this->hasMany(QuizSponsors::className(), ['unclaimed_org_enc_id' => 'organization_enc_id']);
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
    public function getSpeakers()
    {
        return $this->hasMany(Speakers::className(), ['unclaimed_org_id' => 'organization_enc_id']);
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
    public function getUnclaimOrganizationLabels()
    {
        return $this->hasMany(UnclaimOrganizationLabels::className(), ['organization_enc_id' => 'organization_enc_id']);
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
    public function getUnclaimServiceableLocations()
    {
        return $this->hasMany(UnclaimServiceableLocations::className(), ['organization_enc_id' => 'organization_enc_id']);
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
    public function getWebinarSponsors()
    {
        return $this->hasMany(WebinarSponsors::className(), ['unclaimed_org_enc_id' => 'organization_enc_id']);
    }
}
