<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%twitter_jobs}}".
 *
 * @property int $id Primary Key
 * @property string $tweet_enc_id tweet Encrypted Encrypted ID
 * @property string $unclaim_organization_enc_id unclaim organization enc id
 * @property string $profile job profile
 * @property string $job_title job title
 * @property string $wage_type
 * @property double $fixed_wage
 * @property double $min_wage
 * @property double $max_wage
 * @property string $job_type job type
 * @property string $url url
 * @property string $contact_email contact details
 * @property string $apply_url apply url
 * @property string $author_name Name
 * @property string $author_url author url
 * @property string $html_code html code
 * @property int $is_deleted
 * @property string $created_on On which date information was added to database
 * @property string $created_by By which User information was added
 * @property string $last_updated_on On which date information was updated
 * @property string $last_updated_by By which User information was updated
 *
 * @property TwitterJobSkills[] $twitterJobSkills
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property UnclaimedOrganizations $unclaimOrganizationEnc
 * @property Users $lastUpdatedBy0
 * @property Categories $profile0
 * @property AssignedCategories $jobTitle
 * @property TwitterPlacementCities[] $twitterPlacementCities
 */
class TwitterJobs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%twitter_jobs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tweet_enc_id', 'unclaim_organization_enc_id', 'profile', 'job_title', 'wage_type', 'job_type', 'url', 'author_name', 'author_url', 'html_code', 'created_by'], 'required'],
            [['wage_type', 'job_type', 'html_code'], 'string'],
            [['fixed_wage', 'min_wage', 'max_wage'], 'number'],
            [['is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['tweet_enc_id', 'unclaim_organization_enc_id', 'profile', 'job_title', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['url', 'contact_email', 'apply_url', 'author_name', 'author_url'], 'string', 'max' => 255],
            [['tweet_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['unclaim_organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['unclaim_organization_enc_id' => 'organization_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['profile'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['profile' => 'category_enc_id']],
            [['job_title'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['job_title' => 'assigned_category_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterJobSkills()
    {
        return $this->hasMany(TwitterJobSkills::className(), ['tweet_enc_id' => 'tweet_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy0()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile0()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'profile']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobTitle()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'job_title']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterPlacementCities()
    {
        return $this->hasMany(TwitterPlacementCities::className(), ['tweet_enc_id' => 'tweet_enc_id']);
    }
}
