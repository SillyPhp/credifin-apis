<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_dealer_vehicle_types}}".
 *
 * @property int $id Primary Id
 * @property string $assigned_dealer_vehicle_type_enc_id
 * @property string $organization_enc_id Organization Enc Id
 * @property string $financer_vehicle_type_enc_id
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Organizations $organizationEnc
 * @property FinancerVehicleTypes $financerVehicleTypeEnc
 */
class AssignedDealerVehicleTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_dealer_vehicle_types}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_dealer_vehicle_type_enc_id', 'organization_enc_id', 'financer_vehicle_type_enc_id', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_dealer_vehicle_type_enc_id', 'organization_enc_id', 'financer_vehicle_type_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_dealer_vehicle_type_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['financer_vehicle_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerVehicleTypes::className(), 'targetAttribute' => ['financer_vehicle_type_enc_id' => 'financer_vehicle_type_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assigned_dealer_vehicle_type_enc_id' => 'Assigned Dealer Vehicle Type Enc ID',
            'organization_enc_id' => 'Organization Enc ID',
            'financer_vehicle_type_enc_id' => 'Financer Vehicle Type Enc ID',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
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
    public function getFinancerVehicleTypeEnc()
    {
        return $this->hasOne(FinancerVehicleTypes::className(), ['financer_vehicle_type_enc_id' => 'financer_vehicle_type_enc_id']);
    }
}
