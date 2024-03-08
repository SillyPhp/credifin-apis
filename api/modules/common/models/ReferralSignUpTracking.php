<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%referral_sign_up_tracking}}".
 *
 * @property int $id
 * @property string $tracking_signup_enc_id tracking code enc id
 * @property string $referral_enc_id referral code enc id
 * @property string $sign_up_user_enc_id user who signed up through referra; id
 * @property string $sign_up_org_enc_id org who signed up through referra; id
 * @property string $created_on created on
 * @property int $is_deleted weather deleted or not
 *
 * @property Referral $referralEnc
 * @property Users $signUpUserEnc
 */
class ReferralSignUpTracking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%referral_sign_up_tracking}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tracking_signup_enc_id', 'referral_enc_id'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['tracking_signup_enc_id', 'referral_enc_id', 'sign_up_user_enc_id', 'sign_up_org_enc_id'], 'string', 'max' => 100],
            [['tracking_signup_enc_id'], 'unique'],
            [['referral_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Referral::className(), 'targetAttribute' => ['referral_enc_id' => 'referral_enc_id']],
            [['sign_up_user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sign_up_user_enc_id' => 'user_enc_id']],
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
    public function getSignUpUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'sign_up_user_enc_id']);
    }
}
