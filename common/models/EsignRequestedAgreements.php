<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_requested_agreements}}".
 *
 * @property int $id
 * @property string $request_id
 * @property string $doc_id
 * @property string $agreement_id
 * @property string $leegality_document_id
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignDocuments $doc
 * @property EsignAgreementDetails $agreement
 * @property EsignRequestedAgreementsDetails[] $esignRequestedAgreementsDetails
 */
class EsignRequestedAgreements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_requested_agreements}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'doc_id', 'agreement_id'], 'required'],
            [['date_created', 'updated_on'], 'safe'],
            [['request_id', 'doc_id', 'agreement_id', 'leegality_document_id'], 'string', 'max' => 200],
            [['request_id'], 'unique'],
            [['doc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EsignDocuments::className(), 'targetAttribute' => ['doc_id' => 'doc_id']],
            [['agreement_id'], 'exist', 'skipOnError' => true, 'targetClass' => EsignAgreementDetails::className(), 'targetAttribute' => ['agreement_id' => 'agreement_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoc()
    {
        return $this->hasOne(EsignDocuments::className(), ['doc_id' => 'doc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgreement()
    {
        return $this->hasOne(EsignAgreementDetails::className(), ['agreement_id' => 'agreement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignRequestedAgreementsDetails()
    {
        return $this->hasMany(EsignRequestedAgreementsDetails::className(), ['request_id' => 'request_id']);
    }
}
