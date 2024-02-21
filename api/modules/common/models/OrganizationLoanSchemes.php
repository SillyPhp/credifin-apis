<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_loan_schemes}}".
 *
 * @property int $id Primary Key
 * @property string $scheme_enc_id Scheme Encrypted ID
 * @property string $company_name Company Name
 * @property string $scheme_name Scheme Name
 * @property string $organization_enc_id Organization Enc Id
 * @property string $loan_type_enc_id Loan Type Enc id
 * @property double $rate_of_interest Rate Of Interest in Percent
 * @property double $subvention Subvention in Percent
 * @property int $is_security Is Security (0 as false, 1 as True)
 * @property string $security_type Security Type
 * @property string $borrower Borrower(1,2,3,4)
 * @property int $student_borrower Student Borrower (0 as false , 1 as True)
 * @property string $payment_mode Payment Mode (Offline,Online)
 * @property double $pf_ey PF EY in Percent
 * @property int $company_pf  1 as Percent, 2 as Amount
 * @property string $pf_value Company PF Amount
 * @property int $is_priority Priority(0 as false, 1 as true)
 * @property int $sequence Sequence Priority wise
 * @property string $created_on On which date Scheme was added to database
 * @property string $created_by By which User Scheme was added
 * @property int $is_deleted Is Scheme Deleted (0 as False, 1 as True)
 *
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property EducationLoanTypes $loanTypeEnc
 */
class OrganizationLoanSchemes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_loan_schemes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scheme_enc_id', 'company_name', 'scheme_name', 'organization_enc_id', 'loan_type_enc_id', 'rate_of_interest', 'subvention', 'is_security', 'pf_ey', 'company_pf', 'pf_value', 'sequence', 'created_by'], 'required'],
            [['rate_of_interest', 'subvention', 'pf_ey'], 'number'],
            [['is_security', 'student_borrower', 'company_pf', 'is_priority', 'sequence', 'is_deleted'], 'integer'],
            [['borrower', 'payment_mode'], 'string'],
            [['created_on'], 'safe'],
            [['scheme_enc_id', 'company_name', 'scheme_name', 'organization_enc_id', 'loan_type_enc_id', 'security_type', 'created_by'], 'string', 'max' => 100],
            [['pf_value'], 'string', 'max' => 20],
            [['scheme_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationLoanTypes::className(), 'targetAttribute' => ['loan_type_enc_id' => 'loan_type_enc_id']],
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanTypeEnc()
    {
        return $this->hasOne(EducationLoanTypes::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }
}
