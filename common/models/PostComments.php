<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_comments}}".
 *
 * @property int $id Primary Key
 * @property string $comment_enc_id Comment Encrypted ID
 * @property string $comment Post Comment
 * @property string $reply_to Reply to Comment
 * @property string $post_enc_id Foreign Key to Posts Table
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $created_on On which date Post Comment information was added to database
 * @property string $last_updated_on On which date Post Comment information was updated
 * @property int $status Post Comment Status (0 as Pending, 1 as Approved, 2 as Rejected)
 * @property int $is_deleted Is Comment Deleted (0 as False, 1 as True)
 *
 * @property Posts $postEnc
 * @property Users $userEnc
 * @property PostComments $replyTo
 * @property PostComments[] $postComments
 */
class PostComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_enc_id', 'comment', 'post_enc_id', 'user_enc_id'], 'required'],
            [['comment'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['comment_enc_id', 'reply_to', 'post_enc_id', 'user_enc_id'], 'string', 'max' => 100],
            [['comment_enc_id'], 'unique'],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => PostComments::className(), 'targetAttribute' => ['reply_to' => 'comment_enc_id']],
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
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyTo()
    {
        return $this->hasOne(PostComments::className(), ['comment_enc_id' => 'reply_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostComments()
    {
        return $this->hasMany(PostComments::className(), ['reply_to' => 'comment_enc_id']);
    }
}
