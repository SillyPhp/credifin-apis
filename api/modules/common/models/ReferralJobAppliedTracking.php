<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%referral_job_applied_tracking}}".
 *
 * @property int $id
 * @property string $tracking_job_enc_id tracking code enc id
 * @property string $referral_enc_id referral code enc id
 * @property string $applied_enc_id unclaimed review through referral  id
 * @property string $created_on created on
 * @property int $is_deleted weather deleted or not
 *
 * @property Referral $referralEnc
 * @property AppliedApplications $appliedEnc
 */
class ReferralJobAppliedTracking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%referral_job_applied_tracking}}';
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
            [['tracking_job_enc_id', 'referral_enc_id', 'applied_enc_id'], 'string', 'max' => 100],
            [['tracking_job_enc_id'], 'unique'],
            [['referral_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_enc_id' => 'referral_enc_id']],
            [['applied_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedApplications::className(), 'targetAttribute' => ['applied_enc_id' => 'applied_application_enc_id']],
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
    public function getAppliedEnc()
    {
        return $this->hasOne(AppliedApplications::className(), ['applied_application_enc_id' => 'applied_enc_id']);
    }
}
