<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%institute_leads_payments}}".
 *
 * @property int $id
 * @property string $payment_enc_id loan payment encrypted id
 * @property string $lead_enc_id loan application enc id
 * @property string $payment_token payment id
 * @property string $payment_short_url in case of razor pay
 * @property double $payment_amount
 * @property double $payment_gst
 * @property string $payment_id transaction id
 * @property string $payment_status payment status
 * @property int $payment_mode 0 as gateway payment, 1 as NEFT, 2 as RTGS, 3 as IMPS, 4 as Cheque, 5 as UPI, 6 as DD
 * @property string $reference_number Number of payment mode
 * @property string $remarks Any remarks or reason for Refund
 * @property string $payment_signature
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property InstituteLeads $leadEnc
 */
class InstituteLeadsPayments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%institute_leads_payments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_enc_id', 'lead_enc_id', 'payment_token', 'payment_amount', 'payment_gst'], 'required'],
            [['payment_amount', 'payment_gst'], 'number'],
            [['payment_mode'], 'integer'],
            [['remarks'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['payment_enc_id', 'lead_enc_id', 'payment_token', 'payment_short_url', 'payment_id', 'payment_status', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['reference_number'], 'string', 'max' => 50],
            [['payment_signature'], 'string', 'max' => 255],
            [['payment_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['lead_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstituteLeads::className(), 'targetAttribute' => ['lead_enc_id' => 'lead_enc_id']],
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
    public function getLeadEnc()
    {
        return $this->hasOne(InstituteLeads::className(), ['lead_enc_id' => 'lead_enc_id']);
    }
}
