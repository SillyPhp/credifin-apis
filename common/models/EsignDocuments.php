<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_documents}}".
 *
 * @property int $id
 * @property string $doc_id
 * @property string $name
 * @property string $data_string
 * @property string $file_url
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignRequestedAgreements[] $esignRequestedAgreements
 * @property EsignSignatureCoordinates[] $esignSignatureCoordinates
 */
class EsignDocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_documents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_id', 'name', 'file_url'], 'required'],
            [['data_string'], 'string'],
            [['date_created', 'updated_on'], 'safe'],
            [['doc_id', 'name'], 'string', 'max' => 200],
            [['file_url'], 'string', 'max' => 500],
            [['doc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignRequestedAgreements()
    {
        return $this->hasMany(EsignRequestedAgreements::className(), ['doc_id' => 'doc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignSignatureCoordinates()
    {
        return $this->hasMany(EsignSignatureCoordinates::className(), ['doc_id' => 'doc_id']);
    }
}
