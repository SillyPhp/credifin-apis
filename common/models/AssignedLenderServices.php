<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_lender_services}}".
 *
 * @property int $id
 * @property string $assigned_lender_service_enc_id assigned_lender_service_enc_id
 * @property string $lender_service_enc_id linked to loan Service
 * @property string $provider_enc_id linked to organization_enc_id
 * @property string $created_by linked to user table
 * @property string $created_on created on
 * @property string $updated_on updated on
 * @property string $updated_by linked to user table
 * @property int $is_deleted 0 false,1 true
 *
 * @property LenderServices $lenderServiceEnc
 * @property Organizations $providerEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property AssignedLoanProvider[] $assignedLoanProviders
 */
class AssignedLenderServices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_lender_services}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_lender_service_enc_id', 'lender_service_enc_id', 'provider_enc_id', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_lender_service_enc_id', 'lender_service_enc_id', 'provider_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_lender_service_enc_id'], 'unique'],
            [['lender_service_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LenderServices::className(), 'targetAttribute' => ['lender_service_enc_id' => 'service_enc_id']],
            [['provider_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['provider_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLenderServiceEnc()
    {
        return $this->hasOne(LenderServices::className(), ['service_enc_id' => 'lender_service_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviderEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'provider_enc_id']);
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
    public function getAssignedLoanProviders()
    {
        return $this->hasMany(AssignedLoanProvider::className(), ['assigned_lender_service_enc_id' => 'assigned_lender_service_enc_id']);
    }
}
