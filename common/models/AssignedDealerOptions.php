<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_dealer_options}}".
 *
 * @property int $id Primary Id
 * @property string $assigned_dealer_options_enc_id Assigned Dealer Options Enc Id
 * @property string $organization_enc_id Organization Enc Id
 * @property string $category Category
 * @property int $dealer_type 0 is vehicle, 1 is electronics
 * @property string $company_type Company Type
 * @property int $trade_certificate Trade Certificate
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Organizations $organizationEnc
 * @property Users $updatedBy
 * @property Users $createdBy
 */
class AssignedDealerOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_dealer_options}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_dealer_options_enc_id', 'organization_enc_id', 'category', 'trade_certificate', 'dealer_type', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['trade_certificate', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['assigned_dealer_options_enc_id', 'organization_enc_id', 'category', 'company_type', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_dealer_options_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
