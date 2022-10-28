<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%claimed_deals}}".
 *
 * @property int $id
 * @property string $claimed_deal_enc_id claimed deal enc id
 * @property string $deal_enc_id deal id which claimed
 * @property string $user_enc_id claimed by user id
 * @property string $claimed_coupon_code claimed coupon code
 * @property string $expiry_date expiry date
 * @property string $created_by created by
 * @property string $created_on created on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property AssignedDeals $dealEnc
 * @property Users $userEnc
 * @property Users $createdBy
 */
class ClaimedDeals extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%claimed_deals}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['claimed_deal_enc_id', 'deal_enc_id', 'user_enc_id', 'claimed_coupon_code', 'created_by'], 'required'],
            [['expiry_date', 'created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['claimed_deal_enc_id', 'deal_enc_id', 'user_enc_id', 'created_by'], 'string', 'max' => 100],
            [['claimed_coupon_code'], 'string', 'max' => 50],
            [['claimed_deal_enc_id'], 'unique'],
            [['deal_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedDeals::className(), 'targetAttribute' => ['deal_enc_id' => 'deal_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealEnc()
    {
        return $this->hasOne(AssignedDeals::className(), ['deal_enc_id' => 'deal_enc_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
