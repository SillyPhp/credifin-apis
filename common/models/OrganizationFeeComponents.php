<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_fee_components}}".
 *
 * @property int $id Primary Key
 * @property string $fee_component_enc_id Fee Component Encrypted ID
 * @property string $name Fee Component Name
 * @property string $created_by
 * @property string $created_on
 *
 * @property AssignedOrganizationFeeComponent[] $assignedOrganizationFeeComponents
 * @property Users $createdBy
 */
class OrganizationFeeComponents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_fee_components}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fee_component_enc_id', 'name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['fee_component_enc_id', 'name', 'created_by'], 'string', 'max' => 100],
            [['fee_component_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedOrganizationFeeComponents()
    {
        return $this->hasMany(AssignedOrganizationFeeComponent::className(), ['fee_component_enc_id' => 'fee_component_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
