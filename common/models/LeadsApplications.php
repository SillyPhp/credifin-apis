<?php

namespace common\models;

/**
 * This is the model class for table "{{%leads_applications}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Encrypted Key
 * @property string $application_number application_number
 * @property string $student_name
 * @property string $student_mobile_number
 * @property string $student_email
 * @property int $has_taken_addmission o as no 1 as yes
 * @property double $loan_amount
 * @property string $college_name
 * @property string $course_name
 * @property double $course_fee_annual
 * @property int $application_fee_recieved 0 for not 1 for yes
 * @property int $filled_by 0 as self(student) 1 as executive
 * @property string $created_on
 * @property string $created_by may be null or not , filler id who has filled the form
 * @property string $last_updated_by
 * @property string $last_updated_on
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property LeadsCollegePreference $leadsCollegePreference
 * @property LeadsParentInformation[] $leadsParentInformations
 */
class LeadsApplications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%leads_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_enc_id', 'application_number', 'student_name'], 'required'],
            [['has_taken_addmission', 'application_fee_recieved', 'filled_by'], 'integer'],
            [['loan_amount', 'course_fee_annual'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['application_enc_id', 'application_number', 'student_email', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['student_name', 'college_name', 'course_name'], 'string', 'max' => 200],
            [['student_mobile_number'], 'string', 'max' => 15],
            [['application_enc_id'], 'unique'],
            [['application_number'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
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
    public function getLeadsCollegePreference()
    {
        return $this->hasOne(LeadsCollegePreference::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsParentInformations()
    {
        return $this->hasMany(LeadsParentInformation::className(), ['application_enc_id' => 'application_enc_id']);
    }
}
