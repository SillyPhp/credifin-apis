<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_financer_dealers}}".
 *
 * @property int $id
 * @property string $assigned_dealer_enc_id
 * @property string $assigned_financer_enc_id
 * @property string $dealer_enc_id Foreign key to organizations table
 * @property string $created_on
 * @property string $created_by Foreign key to users table
 * @property string $updated_on
 * @property string $updated_by Foreign key to users table
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property AssignedDealerBrands[] $assignedDealerBrands
 * @property AssignedDealerOptions[] $assignedDealerOptions
 * @property AssignedDealerVehicleTypes[] $assignedDealerVehicleTypes
 * @property Organizations $dealerEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class AssignedFinancerDealers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_financer_dealers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_dealer_enc_id', 'assigned_financer_enc_id', 'dealer_enc_id', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_dealer_enc_id', 'assigned_financer_enc_id', 'dealer_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_dealer_enc_id'], 'unique'],
            [['dealer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['dealer_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedDealerBrands()
    {
        return $this->hasMany(AssignedDealerBrands::className(), ['assigned_dealer_enc_id' => 'assigned_dealer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedDealerOptions()
    {
        return $this->hasMany(AssignedDealerOptions::className(), ['assigned_dealer_enc_id' => 'assigned_dealer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedDealerVehicleTypes()
    {
        return $this->hasMany(AssignedDealerVehicleTypes::className(), ['assigned_dealer_enc_id' => 'assigned_dealer_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'dealer_enc_id']);
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
