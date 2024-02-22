<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_signature_coordinates}}".
 *
 * @property int $id
 * @property string $coordinates_id
 * @property string $type B as main borrower CB as co borrower and G as guarantor
 * @property string $doc_id
 * @property string $value
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignDocumentsTemplates $doc
 */
class EsignSignatureCoordinates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_signature_coordinates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coordinates_id', 'doc_id', 'value'], 'required'],
            [['type', 'value'], 'string'],
            [['date_created', 'updated_on'], 'safe'],
            [['coordinates_id', 'doc_id'], 'string', 'max' => 200],
            [['coordinates_id'], 'unique'],
            [['doc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EsignDocumentsTemplates::className(), 'targetAttribute' => ['doc_id' => 'doc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoc()
    {
        return $this->hasOne(EsignDocumentsTemplates::className(), ['doc_id' => 'doc_id']);
    }
}
