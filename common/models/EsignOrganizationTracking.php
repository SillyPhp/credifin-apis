<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_organization_tracking}}".
 *
 * @property int $id
 * @property string $esign_tracking_enc_id e-sign organization tracking enc id
 * @property string $organization_enc_id organization id
 * @property string $employee_id user enc id
 * @property string $legality_document_id legality document id
 * @property string $empower_loans_tracking_id empower loans tracking id
 * @property string $created_by created by id
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Users $employee
 */
class EsignOrganizationTracking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_organization_tracking}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['esign_tracking_enc_id', 'organization_enc_id', 'employee_id', 'legality_document_id', 'empower_loans_tracking_id', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['esign_tracking_enc_id', 'organization_enc_id', 'employee_id', 'legality_document_id', 'empower_loans_tracking_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['esign_tracking_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['employee_id' => 'user_enc_id']],
        ];
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
    public function getEmployee()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'employee_id']);
    }
}
