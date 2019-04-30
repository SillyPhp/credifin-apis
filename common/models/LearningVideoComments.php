<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%learning_video_comments}}".
 *
 * @property int $id Primary Key
 * @property string $comment_enc_id Video Comment Encrypted ID
 * @property string $comment Video Comment
 * @property string $reply_to Reply to Comment
 * @property string $video_enc_id Foreign Key to Learning Videos Table
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $created_on On which date Video Comment information was added to database
 * @property string $last_updated_on On which date Video Comment information was updated
 * @property int $is_deleted Is Comment Deleted (0 as False, 1 as True)
 *
 * @property LearningVideoComments $replyTo
 * @property LearningVideoComments[] $learningVideoComments
 * @property Users $userEnc
 * @property LearningVideos $videoEnc
 */
class LearningVideoComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%learning_video_comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_enc_id', 'comment', 'video_enc_id', 'user_enc_id'], 'required'],
            [['comment'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['comment_enc_id', 'reply_to', 'video_enc_id', 'user_enc_id'], 'string', 'max' => 100],
            [['comment_enc_id'], 'unique'],
            [['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => LearningVideoComments::className(), 'targetAttribute' => ['reply_to' => 'comment_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['video_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningVideos::className(), 'targetAttribute' => ['video_enc_id' => 'video_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyTo()
    {
        return $this->hasOne(LearningVideoComments::className(), ['comment_enc_id' => 'reply_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideoComments()
    {
        return $this->hasMany(LearningVideoComments::className(), ['reply_to' => 'comment_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoEnc()
    {
        return $this->hasOne(LearningVideos::className(), ['video_enc_id' => 'video_enc_id']);
    }
}
