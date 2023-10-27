<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_deals_locations}}".
 *
 * @property int $id
 * @property string $assign_deal_enc_id
 * @property string $deal_enc_id
 * @property string $location_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property string $last_updated_by
 * @property string $last_updated_on
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property AssignedDeals $dealEnc
 * @property UnclaimOrganizationLocations $locationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class AssignedDealsLocations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_deals_locations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assign_deal_enc_id', 'deal_enc_id', 'location_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assign_deal_enc_id', 'deal_enc_id', 'location_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['deal_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedDeals::className(), 'targetAttribute' => ['deal_enc_id' => 'deal_enc_id']],
            [['location_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimOrganizationLocations::className(), 'targetAttribute' => ['location_enc_id' => 'location_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealEnc()
    {
        return $this->hasOne(AssignedDeals::className(), ['deal_enc_id' => 'deal_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationEnc()
    {
        return $this->hasOne(UnclaimOrganizationLocations::className(), ['location_enc_id' => 'location_enc_id']);
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
}
