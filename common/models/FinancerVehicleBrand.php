<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_vehicle_brand}}".
 *
 * @property int $id
 * @property string $financer_vehicle_brand_enc_id
 * @property string $organization_enc_id
 * @property string $brand_name
 * @property string $logo
 * @property string $logo_location
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted
 *
 * @property AssignedDealerBrands[] $assignedDealerBrands
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Organizations $organizationEnc
 * @property VehicleRepossession[] $vehicleRepossessions
 */
class FinancerVehicleBrand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_vehicle_brand}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_vehicle_brand_enc_id', 'organization_enc_id', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['financer_vehicle_brand_enc_id', 'organization_enc_id', 'brand_name', 'logo', 'logo_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['financer_vehicle_brand_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedDealerBrands()
    {
        return $this->hasMany(AssignedDealerBrands::className(), ['financer_vehicle_brand_enc_id' => 'financer_vehicle_brand_enc_id']);
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
    public function getVehicleRepossessions()
    {
        return $this->hasMany(VehicleRepossession::className(), ['financer_vehicle_brand_enc_id' => 'financer_vehicle_brand_enc_id']);
    }
}
