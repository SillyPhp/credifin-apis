<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_organization_fee_component}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_fee_component_enc_id
 * @property string $fee_component_enc_id
 * @property string $organization_enc_id
 * @property int $status 0 as Inactive, 1 as Active
 * @property string $created_on
 * @property string $created_by
 * @property int $is_deleted
 *
 * @property OrganizationFeeComponents $feeComponentEnc
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 */
class AssignedOrganizationFeeComponent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_organization_fee_component}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_fee_component_enc_id', 'fee_component_enc_id', 'organization_enc_id', 'created_by'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['created_on'], 'safe'],
            [['assigned_fee_component_enc_id', 'fee_component_enc_id', 'organization_enc_id', 'created_by'], 'string', 'max' => 100],
            [['assigned_fee_component_enc_id'], 'unique'],
            [['fee_component_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationFeeComponents::className(), 'targetAttribute' => ['fee_component_enc_id' => 'fee_component_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeComponentEnc()
    {
        return $this->hasOne(OrganizationFeeComponents::className(), ['fee_component_enc_id' => 'fee_component_enc_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
