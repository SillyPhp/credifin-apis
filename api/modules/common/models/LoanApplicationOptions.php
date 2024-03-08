<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_application_options}}".
 *
 * @property int $id Primary Key
 * @property string $option_enc_id Option Encrypted ID
 * @property string $loan_app_enc_id
 * @property int $application_by who is filing the application 0 as self or student itself 1 as parent 2 as execitive
 * @property int $number_of_loans number of previous loans if nay
 * @property double $total_loan_amount
 * @property double $monthly_emi
 * @property string $property_requirement
 * @property string $current_status
 * @property string $current_status_comments
 * @property string $comment
 * @property string $follow_up_on
 * @property string $follow_up_by
 * @property string $loan_option Loan Option Name
 * @property int $loan_option_value Loan Option Values 1 as True and 0 as False
 * @property double $perposed_emi Perposed EMI Amount
 * @property int $desired_tenure Desired tenure in years
 * @property string $name_of_company Name of company
 * @property string $type_of_company Tpe of company
 * @property string $nature_of_business Type of business
 * @property double $annual_turnover Annual turnover
 * @property string $designation Designation
 * @property string $business_premises Business premises
 * @property string $occupation
 * @property string $vehicle_type vehicle type
 * @property string $vehicle_option vehicle option
 * @property string $vehicle_brand vehicle brand
 * @property string $vehicle_model vehicle model
 * @property string $vehicle_making_year vehicle making year
 * @property string $lead_type lead type
 * @property string $dealer_name dealer name
 * @property string $disbursement_date disbursement date
 * @property string $created_on On which date  information was added to database
 * @property string $created_by Foreign Key to Users Table
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by
 * @property int $is_deleted Is  Deleted (0 as False, 1 as True)
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Users $followUpBy
 * @property OrganizationTypes $typeOfCompany
 * @property Designations $designation0
 */
class LoanApplicationOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_options}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_enc_id', 'loan_app_enc_id'], 'required'],
            [['application_by', 'number_of_loans', 'loan_option_value', 'desired_tenure', 'is_deleted'], 'integer'],
            [['total_loan_amount', 'monthly_emi', 'perposed_emi', 'annual_turnover'], 'number'],
            [['property_requirement', 'current_status', 'current_status_comments', 'comment', 'business_premises'], 'string'],
            [['follow_up_on', 'disbursement_date', 'created_on', 'last_updated_on'], 'safe'],
            [['option_enc_id', 'loan_app_enc_id', 'follow_up_by', 'loan_option', 'type_of_company', 'designation', 'vehicle_type', 'vehicle_option', 'vehicle_brand', 'vehicle_model', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name_of_company', 'nature_of_business'], 'string', 'max' => 256],
            [['occupation'], 'string', 'max' => 250],
            [['vehicle_making_year'], 'string', 'max' => 10],
            [['lead_type'], 'string', 'max' => 20],
            [['dealer_name'], 'string', 'max' => 50],
            [['option_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['follow_up_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['follow_up_by' => 'user_enc_id']],
            [['type_of_company'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationTypes::className(), 'targetAttribute' => ['type_of_company' => 'organization_type_enc_id']],
            [['designation'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation' => 'designation_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_enc_id' => 'Option Enc ID',
            'loan_app_enc_id' => 'Loan App Enc ID',
            'application_by' => 'Application By',
            'number_of_loans' => 'Number Of Loans',
            'total_loan_amount' => 'Total Loan Amount',
            'monthly_emi' => 'Monthly Emi',
            'property_requirement' => 'Property Requirement',
            'current_status' => 'Current Status',
            'current_status_comments' => 'Current Status Comments',
            'comment' => 'Comment',
            'follow_up_on' => 'Follow Up On',
            'follow_up_by' => 'Follow Up By',
            'loan_option' => 'Loan Option',
            'loan_option_value' => 'Loan Option Value',
            'perposed_emi' => 'Perposed Emi',
            'desired_tenure' => 'Desired Tenure',
            'name_of_company' => 'Name Of Company',
            'type_of_company' => 'Type Of Company',
            'nature_of_business' => 'Nature Of Business',
            'annual_turnover' => 'Annual Turnover',
            'designation' => 'Designation',
            'business_premises' => 'Business Premises',
            'occupation' => 'Occupation',
            'vehicle_type' => 'Vehicle Type',
            'vehicle_option' => 'Vehicle Option',
            'vehicle_brand' => 'Vehicle Brand',
            'vehicle_model' => 'Vehicle Model',
            'vehicle_making_year' => 'Vehicle Making Year',
            'lead_type' => 'Lead Type',
            'dealer_name' => 'Dealer Name',
            'disbursement_date' => 'Disbursement Date',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'last_updated_on' => 'Last Updated On',
            'last_updated_by' => 'Last Updated By',
            'is_deleted' => 'Is Deleted',
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowUpBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'follow_up_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeOfCompany()
    {
        return $this->hasOne(OrganizationTypes::className(), ['organization_type_enc_id' => 'type_of_company']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignation0()
    {
        return $this->hasOne(Designations::className(), ['designation_enc_id' => 'designation']);
    }
}
