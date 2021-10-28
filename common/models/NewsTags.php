<?php

namespace common\models;

/**
 * This is the model class for table "{{%news_tags}}".
 *
 * @property int $id Primary Key
 * @property string $news_tag_enc_id News Tag Encrypted ID
 * @property string $news_enc_id Foreign Key to External News UpdateTable and Bloging Site Table
 * @property string $assigned_tag_enc_id Foreign Key to AssignedTags Table
 * @property string $created_on On which date Post Tag information was added to database
 * @property string $created_by By which User Post Tag information was added
 * @property string $last_updated_on On which date Post Tag information was updated
 * @property string $last_updated_by By which User Post Tag information was updated
 * @property int $is_deleted is_deleted
 *
 * @property ExternalNewsUpdate[] $externalNewsUpdates
 * @property ExternalNewsUpdate $newsEnc
 * @property AssignedTags $assignedTagEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class NewsTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_tag_enc_id', 'news_enc_id', 'assigned_tag_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['news_tag_enc_id', 'news_enc_id', 'assigned_tag_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['news_tag_enc_id'], 'unique'],
            [['news_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExternalNewsUpdate::className(), 'targetAttribute' => ['news_enc_id' => 'news_enc_id']],
            [['assigned_tag_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedTags::className(), 'targetAttribute' => ['assigned_tag_enc_id' => 'assigned_tag_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalNewsUpdates()
    {
        return $this->hasMany(ExternalNewsUpdate::className(), ['news_tag_enc_id' => 'news_tag_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsEnc()
    {
        return $this->hasOne(ExternalNewsUpdate::className(), ['news_enc_id' => 'news_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTagEnc()
    {
        return $this->hasOne(AssignedTags::className(), ['assigned_tag_enc_id' => 'assigned_tag_enc_id']);
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
