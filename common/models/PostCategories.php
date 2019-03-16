<?php

namespace common\models;

/**
 * This is the model class for table "{{%post_categories}}".
 *
 * @property int $id Primary Key
 * @property string $post_category_enc_id Post Category Encrypted ID
 * @property string $post_enc_id Foreign Key to Posts Table
 * @property string $category_enc_id Foreign Key to Categories Table
 * @property string $created_on On which date Post Category information was added to database
 * @property string $created_by By which User Post Category information was added
 * @property string $last_updated_on On which date Post Category information was updated
 * @property string $last_updated_by By which User Post Category information was updated
 *
 * @property Posts $postEnc
 * @property Categories $categoryEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class PostCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_category_enc_id', 'post_enc_id', 'category_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['post_category_enc_id', 'post_enc_id', 'category_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['post_category_enc_id'], 'unique'],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEnc()
    {
        return $this->hasOne(Posts::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryEnc()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'category_enc_id']);
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
