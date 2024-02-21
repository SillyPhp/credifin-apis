<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_application_partners}}".
 *
 * @property int $id
 * @property string $loan_application_partner_enc_id loan application partner enc id
 * @property string $loan_app_enc_id loan application enc id
 * @property string $provider_enc_id loan provider enc id
 * @property string $partner_enc_id partner enc id
 * @property string $type type
 * @property double $ltv LTV in percentage
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property LoanApplications $loanAppEnc
 * @property Organizations $providerEnc
 * @property Organizations $partnerEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class LoanApplicationPartners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_partners}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_application_partner_enc_id', 'loan_app_enc_id', 'provider_enc_id', 'partner_enc_id', 'created_by'], 'required'],
            [['type'], 'string'],
            [['ltv'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_application_partner_enc_id', 'loan_app_enc_id', 'provider_enc_id', 'partner_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['loan_application_partner_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['provider_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['provider_enc_id' => 'organization_enc_id']],
            [['partner_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['partner_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
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
    public function getPartnerEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'partner_enc_id']);
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
