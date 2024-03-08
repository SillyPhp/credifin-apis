<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%learning_videos}}".
 *
 * @property int $id Primary Key
 * @property string $video_enc_id Video Encrypted ID
 * @property string $channel_enc_id foreign key for youtube channel
 * @property string $assigned_category_enc_id Foreign Key to Assigned Categories Table
 * @property string $title Video Titile
 * @property string $cover_image Cover Image of Video
 * @property string $description Video Description
 * @property string $slug Video Slug
 * @property string $duration Video Duration
 * @property string $youtube_video_id Youtube Video ID
 * @property int $view_count Total Views of Video
 * @property int $is_sponsored Is Video Sponsored (0 as No, 1 as Yes)
 * @property int $is_featured Is Video Featured (0 as No, 1 as Yes)
 * @property string $created_on On which date Video information was added to database
 * @property string $created_by By which User Video information was added
 * @property string $last_updated_on On which date Video information was updated
 * @property string $last_updated_by By which User Video information was updated
 * @property int $status Video Status (1 as Active, 2 as Inactive, 3 as Pending, 4 as Rejected)
 * @property int $is_visible 0 as false, 1 as true
 * @property int $is_deleted Is Video Deleted (0 as False, 1 as True)
 *
 * @property LearningVideoComments[] $learningVideoComments
 * @property LearningVideoLikes[] $learningVideoLikes
 * @property LearningVideoTags[] $learningVideoTags
 * @property Tags[] $tagEncs
 * @property AssignedCategories $assignedCategoryEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class LearningVideos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%learning_videos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_enc_id', 'channel_enc_id', 'title', 'cover_image', 'slug', 'duration', 'youtube_video_id', 'created_by'], 'required'],
            [['description'], 'string'],
            [['duration', 'created_on', 'last_updated_on'], 'safe'],
            [['view_count', 'is_sponsored', 'is_featured', 'status', 'is_visible', 'is_deleted'], 'integer'],
            [['video_enc_id', 'channel_enc_id', 'assigned_category_enc_id', 'title', 'cover_image', 'slug', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['youtube_video_id'], 'string', 'max' => 50],
            [['video_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['youtube_video_id'], 'unique'],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoComments()
    {
        return $this->hasMany(LearningVideoComments::className(), ['video_enc_id' => 'video_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoLikes()
    {
        return $this->hasMany(LearningVideoLikes::className(), ['video_enc_id' => 'video_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoTags()
    {
        return $this->hasMany(LearningVideoTags::className(), ['video_enc_id' => 'video_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagEncs()
    {
        return $this->hasMany(Tags::className(), ['tag_enc_id' => 'tag_enc_id'])->viaTable('{{%learning_video_tags}}', ['video_enc_id' => 'video_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategoryEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
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
}
