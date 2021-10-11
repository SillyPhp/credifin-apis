<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_college_courses}}".
 *
 * @property int $id
 * @property string $assigned_college_enc_id
 * @property string $organization_enc_id organization_enc_id
 * @property string $course_enc_id Course Name
 * @property int $course_duration Course Durations
 * @property int $years Course Years
 * @property int $semesters course semesters
 * @property string $type year and semesters
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property string $updated_on
 * @property string $updated_by
 * @property int $is_deleted 0 false,1 true
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property CollegeCoursesPool $courseEnc
 * @property Organizations $organizationEnc
 * @property CollegeAdmissionDetail[] $collegeAdmissionDetails
 * @property CollegeCutoff[] $collegeCutoffs
 * @property CollegeRecruitmentByCourse[] $collegeRecruitmentByCourses
 * @property CollegeSections[] $collegeSections
 * @property MockQuizzes[] $mockQuizzes
 * @property OnlineClasses[] $onlineClasses
 * @property PathToClaimOrgLoanApplication[] $pathToClaimOrgLoanApplications
 * @property UserOtherDetails[] $userOtherDetails
 */
class AssignedCollegeCourses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_college_courses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_college_enc_id', 'organization_enc_id', 'course_enc_id', 'created_by'], 'required'],
            [['course_duration', 'years', 'semesters', 'is_deleted'], 'integer'],
            [['type'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['assigned_college_enc_id', 'organization_enc_id', 'course_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_college_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCoursesPool::className(), 'targetAttribute' => ['course_enc_id' => 'course_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseEnc()
    {
        return $this->hasOne(CollegeCoursesPool::className(), ['course_enc_id' => 'course_enc_id']);
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
    public function getCollegeAdmissionDetails()
    {
        return $this->hasMany(CollegeAdmissionDetail::className(), ['assigned_course_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCutoffs()
    {
        return $this->hasMany(CollegeCutoff::className(), ['assgined_course_enc_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeRecruitmentByCourses()
    {
        return $this->hasMany(CollegeRecruitmentByCourse::className(), ['assigned_course_enc_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeSections()
    {
        return $this->hasMany(CollegeSections::className(), ['assigned_college_enc_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockQuizzes()
    {
        return $this->hasMany(MockQuizzes::className(), ['assigned_college_enc_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineClasses()
    {
        return $this->hasMany(OnlineClasses::className(), ['assigned_college_enc_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPathToClaimOrgLoanApplications()
    {
        return $this->hasMany(PathToClaimOrgLoanApplication::className(), ['assigned_course_enc_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOtherDetails()
    {
        return $this->hasMany(UserOtherDetails::className(), ['assigned_college_enc_id' => 'assigned_college_enc_id']);
    }
}
