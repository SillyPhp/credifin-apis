<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%media_types}}".
 *
 * @property int $id Primary Key
 * @property string $media_type_enc_id Media Type Encrypted ID
 * @property string $media_type Media Type
 * @property string $slug Media Type Slug
 *
 * @property PostMedia[] $postMedia
 */
class MediaTypes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%media_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['media_type_enc_id', 'media_type', 'slug'], 'required'],
            [['media_type_enc_id', 'media_type', 'slug'], 'trim'],
            [['media_type_enc_id', 'slug'], 'string', 'max' => 100],
            [['media_type'], 'string', 'max' => 50],
            [['media_type_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['media_type'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'media_type_enc_id' => Yii::t('common', 'Media Type Enc ID'),
            'media_type' => Yii::t('common', 'Media Type'),
            'slug' => Yii::t('common', 'Slug'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMedia() {
        return $this->hasMany(PostMedia::className(), ['media_type_enc_id' => 'media_type_enc_id']);
    }

}
