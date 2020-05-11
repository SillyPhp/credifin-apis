<?php

namespace common\models;

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
 * @property string $last_updated_by By which User Tag information was updated
 *
 * @property AssignedTags[] $assignedTags
 * @property LearningVideoTags[] $learningVideoTags
 * @property LearningVideos[] $videoEncs
 * @property PostTags[] $postTags
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_enc_id', 'name', 'slug', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['tag_enc_id', 'name', 'slug', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['tag_enc_id'], 'unique'],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTags()
    {
        return $this->hasMany(AssignedTags::className(), ['tag_enc_id' => 'tag_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoTags()
    {
        return $this->hasMany(LearningVideoTags::className(), ['tag_enc_id' => 'tag_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoEncs()
    {
        return $this->hasMany(LearningVideos::className(), ['video_enc_id' => 'video_enc_id'])->viaTable('{{%learning_video_tags}}', ['tag_enc_id' => 'tag_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTags::className(), ['tag_enc_id' => 'tag_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}