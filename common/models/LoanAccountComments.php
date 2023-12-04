<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_account_comments}}".
 *
 * @property int $id Primary Key
 * @property string $comment_enc_id Comment Encrypted ID
 * @property string $loan_account_enc_id loan_application_enc_id
 * @property string $comment Post Comment
 * @property string $reply_to Reply to Comment
 * @property int $is_important 0 false, 1 true
 * @property string $created_on On which date Post Comment information was added to database
 * @property string $created_by Foreign Key to Users Table
 * @property string $last_updated_on On which date Post Comment information was updated
 * @property string $last_updated_by
 * @property int $status Post Comment Status (0 as Pending, 1 as Approved, 2 as Rejected)
 * @property string $source
 * @property int $is_deleted Is Comment Deleted (0 as False, 1 as True)
 *
 * @property LoanAccounts $loanAccountEnc
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property LoanAccountComments $replyTo
 * @property LoanAccountComments[] $loanAccountComments
 */
class LoanAccountComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_account_comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_enc_id', 'loan_account_enc_id', 'comment', 'created_by'], 'required'],
            [['comment', 'source'], 'string'],
            [['is_important', 'status', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['comment_enc_id', 'loan_account_enc_id', 'reply_to', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['comment_enc_id'], 'unique'],
            [['loan_account_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanAccounts::className(), 'targetAttribute' => ['loan_account_enc_id' => 'loan_account_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => LoanAccountComments::className(), 'targetAttribute' => ['reply_to' => 'comment_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountEnc()
    {
        return $this->hasOne(LoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyTo()
    {
        return $this->hasOne(LoanAccountComments::className(), ['comment_enc_id' => 'reply_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountComments()
    {
        return $this->hasMany(LoanAccountComments::className(), ['reply_to' => 'comment_enc_id']);
    }
}
