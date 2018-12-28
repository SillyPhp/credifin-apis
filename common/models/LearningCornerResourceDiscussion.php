<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%learning_corner_resource_discussion}}".
 *
 * @property int $id Primary Key
 * @property string $discussion_enc_id Discussion Encrypted ID
 * @property string $resource_enc_id Foreign Key to Submitted Videos Table
 * @property string $comment Comment
 * @property string $reply_to Foreign Key to Learning Corner Resource Discussion Table
 * @property string $created_on On which date Comment information was added to database
 * @property string $created_by By which User Comment information was added
 * @property string $last_updated_on On which date Comment information was updated
 * @property string $last_updated_by By which User Comment information was updated
 * @property string $status Comment Status (Pending, Published, Rejected)
 *
 * @property SubmittedVideos $resourceEnc
 * @property LearningCornerResourceDiscussion $replyTo
 * @property LearningCornerResourceDiscussion[] $learningCornerResourceDiscussions
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class LearningCornerResourceDiscussion extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%learning_corner_resource_discussion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['discussion_enc_id', 'resource_enc_id', 'comment', 'created_on', 'created_by'], 'required'],
            [['comment', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['discussion_enc_id', 'resource_enc_id', 'reply_to', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['discussion_enc_id'], 'unique'],
            [['resource_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubmittedVideos::className(), 'targetAttribute' => ['resource_enc_id' => 'video_enc_id']],
            [['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => LearningCornerResourceDiscussion::className(), 'targetAttribute' => ['reply_to' => 'discussion_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResourceEnc() {
        return $this->hasOne(SubmittedVideos::className(), ['video_enc_id' => 'resource_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyTo() {
        return $this->hasOne(LearningCornerResourceDiscussion::className(), ['discussion_enc_id' => 'reply_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningCornerResourceDiscussions() {
        return $this->hasMany(LearningCornerResourceDiscussion::className(), ['reply_to' => 'discussion_enc_id']);
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
