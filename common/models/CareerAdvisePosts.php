<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%career_advise_posts}}".
 *
 * @property int $id Primary Key
 * @property string $post_enc_id Post Encrypted ID
 * @property string $assigned_category_enc_id Foreign Key to AssignedCategories Table
 * @property string $title Post Title
 * @property string $link source url
 * @property string $slug Slug
 * @property string $description Post Description
 * @property string $post_type_enc_id Foreign Key to Post Types Table
 * @property string $image Featured Image
 * @property string $image_location Location of the Featured Image
 * @property string $created_on On which date Post information was added to database
 * @property string $created_by By which User Post information was added
 * @property string $last_updated_on On which date Post information was updated
 * @property string $last_updated_by By which User Post information was updated
 * @property int $status 1 as Published, 0 as Unpublished
 * @property int $is_deleted Is Post Deleted (0 as False, 1 as True)
 *
 * @property AssignedCategories $assignedCategoryEnc
 * @property PostTypes $postTypeEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class CareerAdvisePosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%career_advise_posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_enc_id', 'assigned_category_enc_id', 'title', 'link', 'slug', 'post_type_enc_id', 'created_by'], 'required'],
            [['title'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['post_enc_id', 'assigned_category_enc_id', 'post_type_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['link'], 'string', 'max' => 200],
            [['slug', 'description'], 'string', 'max' => 255],
            [['post_enc_id'], 'unique'],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
            [['post_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostTypes::className(), 'targetAttribute' => ['post_type_enc_id' => 'post_type_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
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
    public function getPostTypeEnc()
    {
        return $this->hasOne(PostTypes::className(), ['post_type_enc_id' => 'post_type_enc_id']);
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
