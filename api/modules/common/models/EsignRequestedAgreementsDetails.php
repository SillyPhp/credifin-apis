<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_requested_agreements_details}}".
 *
 * @property int $id
 * @property string $signer_id
 * @property string $request_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $active
 * @property string $private_url
 * @property string $auth_type
 * @property string $auth_method
 * @property string $is_signed
 * @property string $expiryDate
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignRequestedAgreements $request
 */
class EsignRequestedAgreementsDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_requested_agreements_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['signer_id', 'request_id', 'name', 'private_url', 'expiryDate'], 'required'],
            [['active', 'auth_type', 'auth_method', 'is_signed'], 'string'],
            [['expiryDate', 'date_created', 'updated_on'], 'safe'],
            [['signer_id', 'request_id', 'name', 'phone', 'email', 'private_url'], 'string', 'max' => 200],
            [['signer_id'], 'unique'],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => EsignRequestedAgreements::className(), 'targetAttribute' => ['request_id' => 'request_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(EsignRequestedAgreements::className(), ['request_id' => 'request_id']);
    }
}
