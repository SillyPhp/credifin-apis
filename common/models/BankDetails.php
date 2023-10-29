<?php

namespace common\models;

/**
 * This is the model class for table "{{%bank_details}}".
 *
 * @property int $id Id
 * @property string $bank_details_enc_id Bank Details Enc Id
 * @property string $organization_enc_id
 * @property string $name Name
 * @property string $bank_name Bank name
 * @property string $bank_account_number Bank Account Number
 * @property string $ifsc_code IFSC Code
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated By
 * @property string $updated_by Updated On
 * @property int $is_deleted Is Deleted
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Organizations $organizationEnc
 */
class BankDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bank_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bank_details_enc_id', 'name', 'bank_name', 'bank_account_number', 'ifsc_code', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['bank_details_enc_id', 'organization_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['name', 'bank_name', 'bank_account_number', 'ifsc_code'], 'string', 'max' => 50],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
