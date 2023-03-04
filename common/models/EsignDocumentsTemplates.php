<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_documents_templates}}".
 *
 * @property int $id
 * @property string $doc_template_id
 * @property string $name
 * @property string $file_url
 * @property string $organization_enc_id
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignAgreementDetails[] $esignAgreementDetails
 * @property Organizations $organizationEnc
 * @property EsignRequestedAgreements[] $esignRequestedAgreements
 * @property EsignSignatureCoordinates[] $esignSignatureCoordinates
 */
class EsignDocumentsTemplates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_documents_templates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_template_id', 'name', 'file_url', 'organization_enc_id'], 'required'],
            [['date_created', 'updated_on'], 'safe'],
            [['doc_template_id', 'name'], 'string', 'max' => 200],
            [['file_url'], 'string', 'max' => 500],
            [['organization_enc_id'], 'string', 'max' => 100],
            [['doc_template_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignAgreementDetails()
    {
        return $this->hasMany(EsignAgreementDetails::className(), ['template_id' => 'doc_template_id']);
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
    public function getEsignRequestedAgreements()
    {
        return $this->hasMany(EsignRequestedAgreements::className(), ['doc_id' => 'doc_template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignSignatureCoordinates()
    {
        return $this->hasMany(EsignSignatureCoordinates::className(), ['doc_id' => 'doc_template_id']);
    }
}
