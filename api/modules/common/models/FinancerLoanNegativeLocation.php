<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lJCWPnNNVy3d95ppLp7M_financer_loan_negative_location".
 *
 * @property int $id Primary Key
 * @property string $negative_location_enc_id Negative Location Encrypted ID
 * @property string $financer_enc_id Financer Encrypted ID
 * @property string $user_enc_id User Encrypted ID
 * @property string $address Location Address
 * @property double $radius Location Radius in KM
 * @property double $latitude Location Latitude
 * @property double $longitude Location Longitude
 * @property string $status Location Status
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Location Deleted (0 as False, 1 as True)
 *
 * @property Organizations $financerEnc
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class FinancerLoanNegativeLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lJCWPnNNVy3d95ppLp7M_financer_loan_negative_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['negative_location_enc_id', 'financer_enc_id', 'user_enc_id', 'address', 'radius', 'latitude', 'longitude', 'created_by'], 'required'],
            [['radius', 'latitude', 'longitude'], 'number'],
            [['status'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['negative_location_enc_id', 'financer_enc_id', 'user_enc_id', 'address', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['negative_location_enc_id'], 'unique'],
            [['financer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['financer_enc_id' => 'organization_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
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
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
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
