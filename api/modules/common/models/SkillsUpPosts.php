<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_posts}}".
 *
 * @property int $id Primary Key
 * @property string $post_enc_id Post Encrypted ID
 * @property string $post_title
 * @property string $post_source_url
 * @property string $source_enc_id
 * @property string $content_type
 * @property string $cover_image Cover Image
 * @property string $cover_image_location
 * @property string $post_image_url Image Url
 * @property string $post_description  Description
 * @property string $post_short_summery
 * @property string $slug  Slug
 * @property string $created_on On which date  information was added to database
 * @property string $created_by By which User  information was added
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User  information was updated
 * @property string $status Active as Accept, Rejected as Reject, On Hold as On Hold, Inactive as Review, Pending as Check
 * @property int $is_completed Is completed (1 as False, 2 as True)
 * @property int $is_deleted Is Deleted (0 as False, 1 as True)
 *
 * @property SkillsUpAuthors[] $skillsUpAuthors
 * @property SkillsUpLikesDislikes[] $skillsUpLikesDislikes
 * @property SkillsUpPostAssignedBlogs[] $skillsUpPostAssignedBlogs
 * @property SkillsUpPostAssignedCourses[] $skillsUpPostAssignedCourses
 * @property SkillsUpPostAssignedEmbeds[] $skillsUpPostAssignedEmbeds
 * @property SkillsUpPostAssignedIndustries[] $skillsUpPostAssignedIndustries
 * @property SkillsUpPostAssignedNews[] $skillsUpPostAssignedNews
 * @property SkillsUpPostAssignedSkills[] $skillsUpPostAssignedSkills
 * @property SkillsUpPostAssignedVideo[] $skillsUpPostAssignedVideos
 * @property SkillsUpPostComments[] $skillsUpPostComments
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property SkillsUpSources $sourceEnc
 * @property SkillsUpRecommendedPost[] $skillsUpRecommendedPosts
 */
class SkillsUpPosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%skills_up_posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_enc_id', 'post_title', 'source_enc_id', 'content_type', 'slug', 'created_by'], 'required'],
            [['post_source_url', 'content_type', 'post_image_url', 'post_description', 'post_short_summery', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_completed', 'is_deleted'], 'integer'],
            [['post_enc_id', 'source_enc_id', 'cover_image', 'cover_image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['post_title', 'slug'], 'string', 'max' => 255],
            [['post_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['source_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillsUpSources::className(), 'targetAttribute' => ['source_enc_id' => 'source_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpAuthors()
    {
        return $this->hasMany(SkillsUpAuthors::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpLikesDislikes()
    {
        return $this->hasMany(SkillsUpLikesDislikes::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedBlogs()
    {
        return $this->hasMany(SkillsUpPostAssignedBlogs::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedCourses()
    {
        return $this->hasMany(SkillsUpPostAssignedCourses::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedEmbeds()
    {
        return $this->hasMany(SkillsUpPostAssignedEmbeds::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedIndustries()
    {
        return $this->hasMany(SkillsUpPostAssignedIndustries::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedNews()
    {
        return $this->hasMany(SkillsUpPostAssignedNews::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedSkills()
    {
        return $this->hasMany(SkillsUpPostAssignedSkills::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedVideos()
    {
        return $this->hasMany(SkillsUpPostAssignedVideo::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostComments()
    {
        return $this->hasMany(SkillsUpPostComments::className(), ['post_enc_id' => 'post_enc_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceEnc()
    {
        return $this->hasOne(SkillsUpSources::className(), ['source_enc_id' => 'source_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpRecommendedPosts()
    {
        return $this->hasMany(SkillsUpRecommendedPost::className(), ['post_enc_id' => 'post_enc_id']);
    }
}
