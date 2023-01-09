<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_certificates}}".
 *
 * @property int $id
 * @property string $certificate_enc_id
 * @property string $loan_app_enc_id loan encrypted id
 * @property string $loan_co_app_enc_id
 * @property string $certificate_type_enc_id id proof type
 * @property string $financer_loan_document_enc_id financer loan document enc id
 * @property string $number id proof number
 * @property string $proof_image id proof image
 * @property string $proof_image_name
 * @property string $proof_image_location id proof image location
 * @property string $proof_of
 * @property double $certificate_periods in years
 * @property string $short_description
 * @property int $related_to 1 customer, 2 company
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property LoanApplications $loanAppEnc
 * @property LoanCoApplicants $loanCoAppEnc
 * @property CertificateTypes $certificateTypeEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property FinancerLoanDocuments $financerLoanDocumentEnc
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
            [['financer_loan_document_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanDocuments::className(), 'targetAttribute' => ['financer_loan_document_enc_id' => 'financer_loan_document_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCoAppEnc()
    {
        return $this->hasOne(LoanCoApplicants::className(), ['loan_co_app_enc_id' => 'loan_co_app_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanDocumentEnc()
    {
        return $this->hasOne(FinancerLoanDocuments::className(), ['financer_loan_document_enc_id' => 'financer_loan_document_enc_id']);
    }
}
