<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%referral}}".
 *
 * @property int $id Primary Key
 * @property string $referral_enc_id Referral Code Encrypted ID
 * @property string $code Referral Code
 * @property string $referral_link Referral Link
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Referral Information was added to Datatabase
 * @property string $created_by By which User Referral Information was added to Database
 * @property int $is_deleted Is Referral Code Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $userEnc
 * @property Organizations $organizationEnc
 * @property ReferralSignUpTracking[] $referralSignUpTrackings
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
    public function getReferralSignUpTrackings()
    {
        return $this->hasMany(ReferralSignUpTracking::className(), ['referral_enc_id' => 'referral_enc_id']);
    }
}