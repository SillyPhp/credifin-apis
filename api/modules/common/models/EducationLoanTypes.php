<?php

namespace common\models;

/**
 * This is the model class for table "{{%education_loan_types}}".
 *
 * @property int $id Primary Key
 * @property string $loan_type_enc_id Loan Encrypted ID
 * @property string $loan_name Loan Type Name
 *
 * @property LoanApplications[] $loanApplications
 * @property OrganizationFeeAmount[] $organizationFeeAmounts
 * @property OrganizationLoanSchemes[] $organizationLoanSchemes
 */
class EducationLoanTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%education_loan_types}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_type_enc_id', 'loan_name'], 'required'],
            [['loan_type_enc_id', 'loan_name'], 'string', 'max' => 100],
            [['loan_type_enc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplications()
    {
        return $this->hasMany(LoanApplications::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationFeeAmounts()
    {
        return $this->hasMany(OrganizationFeeAmount::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLoanSchemes()
    {
        return $this->hasMany(OrganizationLoanSchemes::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }
}
