<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar_reward_certificates}}".
 *
 * @property int $id
 * @property string $reward_certificate_enc_id encripted key
 * @property string $webinar_reward_enc_id Foriegn key to Webinar Reward table
 * @property string $name
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property WebinarRewards $webinarRewardEnc
 */
class WebinarRewardCertificates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%webinar_reward_certificates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reward_certificate_enc_id', 'webinar_reward_enc_id', 'name', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['reward_certificate_enc_id', 'webinar_reward_enc_id', 'name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['reward_certificate_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['webinar_reward_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarRewards::className(), 'targetAttribute' => ['webinar_reward_enc_id' => 'webinar_reward_enc_id']],
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRewardEnc()
    {
        return $this->hasOne(WebinarRewards::className(), ['webinar_reward_enc_id' => 'webinar_reward_enc_id']);
    }
}
