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
 * @property string $cover_image Cover Image
 * @property string $cover_image_location
 * @property string $post_description  Description
 * @property string $post_short_summery
 * @property string $slug  Slug
 * @property string $created_on On which date  information was added to database
 * @property string $created_by By which User  information was added
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User  information was updated
 * @property string $status Status  Active, Inactive, Pending,  Rejected
 * @property int $is_deleted Is Deleted (0 as False, 1 as True)
 *
 * @property SkillsUpPostAssignedBlogs[] $skillsUpPostAssignedBlogs
 * @property SkillsUpPostAssignedEmbeds[] $skillsUpPostAssignedEmbeds
 * @property SkillsUpPostAssignedNews[] $skillsUpPostAssignedNews
 * @property SkillsUpPostAssignedSkills[] $skillsUpPostAssignedSkills
 * @property SkillsUpPostAssignedVideo[] $skillsUpPostAssignedVideos
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property SkillsUpSources $sourceEnc
 */
class SkillsUpPosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%skills_up_posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_enc_id', 'post_title', 'source_enc_id', 'slug', 'created_by'], 'required'],
            [['post_description', 'post_short_summery', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['post_enc_id', 'source_enc_id', 'cover_image', 'cover_image_location', 'slug', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['post_title', 'post_source_url'], 'string', 'max' => 255],
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
    public function getSkillsUpPostAssignedBlogs()
    {
        return $this->hasMany(SkillsUpPostAssignedBlogs::className(), ['post_enc_id' => 'post_enc_id']);
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
}
