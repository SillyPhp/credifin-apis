<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_review_like_dislike}}".
 *
 * @property int $id Primary Key
 * @property string $feedback_enc_id Feedback Encrypted ID
 * @property int $feedback_type Feedback Type (0 as Not Useful, 1 as Useful)
 * @property string $review_enc_id Foreign Key to Organization Reviews Table
 * @property string $created_on On which date Organization Review Like Dislike information was added to database
 * @property string $created_by By which User Organization Review Like Dislike information was added
 * @property string $last_updated_on On which date Organization Review Like Dislike information was updated
 * @property string $last_updated_by By which User Organization Review Like Dislike  information was updated
 *
 * @property Users $createdBy
 * @property OrganizationReviews $reviewEnc
 * @property Users $lastUpdatedBy
 */
class OrganizationReviewLikeDislike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_review_like_dislike}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feedback_enc_id', 'feedback_type', 'review_enc_id', 'created_by'], 'required'],
            [['feedback_type'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['feedback_enc_id', 'review_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['feedback_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['review_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationReviews::className(), 'targetAttribute' => ['review_enc_id' => 'review_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getReviewEnc()
    {
        return $this->hasOne(OrganizationReviews::className(), ['review_enc_id' => 'review_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }
}