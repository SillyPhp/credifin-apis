<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_agreement_partners}}".
 *
 * @property int $id
 * @property string $agreement_partner_id
 * @property string $agreement_id
 * @property string $partner_org_name
 * @property string $org_id
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignAgreementDetails $agreement
 */
class EsignAgreementPartners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_agreement_partners}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agreement_partner_id', 'agreement_id', 'partner_org_name'], 'required'],
            [['date_created', 'updated_on'], 'safe'],
            [['agreement_partner_id', 'agreement_id', 'partner_org_name', 'org_id'], 'string', 'max' => 200],
            [['agreement_partner_id'], 'unique'],
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
