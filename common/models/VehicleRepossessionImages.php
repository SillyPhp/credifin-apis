<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%vehicle_repossession_images}}".
 *
 * @property int $id Primary Id
 * @property string $vehicle_repossession_images_enc_id
 * @property string $vehicle_repossession_enc_id
 * @property int $image_type 1 = front, 2 = back, 3 = left, 4= right
 * @property string $image
 * @property string $image_location
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanActionRequests $vehicleRepossessionEnc
 */
class VehicleRepossessionImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vehicle_repossession_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_repossession_images_enc_id', 'vehicle_repossession_enc_id', 'image_type', 'image', 'image_location', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['image_type', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['vehicle_repossession_images_enc_id', 'vehicle_repossession_enc_id', 'image', 'image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['vehicle_repossession_images_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['vehicle_repossession_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanActionRequests::className(), 'targetAttribute' => ['vehicle_repossession_enc_id' => 'request_enc_id']],
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
    public function getVehicleRepossessionEnc()
    {
        return $this->hasOne(LoanActionRequests::className(), ['request_enc_id' => 'vehicle_repossession_enc_id']);
    }
}
