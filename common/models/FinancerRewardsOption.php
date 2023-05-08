<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_rewards_option}}".
 *
 * @property int $id
 * @property string $financer_rewards_option_enc_id
 * @property string $financer_rewards_enc_id
 * @property string $option_name
 * @property string $is_eligible
 * @property string $icon
 * @property string $icon_location
 * @property string $background_color
 * @property int $sequence
 * @property string $text_color
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted
 *
 * @property FinancerRewards $financerRewardsOptionEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class FinancerRewardsOption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_rewards_option}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_rewards_option_enc_id', 'financer_rewards_enc_id', 'option_name', 'sequence', 'created_by', 'created_on'], 'required'],
            [['is_eligible'], 'string'],
            [['sequence', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['financer_rewards_option_enc_id', 'financer_rewards_enc_id', 'option_name', 'icon', 'icon_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['background_color', 'text_color'], 'string', 'max' => 7],
            [['financer_rewards_option_enc_id'], 'unique'],
            [['financer_rewards_option_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerRewards::className(), 'targetAttribute' => ['financer_rewards_option_enc_id' => 'financer_rewards_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerRewardsOptionEnc()
    {
        return $this->hasOne(FinancerRewards::className(), ['financer_rewards_enc_id' => 'financer_rewards_option_enc_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
