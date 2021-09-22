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
 * @property string $gender
 * @property string $student_email
 * @property string $voter_id
 * @property string $dob
 * @property int $has_taken_addmission o as no 1 as yes
 * @property double $loan_amount
 * @property string $college_institute_name
 * @property string $course_name
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
 * @property int $priority
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
    public function rules()
    {
        return [
            [['application_enc_id', 'application_number'], 'required'],
            [['gender', 'status', 'comments', 'address'], 'string'],
            [['dob', 'created_on', 'last_updated_on', 'assign_date', 'calling_date'], 'safe'],
            [['has_taken_addmission', 'application_fee_recieved', 'filled_by', 'is_number_verified', 'loan_for', 'admission_taken', 'priority', 'is_deleted'], 'integer'],
            [['loan_amount', 'course_fee_annual'], 'number'],
            [['application_enc_id', 'application_number', 'first_name', 'last_name', 'student_email', 'voter_id', 'state', 'city', 'pin_zip_code', 'cast_category', 'managed_by', 'care_by', 'lead_by', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['student_mobile_number', 'status_date'], 'string', 'max' => 50],
            [['college_institute_name', 'course_name'], 'string', 'max' => 200],
            [['application_enc_id'], 'unique'],
            [['application_number'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['managed_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['managed_by' => 'user_enc_id']],
            [['lead_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['lead_by' => 'user_enc_id']],
            [['care_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['care_by' => 'user_enc_id']],
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
}
