<?php
namespace common\models;


/**
 * This is the model class for table "{{%referral}}".
 *
 * @property int $id
 * @property string $referral_enc_id referral code enc id
 * @property string $code referral code
 * @property string $referral_link referral_link
 * @property string $user_enc_id user for which the reward should count
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on created on
 * @property string $created_by user who genrated the code
 * @property int $is_deleted weather deleted or not
 *
 * @property Users $createdBy
 * @property Users $userEnc
 * @property Organizations $organizationEnc
 * @property ReferralJobAppliedTracking[] $referralJobAppliedTrackings
 * @property ReferralReviewTracking[] $referralReviewTrackings
 * @property ReferralSignUpTracking[] $referralSignUpTrackings
 * @property WebinarRegistrations[] $webinarRegistrations
 */
class Referral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%referral}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['referral_enc_id', 'code', 'referral_link', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['referral_enc_id', 'code', 'referral_link', 'user_enc_id', 'organization_enc_id', 'created_by'], 'string', 'max' => 100],
            [['referral_enc_id'], 'unique'],
            [['code'], 'unique'],
            [['referral_link'], 'unique'],
            [['user_enc_id', 'organization_enc_id'], 'unique', 'targetAttribute' => ['user_enc_id', 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
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
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferralJobAppliedTrackings()
    {
        return $this->hasMany(ReferralJobAppliedTracking::className(), ['referral_enc_id' => 'referral_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferralReviewTrackings()
    {
        return $this->hasMany(ReferralReviewTracking::className(), ['referral_enc_id' => 'referral_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferralSignUpTrackings()
    {
        return $this->hasMany(ReferralSignUpTracking::className(), ['referral_enc_id' => 'referral_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRegistrations()
    {
        return $this->hasMany(WebinarRegistrations::className(), ['referral_enc_id' => 'referral_enc_id']);
    }
}
