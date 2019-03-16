<?php

namespace common\models;

/**
 * This is the model class for table "{{%post_media}}".
 *
 * @property int $id Primary Key
 * @property string $post_media_enc_id Post Media Encrypted ID
 * @property string $post_enc_id Foreign Key to Posts Table
 * @property string $media_type_enc_id Foreign Key to Media Types Table
 * @property string $media Post Media
 * @property string $media_location Media Location
 * @property string $title Media Title
 * @property string $alt Alternative Text of Media
 * @property string $created_on On which date Post Media information was added to database
 * @property string $created_by By which User Post Media information was added
 * @property string $last_updated_on On which date Post Media information was updated
 * @property string $last_updated_by By which User Post Media information was updated
 *
 * @property Posts $postEnc
 * @property MediaTypes $mediaTypeEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class PostMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_media_enc_id', 'post_enc_id', 'media_type_enc_id', 'media', 'media_location', 'created_by'], 'required'],
            [['media'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['post_media_enc_id', 'post_enc_id', 'media_type_enc_id', 'title', 'alt', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['media_location'], 'string', 'max' => 200],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
            [['media_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MediaTypes::className(), 'targetAttribute' => ['media_type_enc_id' => 'media_type_enc_id']],
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
    public function getMediaTypeEnc()
    {
        return $this->hasOne(MediaTypes::className(), ['media_type_enc_id' => 'media_type_enc_id']);
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
