<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_review_like_dislike}}".
 *
 * @property int $id id
 * @property string $feedback_enc_id primary key
 * @property int $feedback_type 0 as not usefull 1 as usefull
 * @property string $review_enc_id review id linked to reviews table
 * @property string $created_on date on which its created
 * @property string $created_by user id
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Users $createdBy
 * @property OrganizationReviews $reviewEnc
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
            [['created_on', 'last_updated_on', 'last_updated_by'], 'safe'],
            [['feedback_enc_id', 'review_enc_id', 'created_by'], 'string', 'max' => 100],
            [['feedback_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['review_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationReviews::className(), 'targetAttribute' => ['review_enc_id' => 'review_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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
}
