<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar_payments}}".
 *
 * @property int $id
 * @property string $payment_enc_id loan payment encrypted id
 * @property string $webinar_enc_id loan application enc id
 * @property string $payment_token payment id
 * @property double $payment_amount
 * @property double $payment_gst
 * @property string $payment_id transaction id
 * @property string $payment_status payment status
 * @property int $payment_mode 0 as gateway payment, 1 as NEFT, 2 as RTGS, 3 as IMPS, 4 as Cheque, 5 as UPI, 6 as DD
 * @property string $reference_number Number of payment mode
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property Webinars $webinarEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class WebinarPayments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_payments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_enc_id', 'webinar_enc_id', 'payment_token', 'payment_amount', 'created_by'], 'required'],
            [['payment_amount', 'payment_gst'], 'number'],
            [['payment_mode'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['payment_enc_id', 'webinar_enc_id', 'payment_token', 'payment_id', 'payment_status', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['reference_number'], 'string', 'max' => 50],
            [['payment_enc_id'], 'unique'],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinars::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinars::className(), ['webinar_enc_id' => 'webinar_enc_id']);
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
