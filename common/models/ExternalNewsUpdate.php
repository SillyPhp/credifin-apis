<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%external_news_update}}".
 *
 * @property int $id Primary Key
 * @property string $news_enc_id News Encrypted ID
 * @property string $title Post Title
 * @property string $link source url
 * @property int $downvote
 * @property int $upvote
 * @property string $source
 * @property string $slug Slug
 * @property string $description Post Description
 * @property string $image Featured Image
 * @property string $image_location Location of the Featured Image
 * @property string $created_on On which date Post information was added to database
 * @property string $created_by By which User Post information was added
 * @property string $last_updated_on On which date Post information was updated
 * @property string $last_updated_by By which User Post information was updated
 * @property int $status 1 as Published, 0 as Unpublished
 * @property int $is_visible 0 as false, 1 as true
 * @property int $is_deleted Is Post Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property NewsTags[] $newsTags
 * @property SkillsUpPostAssignedNews[] $skillsUpPostAssignedNews
 */
class ExternalNewsUpdate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%external_news_update}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_enc_id', 'title', 'link', 'source', 'slug', 'created_by'], 'required'],
            [['title', 'description'], 'string'],
            [['downvote', 'upvote', 'status', 'is_visible', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['news_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['link', 'source'], 'string', 'max' => 200],
            [['slug'], 'string', 'max' => 255],
            [['news_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
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
    public function getNewsTags()
    {
        return $this->hasMany(NewsTags::className(), ['news_enc_id' => 'news_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedNews()
    {
        return $this->hasMany(SkillsUpPostAssignedNews::className(), ['news_enc_id' => 'news_enc_id']);
    }
}
