<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_applications}}".
 *
 * @property int $id
 * @property string $loan_app_enc_id
 * @property string $college_course_enc_id organization_enc_id
 * @property string $applicant_name Course Name
 * @property string $applicant_dob
 * @property string $applicant_current_city
 * @property string $degree
 * @property int $years Course Years
 * @property int $semesters course semesters
 * @property string $phone
 * @property string $email
 * @property int $gender 1 for Male, 2 for Female
 * @property double $amount
 * @property string $purpose
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property int $status 0 as Pending, 1 as Approved
 *
 * @property CollegeCourses $collegeCourseEnc
 * @property Users $createdBy
 * @property LoanCoApplicants[] $loanCoApplicants
 */
class LoanApplications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_app_enc_id', 'college_course_enc_id', 'applicant_name', 'applicant_dob', 'applicant_current_city', 'degree', 'years', 'semesters', 'phone', 'email', 'gender', 'amount', 'purpose', 'created_by', 'created_on'], 'required'],
            [['applicant_dob', 'created_on','updated_on','updated_by'], 'safe'],
            [['degree', 'purpose'], 'string'],
            [['years', 'semesters', 'gender', 'status'], 'integer'],
            [['amount'], 'number'],
            [['loan_app_enc_id', 'college_course_enc_id', 'applicant_name', 'applicant_current_city', 'email', 'created_by'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['college_course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['college_course_enc_id' => 'college_course_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCourseEnc()
    {
        return $this->hasOne(CollegeCourses::className(), ['college_course_enc_id' => 'college_course_enc_id']);
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
    public function getLoanCoApplicants()
    {
        return $this->hasMany(LoanCoApplicants::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }
}
