<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%online_class_comments}}".
 *
 * @property int $id
 * @property string $comment_enc_id comment encrypted id
 * @property string $comment comment
 * @property string $reply_to reply to comment
 * @property string $class_enc_id class encrypted id
 * @property string $user_enc_id user encrypted id
 * @property int $is_visible 0 visible to only teacher,1 visible to all
 * @property string $created_on created on time
 * @property string $updated_on updated on time
 * @property string $updated_by updated encrypted id
 * @property int $status Comment Status (0 as Pending, 1 as Approved, 2 as Rejected)
 * @property int $is_deleted Is Comment Deleted (0 as False, 1 as True)
 *
 * @property OnlineClasses $classEnc
 * @property Users $userEnc
 * @property OnlineClassComments $replyTo
 * @property OnlineClassComments[] $onlineClassComments
 * @property Users $updatedBy
 */
class OnlineClassComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%online_class_comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_enc_id', 'comment', 'class_enc_id', 'user_enc_id'], 'required'],
            [['comment'], 'string'],
            [['is_visible', 'status', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['comment_enc_id', 'reply_to', 'class_enc_id', 'user_enc_id', 'updated_by'], 'string', 'max' => 100],
            [['comment_enc_id'], 'unique'],
            [['class_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OnlineClasses::className(), 'targetAttribute' => ['class_enc_id' => 'class_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => OnlineClassComments::className(), 'targetAttribute' => ['reply_to' => 'comment_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassEnc()
    {
        return $this->hasOne(OnlineClasses::className(), ['class_enc_id' => 'class_enc_id']);
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
        return $this->hasOne(OnlineClassComments::className(), ['comment_enc_id' => 'reply_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineClassComments()
    {
        return $this->hasMany(OnlineClassComments::className(), ['reply_to' => 'comment_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
