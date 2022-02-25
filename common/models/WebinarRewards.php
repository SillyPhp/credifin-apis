<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar_rewards}}".
 *
 * @property int $id
 * @property string $webinar_reward_enc_id reward table encripted id
 * @property string $webinar_enc_id Foreign Key to webinar table
 * @property string $position_enc_id Foreign Key to rewards position pool table
 * @property string $amount reward amount in string
 * @property double $price reward price in number
 * @property int $sequence
 * @property string $created_by
 * @property string $created_on
 * @property string $last_updated_by
 * @property string $last_updated_on
 * @property int $is_deleted
 *
 * @property WebinarRewardCertificates[] $webinarRewardCertificates
 * @property Webinar $webinarEnc
 * @property RewardPositionPool $positionEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class WebinarRewards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%webinar_rewards}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['webinar_reward_enc_id', 'webinar_enc_id', 'position_enc_id', 'sequence', 'created_by'], 'required'],
            [['price'], 'number'],
            [['sequence', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['webinar_reward_enc_id', 'webinar_enc_id', 'position_enc_id', 'amount', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['webinar_reward_enc_id'], 'unique'],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinar::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
            [['position_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => RewardPositionPool::className(), 'targetAttribute' => ['position_enc_id' => 'position_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRewardCertificates()
    {
        return $this->hasMany(WebinarRewardCertificates::className(), ['webinar_reward_enc_id' => 'webinar_reward_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinar::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionEnc()
    {
        return $this->hasOne(RewardPositionPool::className(), ['position_enc_id' => 'position_enc_id']);
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
}
