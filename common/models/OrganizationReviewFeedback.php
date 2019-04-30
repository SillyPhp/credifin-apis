<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_review_feedback}}".
 *
 * @property int $id Primary Key
 * @property string $feedback_enc_id Feedback Encrypted ID
 * @property string $review_enc_id Foreign Key to Organization Reviews Table
 * @property int $feedback_type Feedback Type (1 as Useful, 2 as Not Useful, 3 as Spam)
 * @property string $feedback Review Feedback
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $created_on On which date Organization Review Feedback information was added to database
 * @property string $created_by By which User Organization Review Feedback information was added
 * @property string $last_updated_on On which date Organization Review Feedback information was updated
 * @property string $last_updated_by By which User Organization Review Feedback information was updated
 * @property int $is_deleted Is Organization Review Feedback Deleted (0 as False, 1 as True)
 *
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property OrganizationReviews $reviewEnc
 */
class OrganizationReviewFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_review_feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feedback_enc_id', 'review_enc_id', 'feedback_type', 'user_enc_id', 'created_by'], 'required'],
            [['feedback_type', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['feedback_enc_id', 'review_enc_id', 'feedback', 'user_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['feedback_enc_id'], 'unique'],
            [['review_enc_id', 'user_enc_id'], 'unique', 'targetAttribute' => ['review_enc_id', 'user_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['review_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationReviews::className(), 'targetAttribute' => ['review_enc_id' => 'review_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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
    public function getReviewEnc()
    {
        return $this->hasOne(OrganizationReviews::className(), ['review_enc_id' => 'review_enc_id']);
    }
}
