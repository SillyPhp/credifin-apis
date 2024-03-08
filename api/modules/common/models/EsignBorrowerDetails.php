<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_borrower_details}}".
 *
 * @property int $id
 * @property string $borrower_id
 * @property string $agreement_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $aadhaar_number
 * @property string $full_address
 * @property string $type
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignAgreementDetails $agreement
 */
class EsignBorrowerDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_borrower_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['borrower_id', 'agreement_id', 'name', 'phone', 'type'], 'required'],
            [['full_address', 'type'], 'string'],
            [['date_created', 'updated_on'], 'safe'],
            [['borrower_id', 'agreement_id', 'name', 'phone', 'email', 'aadhaar_number'], 'string', 'max' => 200],
            [['borrower_id'], 'unique'],
            [['agreement_id'], 'exist', 'skipOnError' => true, 'targetClass' => EsignAgreementDetails::className(), 'targetAttribute' => ['agreement_id' => 'agreement_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgreement()
    {
        return $this->hasOne(EsignAgreementDetails::className(), ['agreement_id' => 'agreement_id']);
    }
}
