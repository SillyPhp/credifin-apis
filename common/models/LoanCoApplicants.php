<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_co_applicants}}".
 *
 * @property int $id
 * @property string $loan_co_app_enc_id
 * @property string $loan_app_enc_id organization_enc_id
 * @property string $name
 * @property string $email
 * @property int $cibil_score cibil score
 * @property string $phone
 * @property string $relation
 * @property string $borrower_type borrower type
 * @property int $gender Gender (1 as Male, 2 as Female, 3 as Transgender, 4 as Rather not say)
 * @property int $employment_type 0 as Non Working, 1 as Salaried, 2 as Self Employed
 * @property double $annual_income
 * @property string $co_applicant_dob
 * @property string $image
 * @property string $image_location
 * @property int $years_in_current_house years in current house
 * @property string $occupation
 * @property int $address 0 new address,1 same as applicant
 * @property string $pan_number co borrower pan card number
 * @property string $voter_card_number
 * @property string $aadhaar_number
 * @property string $aadhaar_link_phone_number Aadhar Link Phone Number
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property string $updated_on
 * @property string $updated_by
 *
 * @property LoanApplicantResidentialInfo[] $loanApplicantResidentialInfos
 * @property LoanCertificates[] $loanCertificates
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class LoanCoApplicants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_co_applicants}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_co_app_enc_id', 'loan_app_enc_id', 'relation'], 'required'],
            [['cibil_score', 'gender', 'employment_type', 'years_in_current_house', 'address'], 'integer'],
            [['relation', 'borrower_type'], 'string'],
            [['annual_income'], 'number'],
            [['co_applicant_dob', 'created_on', 'updated_on'], 'safe'],
            [['loan_co_app_enc_id', 'loan_app_enc_id', 'name', 'email', 'image', 'image_location', 'occupation', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['phone', 'pan_number', 'aadhaar_link_phone_number'], 'string', 'max' => 15],
            [['voter_card_number'], 'string', 'max' => 20],
            [['aadhaar_number'], 'string', 'max' => 16],
            [['loan_co_app_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicantResidentialInfos()
    {
        return $this->hasMany(LoanApplicantResidentialInfo::className(), ['loan_co_app_enc_id' => 'loan_co_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCertificates()
    {
        return $this->hasMany(LoanCertificates::className(), ['loan_co_app_enc_id' => 'loan_co_app_enc_id']);
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
