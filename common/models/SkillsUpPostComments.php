<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_post_comments}}".
 *
 * @property int $id Primary Key
 * @property string $comment_enc_id Comment Encrypted ID
 * @property string $comment Post Comment
 * @property string $reply_to Reply to Comment
 * @property string $post_enc_id Foreign Key to Posts Table
 * @property string $created_on On which date Post Comment information was added to database
 * @property string $created_by Foreign Key to Users Table
 * @property string $last_updated_on On which date Post Comment information was updated
 * @property string $last_updated_by
 * @property int $status Post Comment Status (0 as Pending, 1 as Approved, 2 as Rejected)
 * @property int $is_deleted Is Comment Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property SkillsUpPosts $postEnc
 * @property SkillsUpPostComments $replyTo
 * @property SkillsUpPostComments[] $skillsUpPostComments
 */
class SkillsUpPostComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%skills_up_post_comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_enc_id', 'comment', 'post_enc_id', 'created_by'], 'required'],
            [['comment'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['comment_enc_id', 'reply_to', 'post_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['comment_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillsUpPosts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
            [['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => SkillsUpPostComments::className(), 'targetAttribute' => ['reply_to' => 'comment_enc_id']],
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEnc()
    {
        return $this->hasOne(SkillsUpPosts::className(), ['post_enc_id' => 'post_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyTo()
    {
        return $this->hasOne(SkillsUpPostComments::className(), ['comment_enc_id' => 'reply_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostComments()
    {
        return $this->hasMany(SkillsUpPostComments::className(), ['reply_to' => 'comment_enc_id']);
    }
}
