<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%submitted_videos}}".
 *
 * @property int $id Primary Key
 * @property string $video_enc_id Video Encrypted ID
 * @property string $type Type of Video
 * @property string $category Category
 * @property string $sub_category Sub Category
 * @property string $name Video Name
 * @property string $slug Video Slug
 * @property string $link Video Link
 * @property string $video_duration Video Duration
 * @property string $cover_image Video Cover Image
 * @property string $description Video Description
 * @property string $tags Video Tags
 * @property string $status Video Status (Pending or Approved)
 * @property string $created_on On which date Video information was added to database
 * @property string $created_by By which User Video information was added
 * @property string $last_updated_on On which date Video information was updated
 * @property string $last_updated_by By which User Video information was updated
 *
 * @property LearningCornerResourceDiscussion[] $learningCornerResourceDiscussions
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class SubmittedVideos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%submitted_videos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_enc_id', 'type', 'name', 'slug', 'link', 'video_duration', 'cover_image', 'description', 'created_on', 'created_by'], 'required'],
            [['video_duration', 'created_on', 'last_updated_on'], 'safe'],
            [['description', 'status'], 'string'],
            [['video_enc_id', 'name', 'link', 'cover_image', 'tags', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['type', 'category', 'sub_category'], 'string', 'max' => 30],
            [['slug'], 'string', 'max' => 200],
            [['video_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningCornerResourceDiscussions()
    {
        return $this->hasMany(LearningCornerResourceDiscussion::className(), ['resource_enc_id' => 'video_enc_id']);
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
