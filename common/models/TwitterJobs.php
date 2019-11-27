<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%twitter_jobs}}".
 *
 * @property int $id Primary Key
 * @property string $tweet_enc_id tweet Encrypted Encrypted ID
 * @property string $unclaim_organization_enc_id unclaim organization enc id
 * @property string $claim_organization_enc_id
 * @property string $application_type_enc_id
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
 * @property Organizations $claimOrganizationEnc
 * @property AssignedCategories $jobTitle
 * @property Categories $profile0
 * @property ApplicationTypes $applicationTypeEnc
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dsbedutech', 'ID'),
            'tweet_enc_id' => Yii::t('dsbedutech', 'Tweet Enc ID'),
            'unclaim_organization_enc_id' => Yii::t('dsbedutech', 'Unclaim Organization Enc ID'),
            'claim_organization_enc_id' => Yii::t('dsbedutech', 'Claim Organization Enc ID'),
            'application_type_enc_id' => Yii::t('dsbedutech', 'Application Type Enc ID'),
            'profile' => Yii::t('dsbedutech', 'Profile'),
            'job_title' => Yii::t('dsbedutech', 'Job Title'),
            'wage_type' => Yii::t('dsbedutech', 'Wage Type'),
            'fixed_wage' => Yii::t('dsbedutech', 'Fixed Wage'),
            'min_wage' => Yii::t('dsbedutech', 'Min Wage'),
            'max_wage' => Yii::t('dsbedutech', 'Max Wage'),
            'job_type' => Yii::t('dsbedutech', 'Job Type'),
            'url' => Yii::t('dsbedutech', 'Url'),
            'contact_email' => Yii::t('dsbedutech', 'Contact Email'),
            'apply_url' => Yii::t('dsbedutech', 'Apply Url'),
            'author_name' => Yii::t('dsbedutech', 'Author Name'),
            'author_url' => Yii::t('dsbedutech', 'Author Url'),
            'html_code' => Yii::t('dsbedutech', 'Html Code'),
            'is_deleted' => Yii::t('dsbedutech', 'Is Deleted'),
            'created_on' => Yii::t('dsbedutech', 'Created On'),
            'created_by' => Yii::t('dsbedutech', 'Created By'),
            'last_updated_on' => Yii::t('dsbedutech', 'Last Updated On'),
            'last_updated_by' => Yii::t('dsbedutech', 'Last Updated By'),
        ];
    }

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
    public function getClaimOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'claim_organization_enc_id']);
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
    public function getProfile0()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'profile']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTypeEnc()
    {
        return $this->hasOne(ApplicationTypes::className(), ['application_type_enc_id' => 'application_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterPlacementCities()
    {
        return $this->hasMany(TwitterPlacementCities::className(), ['tweet_enc_id' => 'tweet_enc_id']);
    }
}
