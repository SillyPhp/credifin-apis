<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%leads_vehicle_details}}".
 *
 * @property int $id Primary Key
 * @property string $vehicle_details_enc_id Encrypted Key
 * @property string $application_enc_id Leads table Encrypted Key
 * @property int $vehicle_type 1 for 2 wheeler, 2 for 3 wheeler,  3 for 4 four wheeler
 * @property string $vehicle_condition new vehicle or Old vehicle
 * @property string $vehicle_purchase_option vehicle purchased or pre-owned
 * @property string $make name of the manufactured
 * @property string $model_name name of the vehicle model
 * @property string $model_year manufactured date of the vehicle
 * @property string $created_on created on date and time
 * @property string $created_by id of the user who make the entry
 * @property int $is_deleted 0 as not Deleted,1 as Deleted
 *
 * @property LeadsApplications $applicationEnc
 * @property Users $createdBy
 */
class LeadsVehicleDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%leads_vehicle_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_details_enc_id', 'application_enc_id'], 'required'],
            [['vehicle_type', 'is_deleted'], 'integer'],
            [['vehicle_condition', 'vehicle_purchase_option'], 'string'],
            [['created_on'], 'safe'],
            [['vehicle_details_enc_id', 'application_enc_id', 'make', 'model_name', 'model_year', 'created_by'], 'string', 'max' => 100],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeadsApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(LeadsApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
