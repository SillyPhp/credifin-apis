<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_action_comments}}".
 *
 * @property int $id Primary Key
 * @property string $comment_enc_id Comment Encrypted ID
 * @property string $request_enc_id
 * @property string $comment Post Comment
 * @property string $reply_to Reply to Comment
 * @property int $type 1 is legal, 2 is Accidental, 3 is health, 4 = repo
 * @property string $created_on On which date Post Comment information was added to database
 * @property string $created_by Foreign Key to Users Table
 * @property string $updated_on On which date Post Comment information was updated
 * @property string $updated_by
 * @property int $is_deleted Is Comment Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanActionComments $replyTo
 * @property LoanActionComments[] $loanActionComments
 */
class LoanActionComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_action_comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_enc_id', 'request_enc_id', 'comment', 'type', 'created_by'], 'required'],
            [['comment'], 'string'],
            [['type', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['comment_enc_id', 'request_enc_id', 'reply_to', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['comment_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => LoanActionComments::className(), 'targetAttribute' => ['reply_to' => 'comment_enc_id']],
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyTo()
    {
        return $this->hasOne(LoanActionComments::className(), ['comment_enc_id' => 'reply_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanActionComments()
    {
        return $this->hasMany(LoanActionComments::className(), ['reply_to' => 'comment_enc_id']);
    }
}
