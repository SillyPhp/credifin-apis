<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%posts}}".
 *
 * @property integer $id
 * @property string $post_enc_id
 * @property string $author_enc_id
 * @property string $title
 * @property string $slug
 * @property string $excerpt
 * @property string $description
 * @property string $post_type_enc_id
 * @property string $meta_keywords
 * @property string $featured_image
 * @property string $featured_image_location
 * @property string $featured_image_title
 * @property string $featured_image_alt
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property string $status
 * @property string $is_deleted
 *
 * @property PostCategories[] $postCategories
 * @property PostMedia[] $postMedia
 * @property PostTags[] $postTags
 * @property PostTypes $postTypeEnc
 * @property Users $authorEnc
 * @property Users $lastUpdatedBy
 */
class Posts extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%posts}}';
    }

    /**
     * @inheritdoc
     */
    public $image;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['post_enc_id', 'author_enc_id', 'title', 'slug', 'post_type_enc_id', 'created_on', 'created_by'], 'required'],
            [['post_enc_id', 'author_enc_id', 'title', 'slug', 'post_type_enc_id', 'excerpt', 'description', 'meta_keywords', 'featured_image', 'featured_image_location', 'featured_image_title', 'featured_image_alt'], 'trim'],
            [['title', 'excerpt', 'description', 'meta_keywords', 'status'], 'string'],
            [['excerpt'], 'string', 'max' => 160],
            [['created_on', 'last_updated_on'], 'safe'],
            [['post_enc_id', 'author_enc_id', 'post_type_enc_id', 'featured_image', 'featured_image_location', 'featured_image_title', 'featured_image_alt', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 255],
            [['is_deleted'], 'string', 'max' => 5],
            [['slug'], 'unique'],
            [['post_enc_id'], 'unique'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['post_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostTypes::className(), 'targetAttribute' => ['post_type_enc_id' => 'post_type_enc_id']],
            [['author_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['author_enc_id' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'post_enc_id' => Yii::t('common', 'Post Enc ID'),
            'author_enc_id' => Yii::t('common', 'Author Enc ID'),
            'title' => Yii::t('common', 'Title'),
            'slug' => Yii::t('common', 'Slug'),
            'excerpt' => Yii::t('common', 'Excerpt'),
            'description' => Yii::t('common', 'Description'),
            'post_type_enc_id' => Yii::t('common', 'Post Type'),
            'meta_keywords' => Yii::t('common', 'Meta Keywords'),
            'featured_image' => Yii::t('common', 'Featured Image'),
            'featured_image_location' => Yii::t('common', 'Featured Image Location'),
            'featured_image_title' => Yii::t('common', 'Featured Image Title'),
            'featured_image_alt' => Yii::t('common', 'Featured Image Alt'),
            'created_on' => Yii::t('common', 'Created On'),
            'created_by' => Yii::t('common', 'Created By'),
            'last_updated_on' => Yii::t('common', 'Last Updated On'),
            'last_updated_by' => Yii::t('common', 'Last Updated By'),
            'status' => Yii::t('common', 'Status'),
            'is_deleted' => Yii::t('common', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories() {
        return $this->hasMany(PostCategories::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMedia() {
        return $this->hasMany(PostMedia::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags() {
        return $this->hasMany(PostTags::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTypeEnc() {
        return $this->hasOne(PostTypes::className(), ['post_type_enc_id' => 'post_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorEnc() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'author_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

}
