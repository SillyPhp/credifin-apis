<?php

namespace common\models;

/**
 * This is the model class for table "{{%posts}}".
 *
 * @property int $id Primary Key
 * @property string $post_enc_id Post Encrypted ID
 * @property string $author_enc_id Foreign Key to Users Table
 * @property string $title Post Title
 * @property string $slug Post Slug
 * @property string $excerpt Post Excerpt
 * @property string $description Post Description
 * @property string $post_type_enc_id Foreign Key to Post Types Table
 * @property string $meta_keywords Meta Keywords
 * @property string $featured_image Featured Image
 * @property string $featured_image_location Location of the Featured Image
 * @property string $featured_image_title Featured Image Title
 * @property string $featured_image_alt Alternative Text of Featured Image
 * @property string $created_on On which date Post information was added to database
 * @property string $created_by By which User Post information was added
 * @property string $last_updated_on On which date Post information was updated
 * @property string $last_updated_by By which User Post information was updated
 * @property string $status Post Status (Draft, Active, Inactive, Pending)
 * @property int $is_deleted Is Post Deleted (0 as False, 1 as True)
 *
 * @property PostCategories[] $postCategories
 * @property PostMedia[] $postMedia
 * @property PostTags[] $postTags
 * @property Users $authorEnc
 * @property Users $lastUpdatedBy
 * @property PostTypes $postTypeEnc
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_enc_id', 'author_enc_id', 'title', 'slug', 'post_type_enc_id', 'created_by'], 'required'],
            [['title', 'excerpt', 'description', 'meta_keywords', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['post_enc_id', 'author_enc_id', 'post_type_enc_id', 'featured_image', 'featured_image_location', 'featured_image_title', 'featured_image_alt', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['post_enc_id'], 'unique'],
            [['author_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_enc_id' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['post_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostTypes::className(), 'targetAttribute' => ['post_type_enc_id' => 'post_type_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategories::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMedia()
    {
        return $this->hasMany(PostMedia::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTags::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'author_enc_id']);
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
    public function getPostTypeEnc()
    {
        return $this->hasOne(PostTypes::className(), ['post_type_enc_id' => 'post_type_enc_id']);
    }
}
