<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_agreement_details}}".
 *
 * @property int $id
 * @property string $agreement_id
 * @property string $doc_generated_id generated doc id after compile
 * @property string $template_id base template id
 * @property string $case_no case number or loan number
 * @property int $loan_type 1 for vehicle loan 2 for personal loan 3 for business loan 4 education loan 5 for loan against property
 * @property double $loan_amount loan amount
 * @property string $file_number file number
 * @property int $number_of_co_borrowers  number of co borrowers
 * @property string $customer_name customer name
 * @property string $guardian
 * @property int $guardian_relation 1 for son of 2 for wife of 3 for daughter of
 * @property string $phone
 * @property string $dob
 * @property string $age
 * @property string $aadhaar_number
 * @property string $pan_card
 * @property string $full_address
 * @property double $roi rate of interest
 * @property string $roi_type type of rate of interest
 * @property double $processing_fee processing fee
 * @property double $down_margin_payment down payment or margin money
 * @property double $hospicare hospicare amount
 * @property double $medical_loan medical loan amount
 * @property string $tenure tenure monthly or yearly
 * @property int $tenure_period tenure period in number of months or years
 * @property string $organization_enc_id organization enc id ref through empower youth database
 * @property string $employee_enc_id employe who work under company has created the document
 * @property int $agreement_type 1 for self 2 for BC 3 for co lending
 * @property string $data_mode dev or prod data sandbox or real data
 * @property string $date_created
 * @property string $updated_on
 *
 * @property Organizations $organizationEnc
 * @property Users $employeeEnc
 * @property EsignDocumentsTemplates $template
 * @property EsignAgreementPartners[] $esignAgreementPartners
 * @property EsignBorrowerDetails[] $esignBorrowerDetails
 * @property EsignLoanAgreements[] $esignLoanAgreements
 * @property EsignRequestedAgreements[] $esignRequestedAgreements
 * @property EsignVehicleLoanDetails[] $esignVehicleLoanDetails
 */
class EsignAgreementDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_agreement_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agreement_id', 'doc_generated_id', 'template_id', 'number_of_co_borrowers', 'customer_name', 'phone', 'age', 'aadhaar_number', 'full_address', 'roi', 'processing_fee', 'tenure', 'tenure_period', 'organization_enc_id', 'employee_enc_id'], 'required'],
            [['loan_type', 'number_of_co_borrowers', 'guardian_relation', 'tenure_period', 'agreement_type'], 'integer'],
            [['loan_amount', 'roi', 'processing_fee', 'down_margin_payment', 'hospicare', 'medical_loan'], 'number'],
            [['dob', 'date_created', 'updated_on'], 'safe'],
            [['full_address', 'roi_type', 'tenure', 'data_mode'], 'string'],
            [['agreement_id', 'doc_generated_id', 'template_id', 'case_no', 'file_number', 'customer_name', 'guardian', 'phone', 'age', 'aadhaar_number', 'pan_card'], 'string', 'max' => 200],
            [['organization_enc_id', 'employee_enc_id'], 'string', 'max' => 100],
            [['agreement_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['employee_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['employee_enc_id' => 'user_enc_id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => EsignDocumentsTemplates::className(), 'targetAttribute' => ['template_id' => 'doc_template_id']],
        ];
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
    public function getEmployeeEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'employee_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(EsignDocumentsTemplates::className(), ['doc_template_id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignAgreementPartners()
    {
        return $this->hasMany(EsignAgreementPartners::className(), ['agreement_id' => 'agreement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignBorrowerDetails()
    {
        return $this->hasMany(EsignBorrowerDetails::className(), ['agreement_id' => 'agreement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignLoanAgreements()
    {
        return $this->hasMany(EsignLoanAgreements::className(), ['agreement_id' => 'agreement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignRequestedAgreements()
    {
        return $this->hasMany(EsignRequestedAgreements::className(), ['agreement_id' => 'agreement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsignVehicleLoanDetails()
    {
        return $this->hasMany(EsignVehicleLoanDetails::className(), ['agreement_id' => 'agreement_id']);
    }
}
