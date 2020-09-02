<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%collected_documents}}".
 *
 * @property int $id
 * @property string $collect_document_enc_id
 * @property string $sanctioned_report_id
 * @property string $document_enc_id
 * @property string $is_collected
 * @property string $created_by
 * @property string $created_on
 *
 * @property Users $createdBy
 * @property LoanSanctionReports $sanctionedReport
 * @property LoanDocuments $documentEnc
 */
class CollectedDocuments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%collected_documents}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collect_document_enc_id', 'sanctioned_report_id', 'document_enc_id', 'is_collected', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['collect_document_enc_id', 'sanctioned_report_id', 'document_enc_id', 'created_by'], 'string', 'max' => 100],
            [['is_collected'], 'string', 'max' => 20],
            [['collect_document_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['sanctioned_report_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanSanctionReports::className(), 'targetAttribute' => ['sanctioned_report_id' => 'report_enc_id']],
            [['document_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanDocuments::className(), 'targetAttribute' => ['document_enc_id' => 'document_enc_id']],
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
    public function getSanctionedReport()
    {
        return $this->hasOne(LoanSanctionReports::className(), ['report_enc_id' => 'sanctioned_report_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentEnc()
    {
        return $this->hasOne(LoanDocuments::className(), ['document_enc_id' => 'document_enc_id']);
    }
}
