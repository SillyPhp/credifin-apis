<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_rewards}}".
 *
 * @property int $id Primary Key
 * @property string $financer_rewards_enc_id
 * @property string $financer_enc_id
 * @property string $loan_product_enc_id
 * @property string $name
 * @property string $short_description
 * @property string $image
 * @property string $image_location
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property string $game_type
 * @property string $terms
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted
 *
 * @property Organizations $financerEnc
 * @property FinancerLoanProducts $loanProductEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property FinancerRewardsOptions $financerRewardsOption
 */
class FinancerRewards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_rewards}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_rewards_enc_id', 'financer_enc_id', 'name', 'created_by'], 'required'],
            [['start_date', 'end_date', 'created_on', 'updated_on'], 'safe'],
            [['status', 'game_type', 'terms'], 'string'],
            [['is_deleted'], 'integer'],
            [['financer_rewards_enc_id', 'financer_enc_id', 'loan_product_enc_id', 'name', 'image', 'image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 250],
            [['financer_rewards_enc_id'], 'unique'],
            [['financer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['financer_enc_id' => 'organization_enc_id']],
            [['loan_product_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProducts::className(), 'targetAttribute' => ['loan_product_enc_id' => 'financer_loan_product_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'financer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanProductEnc()
    {
        return $this->hasOne(FinancerLoanProducts::className(), ['financer_loan_product_enc_id' => 'loan_product_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerRewardsOption()
    {
        return $this->hasOne(FinancerRewardsOptions::className(), ['financer_rewards_option_enc_id' => 'financer_rewards_enc_id']);
    }
}
