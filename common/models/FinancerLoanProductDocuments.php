<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lJCWPnNNVy3d95ppLp7M_financer_loan_product_documents".
 *
 * @property int $id
 * @property string $financer_loan_product_document_enc_id
 * @property string $financer_loan_product_enc_id
 * @property string $certificate_type_enc_id certificate type id
 * @property int $sequence documents sequence
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property FinancerLoanProducts $financerLoanProductEnc
 * @property CertificateTypes $certificateTypeEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class FinancerLoanProductDocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_loan_product_documents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_loan_product_document_enc_id', 'financer_loan_product_enc_id', 'certificate_type_enc_id', 'sequence', 'created_by'], 'required'],
            [['sequence', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['financer_loan_product_document_enc_id', 'financer_loan_product_enc_id', 'certificate_type_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['financer_loan_product_document_enc_id'], 'unique'],
            [['financer_loan_product_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProducts::className(), 'targetAttribute' => ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']],
            [['certificate_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CertificateTypes::className(), 'targetAttribute' => ['certificate_type_enc_id' => 'certificate_type_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanProductEnc()
    {
        return $this->hasOne(FinancerLoanProducts::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificateTypeEnc()
    {
        return $this->hasOne(CertificateTypes::className(), ['certificate_type_enc_id' => 'certificate_type_enc_id']);
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
