<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%unclaimed_organizations}}".
 *
 * @property int $id Primary Key
 * @property string $organization_enc_id Organization Encrypted ID
 * @property string $organization_type_enc_id Foreign Key to Business Activities Table
 * @property int $source 0 as EY, 1 as GIT, 2 as MUSE, 3 as Education Loans 4 as Education colleges
 * @property string $logo Organization Logo
 * @property string $logo_location Location of the Logo
 * @property string $cover_image Organization Cover Image
 * @property string $cover_image_location Location of the cover image
 * @property string $slug Organization Slug
 * @property string $email Organization Email
 * @property string $facebook_username Facebook
 * @property string $twitter_username Twitter
 * @property string $linkedin_username Linkedin
 * @property string $instagram_username Instagram
 * @property string $tags Achievements Or Seo Tags For Searching
 * @property string $phone Organization Phone Number
 * @property string $initials_color Intials Color
 * @property string $size Organization Size
 * @property string $description Organization Description
 * @property string $short_description Short Description
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $name Organization Name
 * @property string $address Address
 * @property string $postal_code Postal Code
 * @property string $website Organization Website
 * @property int $status Organization Status (Active, Inactive, Pending)
 * @property string $created_by By which User Organization information was added
 * @property string $created_on On which date Organization information was added to database
 * @property int $is_deleted Is Organization Deleted (0 as False, 1 as True)
 * @property int $is_featured
 * @property int $is_popular 0 as false 1 as true
 * @property int $is_moved 0 as false, 1 as true
 *
 * @property AssignedDeals[] $assignedDeals
 * @property AssignedUnclaimAffiliation[] $assignedUnclaimAffiliations
 * @property AssignedUnclaimAffiliation[] $assignedUnclaimAffiliations0
 * @property AssignedUnclaimCollegeCourses[] $assignedUnclaimCollegeCourses
 * @property AssignedUnclaimUserContacts[] $assignedUnclaimUserContacts
 * @property DropResumeUnclaimOrgApplication[] $dropResumeUnclaimOrgApplications
 * @property EmployerApplications[] $employerApplications
 * @property GitApplications[] $gitApplications
 * @property NewOrganizationReviews[] $newOrganizationReviews
 * @property QuizSponsors[] $quizSponsors
 * @property Speakers[] $speakers
 * @property TrainingProgramApplication[] $trainingProgramApplications
 * @property TwitterJobs[] $twitterJobs
 * @property UnclaimAssignedIndustries[] $unclaimAssignedIndustries
 * @property UnclaimOrganizationImages[] $unclaimOrganizationImages
 * @property UnclaimOrganizationLabels[] $unclaimOrganizationLabels
 * @property UnclaimOrganizationLocations[] $unclaimOrganizationLocations
 * @property UnclaimedFollowedOrganizations[] $unclaimedFollowedOrganizations
 * @property Users[] $userEncs
 * @property Users $createdBy
 * @property BusinessActivities $organizationTypeEnc
 * @property Cities $cityEnc
 * @property WebinarSponsors[] $webinarSponsors
 */
class UnclaimedOrganizations extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%unclaimed_organizations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['organization_enc_id', 'slug', 'initials_color', 'name'], 'required'],
            [['source', 'status', 'is_deleted', 'is_featured', 'is_popular', 'is_moved'], 'integer'],
            [['description', 'short_description', 'address'], 'string'],
            [['created_on'], 'safe'],
            [['organization_enc_id', 'organization_type_enc_id', 'logo', 'logo_location', 'cover_image', 'cover_image_location', 'city_enc_id', 'created_by'], 'string', 'max' => 100],
            [['slug', 'name'], 'string', 'max' => 255],
            [['email', 'facebook_username', 'twitter_username', 'linkedin_username', 'instagram_username', 'size'], 'string', 'max' => 50],
            [['tags', 'website'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 15],
            [['initials_color'], 'string', 'max' => 7],
            [['postal_code'], 'string', 'max' => 10],
            [['slug'], 'unique'],
            [['organization_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['organization_type_enc_id' => 'business_activity_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'organization_enc_id' => 'Organization Enc ID',
            'organization_type_enc_id' => 'Organization Type Enc ID',
            'source' => 'Source',
            'logo' => 'Logo',
            'logo_location' => 'Logo Location',
            'cover_image' => 'Cover Image',
            'cover_image_location' => 'Cover Image Location',
            'slug' => 'Slug',
            'email' => 'Email',
            'facebook_username' => 'Facebook Username',
            'twitter_username' => 'Twitter Username',
            'linkedin_username' => 'Linkedin Username',
            'instagram_username' => 'Instagram Username',
            'tags' => 'Tags',
            'phone' => 'Phone',
            'initials_color' => 'Initials Color',
            'size' => 'Size',
            'description' => 'Description',
            'short_description' => 'Short Description',
            'city_enc_id' => 'City Enc ID',
            'name' => 'Name',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
            'website' => 'Website',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'is_deleted' => 'Is Deleted',
            'is_featured' => 'Is Featured',
            'is_popular' => 'Is Popular',
            'is_moved' => 'Is Moved',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimAffiliations() {
        return $this->hasMany(AssignedUnclaimAffiliation::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimAffiliations0() {
        return $this->hasMany(AssignedUnclaimAffiliation::className(), ['assigned_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimCollegeCourses() {
        return $this->hasMany(AssignedUnclaimCollegeCourses::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimUserContacts() {
        return $this->hasMany(AssignedUnclaimUserContacts::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropResumeUnclaimOrgApplications() {
        return $this->hasMany(DropResumeUnclaimOrgApplication::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['unclaimed_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGitApplications() {
        return $this->hasMany(GitApplications::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewOrganizationReviews() {
        return $this->hasMany(NewOrganizationReviews::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSponsors() {
        return $this->hasMany(QuizSponsors::className(), ['unclaimed_org_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeakers() {
        return $this->hasMany(Speakers::className(), ['unclaimed_org_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramApplications() {
        return $this->hasMany(TrainingProgramApplication::className(), ['unclaimed_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterJobs() {
        return $this->hasMany(TwitterJobs::className(), ['unclaim_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimAssignedIndustries() {
        return $this->hasMany(UnclaimAssignedIndustries::className(), ['unclaim_oragnizations_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationImages() {
        return $this->hasMany(UnclaimOrganizationImages::className(), ['unclaim_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationLabels() {
        return $this->hasMany(UnclaimOrganizationLabels::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationLocations() {
        return $this->hasMany(UnclaimOrganizationLocations::className(), ['unclaim_organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedFollowedOrganizations() {
        return $this->hasMany(UnclaimedFollowedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEncs() {
        return $this->hasMany(Users::className(), ['user_enc_id' => 'user_enc_id'])->viaTable('{{%unclaimed_followed_organizations}}', ['organization_enc_id' => 'organization_enc_id']);
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
    public function getOrganizationTypeEnc() {
        return $this->hasOne(BusinessActivities::className(), ['business_activity_enc_id' => 'organization_type_enc_id']);
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
    public function getWebinarSponsors() {
        return $this->hasMany(WebinarSponsors::className(), ['unclaimed_org_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedDeals()
    {
        return $this->hasMany(AssignedDeals::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}