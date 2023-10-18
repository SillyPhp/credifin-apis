<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%vehicle_repossession}}".
 *
 * @property int $id Primary Id
 * @property string $vehicle_repossession_enc_id
 * @property string $loan_account_enc_id
 * @property string $financer_vehicle_brand_enc_id
 * @property string $vehicle_model
 * @property double $km_driven
 * @property int $insurance 1 = true, 0 = false
 * @property int $rc 1 = true, 0 = false
 * @property string $registration_number
 * @property double $current_market_value
 * @property string $repossession_date
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property VehicleRepoComments[] $vehicleRepoComments
 * @property LoanAccounts $loanAccountEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property FinancerVehicleBrand $financerVehicleBrandEnc
 * @property VehicleRepossessionImages[] $vehicleRepossessionImages
 */
class VehicleRepossession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vehicle_repossession}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_repossession_enc_id', 'loan_account_enc_id', 'financer_vehicle_brand_enc_id', 'vehicle_model', 'km_driven', 'current_market_value', 'repossession_date', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['km_driven', 'current_market_value'], 'number'],
            [['insurance', 'rc', 'is_deleted'], 'integer'],
            [['repossession_date', 'created_on', 'updated_on'], 'safe'],
            [['vehicle_repossession_enc_id', 'loan_account_enc_id', 'financer_vehicle_brand_enc_id', 'vehicle_model', 'registration_number', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['vehicle_repossession_enc_id'], 'unique'],
            [['loan_account_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanAccounts::className(), 'targetAttribute' => ['loan_account_enc_id' => 'loan_account_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['financer_vehicle_brand_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerVehicleBrand::className(), 'targetAttribute' => ['financer_vehicle_brand_enc_id' => 'financer_vehicle_brand_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleRepoComments()
    {
        return $this->hasMany(VehicleRepoComments::className(), ['vehicle_repossession_enc_id' => 'vehicle_repossession_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountEnc()
    {
        return $this->hasOne(LoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
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
    public function getFinancerVehicleBrandEnc()
    {
        return $this->hasOne(FinancerVehicleBrand::className(), ['financer_vehicle_brand_enc_id' => 'financer_vehicle_brand_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleRepossessionImages()
    {
        return $this->hasMany(VehicleRepossessionImages::className(), ['vehicle_repossession_enc_id' => 'vehicle_repossession_enc_id']);
    }
}
