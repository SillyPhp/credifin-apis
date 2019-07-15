<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%referral_review_tracking}}".
 *
 * @property int $id
 * @property string $tracking_job_enc_id tracking code enc id
 * @property string $referral_enc_id referral code enc id
 * @property string $unclaimed_review_enc_id unclaimed review through referral  id
 * @property string $claimed_review_enc_id claimed review through referral  id
 * @property string $created_on created on
 * @property int $is_deleted weather deleted or not
 *
 * @property Referral $referralEnc
 * @property NewOrganizationReviews $unclaimedReviewEnc
 * @property OrganizationReviews $claimedReviewEnc
 */
class ReferralReviewTracking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%referral_review_tracking}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tracking_job_enc_id', 'referral_enc_id'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['tracking_job_enc_id', 'referral_enc_id', 'unclaimed_review_enc_id', 'claimed_review_enc_id'], 'string', 'max' => 100],
            [['tracking_job_enc_id'], 'unique'],
            [['referral_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_enc_id' => 'referral_enc_id']],
            [['unclaimed_review_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewOrganizationReviews::className(), 'targetAttribute' => ['unclaimed_review_enc_id' => 'review_enc_id']],
            [['claimed_review_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationReviews::className(), 'targetAttribute' => ['claimed_review_enc_id' => 'review_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferralEnc()
    {
        return $this->hasOne(Referral::className(), ['referral_enc_id' => 'referral_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedReviewEnc()
    {
        return $this->hasOne(NewOrganizationReviews::className(), ['review_enc_id' => 'unclaimed_review_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimedReviewEnc()
    {
        return $this->hasOne(OrganizationReviews::className(), ['review_enc_id' => 'claimed_review_enc_id']);
    }
}
