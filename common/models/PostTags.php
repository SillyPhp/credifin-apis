<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_tags}}".
 *
 * @property integer $id
 * @property string $post_tag_enc_id
 * @property string $post_enc_id
 * @property string $tag_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Users $lastUpdatedBy
 * @property Posts $postEnc
 * @property Tags $tagEnc
 * @property Users $createdBy
 */
class PostTags extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%post_tags}}';
    }

    /**
     * @inheritdoc
     */
    public $tags;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['post_tag_enc_id', 'post_enc_id', 'tag_enc_id', 'created_on', 'created_by', 'tags'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['post_tag_enc_id', 'post_enc_id', 'tag_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['post_tag_enc_id'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
            [['tag_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_enc_id' => 'tag_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'post_tag_enc_id' => Yii::t('common', 'Post Tag Enc ID'),
            'post_enc_id' => Yii::t('common', 'Post Enc ID'),
            'tag_enc_id' => Yii::t('common', 'Tag Enc ID'),
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
    public function getTagEnc() {
        return $this->hasOne(Tags::className(), ['tag_enc_id' => 'tag_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

}
