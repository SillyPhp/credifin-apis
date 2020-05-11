<?php

namespace common\models;

/**
 * This is the model class for table "{{%youtube_channels}}".
 *
 * @property int $id Primary Key
 * @property string $channel_enc_id Youtube Channel Encrypted ID
 * @property string $author_enc_id Foreign Keys to Users Table
 * @property string $channel_title Channel Name
 * @property string $channel_id Channel Id fof youtube channel
 * @property string $description description about channel
 * @property string $published_at Channel Publishing date
 * @property string $thamb_url Thumbnail Url
 * @property string $country_name Name of Country
 * @property string $banner_image_url banner image url from youtube channel
 * @property string $content_owner Owner name of content channel
 * @property string $next_page_token video next page token
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property int $status Channel Status (0 as unpublished, 1 as published)
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 */
class YoutubeChannels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%youtube_channels}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_enc_id', 'channel_title', 'channel_id', 'created_by'], 'required'],
            [['description'], 'string'],
            [['published_at', 'created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['channel_enc_id', 'author_enc_id', 'channel_title', 'thamb_url', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['channel_id', 'country_name', 'banner_image_url', 'content_owner', 'next_page_token'], 'string', 'max' => 50],
            [['channel_enc_id'], 'unique'],
            [['channel_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideos()
    {
        return $this->hasMany(LearningVideos::className(), ['channel_enc_id' => 'channel_enc_id']);
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
    public function getAuthorEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'author_enc_id']);
    }
}
