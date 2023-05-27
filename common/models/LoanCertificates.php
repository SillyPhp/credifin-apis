<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_certificates}}".
 *
 * @property int $id
 * @property string $certificate_enc_id
 * @property string|null $loan_app_enc_id loan encrypted id
 * @property string|null $loan_co_app_enc_id
 * @property string $certificate_type_enc_id id proof type
 * @property string|null $financer_loan_document_enc_id financer loan document enc id
 * @property string|null $number id proof number
 * @property string|null $proof_image id proof image
 * @property string|null $proof_image_name
 * @property string|null $proof_image_location id proof image location
 * @property string|null $proof_of
 * @property float|null $certificate_periods in years
 * @property string|null $short_description
 * @property int|null $related_to 1 customer, 2 company
 * @property string|null $created_by
 * @property string $created_on
 * @property string|null $updated_by
 * @property string|null $updated_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property CertificateTypes $certificateTypeEnc
 * @property Users $createdBy
 * @property FinancerLoanProductDocuments $financerLoanDocumentEnc
 * @property LoanApplications $loanAppEnc
 * @property LoanCertificatesImages[] $loanCertificatesImages
 * @property LoanCoApplicants $loanCoAppEnc
 * @property Users $updatedBy
 */
class LoanCertificates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_certificates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['certificate_enc_id', 'certificate_type_enc_id'], 'required'],
            [['proof_of'], 'string'],
            [['certificate_periods'], 'number'],
            [['related_to', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['certificate_enc_id', 'loan_app_enc_id', 'loan_co_app_enc_id', 'certificate_type_enc_id', 'financer_loan_document_enc_id', 'proof_image', 'proof_image_name', 'proof_image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['number'], 'string', 'max' => 20],
            [['short_description'], 'string', 'max' => 250],
            [['certificate_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['loan_co_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanCoApplicants::className(), 'targetAttribute' => ['loan_co_app_enc_id' => 'loan_co_app_enc_id']],
            [['certificate_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CertificateTypes::className(), 'targetAttribute' => ['certificate_type_enc_id' => 'certificate_type_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['financer_loan_document_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProductDocuments::className(), 'targetAttribute' => ['financer_loan_document_enc_id' => 'financer_loan_product_document_enc_id']],
        ];
    }

    /**
     * Gets query for [[CertificateTypeEnc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificateTypeEnc()
    {
        return $this->hasOne(CertificateTypes::className(), ['certificate_type_enc_id' => 'certificate_type_enc_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * Gets query for [[FinancerLoanDocumentEnc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanDocumentEnc()
    {
        return $this->hasOne(FinancerLoanProductDocuments::className(), ['financer_loan_product_document_enc_id' => 'financer_loan_document_enc_id']);
    }

    /**
     * Gets query for [[LoanAppEnc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * Gets query for [[LoanCertificatesImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCertificatesImages()
    {
        return $this->hasMany(LoanCertificatesImages::className(), ['certificate_enc_id' => 'certificate_enc_id']);
    }

    /**
     * Gets query for [[LoanCoAppEnc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCoAppEnc()
    {
        return $this->hasOne(LoanCoApplicants::className(), ['loan_co_app_enc_id' => 'loan_co_app_enc_id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
