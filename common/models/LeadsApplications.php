<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%leads_applications}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Encrypted Key
 * @property string $application_number application_number
 * @property string $first_name
 * @property string $last_name
 * @property string $student_mobile_number
 * @property string $contact_2
 * @property string $contact_3
 * @property string $gender
 * @property string $student_email
 * @property string $email_2
 * @property string $email_3
 * @property string $voter_id
 * @property string $dob
 * @property int $has_taken_addmission o as no 1 as yes
 * @property double $loan_amount
 * @property string $college_institute_name
 * @property string $course_name
 * @property string $source source of data
 * @property string $purpose purpose of this particular data
 * @property string $module weather its job internship or any other comma separated
 * @property string $user_type which kind of user is this nature of the user
 * @property double $course_fee_annual
 * @property int $application_fee_recieved 0 for not 1 for yes
 * @property int $filled_by 0 as self(student) 1 as executive 2 raw uploads by admins
 * @property string $status
 * @property string $status_date
 * @property string $comments
 * @property string $address
 * @property string $state
 * @property string $city
 * @property string $pin_zip_code
 * @property string $cast_category
 * @property int $is_number_verified 0 as false, 1 as True
 * @property string $managed_by
 * @property string $care_by
 * @property string $lead_by
 * @property int $loan_for 1 for College/University, 2 for School, 3 for other institute
 * @property int $admission_taken 1 as true, 0 as false
 * @property string $created_on
 * @property string $created_by may be null or not , filler id who has filled the form
 * @property string $last_updated_by
 * @property string $last_updated_on
 * @property string $assign_date Which date Task assign to Executive
 * @property string $calling_date Which date Executive called to Lead
 * @property int $priority Immediate, Urgent, High, Medium, Low  as 1,2,3,4,5
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property LeadApplicationCalling[] $leadApplicationCallings
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Users $managedBy
 * @property Users $leadBy
 * @property Users $careBy
 * @property LeadsApplicationsCallingLogs[] $leadsApplicationsCallingLogs
 * @property LeadsCollegePreference[] $leadsCollegePreferences
 * @property LeadsParentInformation[] $leadsParentInformations
 * @property LoanApplications[] $loanApplications
 */
class LeadsApplications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%leads_applications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'application_enc_id' => Yii::t('app', 'Application Enc ID'),
            'application_number' => Yii::t('app', 'Application Number'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'student_mobile_number' => Yii::t('app', 'Student Mobile Number'),
            'contact_2' => Yii::t('app', 'Contact 2'),
            'contact_3' => Yii::t('app', 'Contact 3'),
            'gender' => Yii::t('app', 'Gender'),
            'student_email' => Yii::t('app', 'Student Email'),
            'email_2' => Yii::t('app', 'Email 2'),
            'email_3' => Yii::t('app', 'Email 3'),
            'voter_id' => Yii::t('app', 'Voter ID'),
            'dob' => Yii::t('app', 'Dob'),
            'has_taken_addmission' => Yii::t('app', 'Has Taken Addmission'),
            'loan_amount' => Yii::t('app', 'Loan Amount'),
            'college_institute_name' => Yii::t('app', 'College Institute Name'),
            'course_name' => Yii::t('app', 'Course Name'),
            'source' => Yii::t('app', 'Source'),
            'purpose' => Yii::t('app', 'Purpose'),
            'module' => Yii::t('app', 'Module'),
            'user_type' => Yii::t('app', 'User Type'),
            'course_fee_annual' => Yii::t('app', 'Course Fee Annual'),
            'application_fee_recieved' => Yii::t('app', 'Application Fee Recieved'),
            'filled_by' => Yii::t('app', 'Filled By'),
            'status' => Yii::t('app', 'Status'),
            'status_date' => Yii::t('app', 'Status Date'),
            'comments' => Yii::t('app', 'Comments'),
            'address' => Yii::t('app', 'Address'),
            'state' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'pin_zip_code' => Yii::t('app', 'Pin Zip Code'),
            'cast_category' => Yii::t('app', 'Cast Category'),
            'is_number_verified' => Yii::t('app', 'Is Number Verified'),
            'managed_by' => Yii::t('app', 'Managed By'),
            'care_by' => Yii::t('app', 'Care By'),
            'lead_by' => Yii::t('app', 'Lead By'),
            'loan_for' => Yii::t('app', 'Loan For'),
            'admission_taken' => Yii::t('app', 'Admission Taken'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'last_updated_by' => Yii::t('app', 'Last Updated By'),
            'last_updated_on' => Yii::t('app', 'Last Updated On'),
            'assign_date' => Yii::t('app', 'Assign Date'),
            'calling_date' => Yii::t('app', 'Calling Date'),
            'priority' => Yii::t('app', 'Priority'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadApplicationCallings()
    {
        return $this->hasMany(LeadApplicationCalling::className(), ['application_enc_id' => 'application_enc_id']);
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
    public function getManagedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'managed_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'lead_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'care_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsApplicationsCallingLogs()
    {
        return $this->hasMany(LeadsApplicationsCallingLogs::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsCollegePreferences()
    {
        return $this->hasMany(LeadsCollegePreference::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsParentInformations()
    {
        return $this->hasMany(LeadsParentInformation::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplications()
    {
        return $this->hasMany(LoanApplications::className(), ['lead_application_enc_id' => 'application_enc_id']);
    }
}
