<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_dealer_brands}}".
 *
 * @property int $id Primary Id
 * @property string $assigned_dealer_brands_enc_id Assigned Dealer Brands Enc Id
 * @property string $organization_enc_id Organization Enc Id
 * @property string $financer_vehicle_brand_enc_id Financer Vehicle Brands Enc Id
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Organizations $organizationEnc
 * @property FinancerVehicleBrand $financerVehicleBrandEnc
 */
class AssignedDealerBrands extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_dealer_brands}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_dealer_brands_enc_id', 'organization_enc_id', 'financer_vehicle_brand_enc_id', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_dealer_brands_enc_id', 'organization_enc_id', 'financer_vehicle_brand_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_dealer_brands_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['financer_vehicle_brand_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerVehicleBrand::className(), 'targetAttribute' => ['financer_vehicle_brand_enc_id' => 'financer_vehicle_brand_enc_id']],
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
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
    public function getFinancerVehicleBrandEnc()
    {
        return $this->hasOne(FinancerVehicleBrand::className(), ['financer_vehicle_brand_enc_id' => 'financer_vehicle_brand_enc_id']);
    }
}
