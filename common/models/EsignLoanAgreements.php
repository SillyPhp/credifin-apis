<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_loan_agreements}}".
 *
 * @property int $id
 * @property string $loan_agreements_id
 * @property string $loan_enc_id loan enc id borowed form empower youth database
 * @property string $agreement_id
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignAgreementDetails $agreement
 */
class EsignLoanAgreements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_loan_agreements}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_agreements_id', 'loan_enc_id', 'agreement_id'], 'required'],
            [['date_created', 'updated_on'], 'safe'],
            [['loan_agreements_id', 'loan_enc_id', 'agreement_id'], 'string', 'max' => 200],
            [['loan_agreements_id'], 'unique'],
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
