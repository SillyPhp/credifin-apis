<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_dealer_options}}".
 *
 * @property int $id Primary Id
 * @property string $assigned_dealer_options_enc_id Assigned Dealer Options Enc Id
 * @property string $assigned_dealer_enc_id assigned_financer_dealer_enc_id
 * @property int $trade_advance 1 = TA, 0= NON TA
 * @property int $agreement_status 1 = signed, 0 = not signed
 * @property string $dealership_date
 * @property string $since_with_financer
 * @property string $tc_number
 * @property string $tc_logo
 * @property string $tc_logo_location
 * @property string $category Category
 * @property int $dealer_type 0 is vehicle, 1 is electronics
 * @property string $company_type Company Type
 * @property int $trade_certificate  yes = 1, no= 0
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property AssignedFinancerDealers $assignedDealerEnc
 */
class AssignedDealerOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_dealer_options}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_dealer_options_enc_id', 'assigned_dealer_enc_id', 'category', 'trade_certificate', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['trade_advance', 'agreement_status', 'dealer_type', 'trade_certificate', 'is_deleted'], 'integer'],
            [['dealership_date', 'created_on', 'updated_on'], 'safe'],
            [['assigned_dealer_options_enc_id', 'assigned_dealer_enc_id', 'since_with_financer', 'tc_number', 'tc_logo', 'tc_logo_location', 'category', 'company_type', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_dealer_options_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['assigned_dealer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedFinancerDealers::className(), 'targetAttribute' => ['assigned_dealer_enc_id' => 'assigned_dealer_enc_id']],
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedDealerEnc()
    {
        return $this->hasOne(AssignedFinancerDealers::className(), ['assigned_dealer_enc_id' => 'assigned_dealer_enc_id']);
    }
}
