<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_types}}".
 *
 * @property int $id Primary Key
 * @property string $post_type_enc_id Post Type Encrypted ID
 * @property string $post_type Post Type
 * @property string $slug Post Type Slug
 *
 * @property Posts[] $posts
 */
class PostTypes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%post_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['post_type_enc_id', 'post_type', 'slug'], 'required'],
            [['post_type_enc_id', 'post_type', 'slug'], 'trim'],
            [['post_type_enc_id', 'post_type', 'slug'], 'string', 'max' => 100],
            [['post_type_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['post_type'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'post_type_enc_id' => Yii::t('common', 'Post Type Enc ID'),
            'post_type' => Yii::t('common', 'Post Type'),
            'slug' => Yii::t('common', 'Slug'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts() {
        return $this->hasMany(Posts::className(), ['post_type_enc_id' => 'post_type_enc_id']);
    }

}
