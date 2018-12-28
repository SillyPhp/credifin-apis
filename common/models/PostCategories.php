<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_categories}}".
 *
 * @property integer $id
 * @property string $post_category_enc_id
 * @property string $post_enc_id
 * @property string $category_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Users $lastUpdatedBy
 * @property Posts $postEnc
 * @property Categories $categoryEnc
 * @property Users $createdBy
 */
class PostCategories extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%post_categories}}';
    }

    /**
     * @inheritdoc
     */
    public $categories;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['post_category_enc_id', 'post_enc_id', 'category_enc_id', 'created_on', 'created_by', 'categories'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['post_category_enc_id', 'post_enc_id', 'category_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['post_category_enc_id'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'post_category_enc_id' => Yii::t('common', 'Post Category Enc ID'),
            'post_enc_id' => Yii::t('common', 'Post Enc ID'),
            'category_enc_id' => Yii::t('common', 'Category Enc ID'),
            'created_on' => Yii::t('common', 'Created On'),
            'created_by' => Yii::t('common', 'Created By'),
            'last_updated_on' => Yii::t('common', 'Last Updated On'),
            'last_updated_by' => Yii::t('common', 'Last Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEnc() {
        return $this->hasOne(Posts::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryEnc() {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

}
