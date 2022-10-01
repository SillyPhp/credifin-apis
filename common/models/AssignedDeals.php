<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_deals}}".
 *
 * @property int $id
 * @property string $deal_enc_id
 * @property string $deal_type
 * @property int $coupon_type 1 as generated , 2 as entered
 * @property string $coupon_code
 * @property string $name
 * @property string $title Short description
 * @property int $value Amount or percentage value
 * @property string $type
 * @property string $discount_type
 * @property string $expiry_date
 * @property int $is_popular 0 as false , 1 as true
 * @property string $how_to_apply
 * @property string $terms_and_conditions
 * @property string $status
 * @property string $created_by
 * @property string $created_on
 * @property string $last_updated_by
 * @property string $last_updated_on
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property AssignedDealsLocations[] $assignedDealsLocations
 */
class AssignedDeals extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_deals}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_enc_id', 'deal_type', 'title', 'value', 'type', 'discount_type', 'created_by'], 'required'],
            [['deal_type', 'type', 'discount_type', 'how_to_apply', 'terms_and_conditions', 'status'], 'string'],
            [['coupon_type', 'value', 'is_popular', 'is_deleted'], 'integer'],
            [['expiry_date', 'created_on', 'last_updated_on'], 'safe'],
            [['deal_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['coupon_code', 'name'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 255],
            [['deal_enc_id'], 'unique'],
            [['coupon_code'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getAssignedDealsLocations()
    {
        return $this->hasMany(AssignedDealsLocations::className(), ['deal_enc_id' => 'deal_enc_id']);
    }
}
