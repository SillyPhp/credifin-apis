<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property int $id Primary Key
 * @property string $tag_enc_id Tag Encrypted ID
 * @property string $name Tag Name
 * @property string $slug Tag Slug
 * @property string $created_on On which date Tag information was added to database
 * @property string $created_by By which User Tag  information was added
 * @property string $last_updated_on On which date Tag information was updated
 * @property string $last_updated_by  By which User Tag information was updated
 *
 * @property PostTags[] $postTags
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class Tags extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tag_enc_id', 'name', 'slug', 'created_on', 'created_by'], 'required'],
            [['tag_enc_id', 'name', 'slug'], 'trim'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['tag_enc_id', 'name', 'slug', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['tag_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['name'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'tag_enc_id' => Yii::t('common', 'Tag Enc ID'),
            'name' => Yii::t('common', 'Name'),
            'slug' => Yii::t('common', 'Slug'),
            'created_on' => Yii::t('common', 'Created On'),
            'created_by' => Yii::t('common', 'Created By'),
            'last_updated_on' => Yii::t('common', 'Last Updated On'),
            'last_updated_by' => Yii::t('common', 'Last Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags() {
        return $this->hasMany(PostTags::className(), ['tag_enc_id' => 'tag_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

}
