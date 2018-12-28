<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_media}}".
 *
 * @property integer $id
 * @property string $post_media_enc_id
 * @property string $post_enc_id
 * @property string $media_type_enc_id
 * @property string $media
 * @property string $media_location
 * @property string $title
 * @property string $alt
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Users $lastUpdatedBy
 * @property Posts $postEnc
 * @property MediaTypes $mediaTypeEnc
 * @property Users $createdBy
 */
class PostMedia extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%post_media}}';
    }

    /**
     * @inheritdoc
     */
    public $medias;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['post_media_enc_id', 'post_enc_id', 'media', 'media_location', 'created_on', 'created_by'], 'required'],
            [['media'], 'string'],
            ['medias', 'each', 'rule' => ['file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 5, 'maxFiles' => 10]],
            [['created_on', 'last_updated_on'], 'safe'],
            [['post_media_enc_id', 'post_enc_id', 'media_type_enc_id', 'title', 'alt', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['media_location'], 'string', 'max' => 200],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
            [['media_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MediaTypes::className(), 'targetAttribute' => ['media_type_enc_id' => 'media_type_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'media_type_enc_id' => Yii::t('common', 'Media Type'),
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
    public function getMediaTypeEnc() {
        return $this->hasOne(MediaTypes::className(), ['media_type_enc_id' => 'media_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

}
