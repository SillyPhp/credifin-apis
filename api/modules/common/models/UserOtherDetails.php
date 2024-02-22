<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_other_details}}".
 *
 * @property int $id
 * @property string $user_other_details_enc_id
 * @property string $user_enc_id
 * @property string $organization_enc_id
 * @property string $department_enc_id
 * @property string $educational_requirement_enc_id
 * @property string $course_enc_id
 * @property string $assigned_college_enc_id assigned college course enc id
 * @property string $section_enc_id
 * @property int $semester
 * @property double $cgpa
 * @property string $starting_year
 * @property string $ending_year
 * @property string $university_roll_number
 * @property string $internship_start_date
 * @property int $internship_duration 0 as 6 weeks, 1 as 3 months, 2 as 6 months, 3 as 1 year
 * @property string $job_start_month
 * @property string $job_year
 * @property int $college_actions NULL as pending, 0 as approved, 1 as blocked, 2 as rejected
 * @property int $is_deleted
 * @property string $created_on
 * @property string $updated_on
 *
 * @property CollegeCourses $courseEnc
 * @property CollegeSections $sectionEnc
 * @property Organizations $organizationEnc
 * @property Departments $departmentEnc
 * @property Users $userEnc
 * @property AssignedCollegeCourses $assignedCollegeEnc
 */
class UserOtherDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_other_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_other_details_enc_id', 'user_enc_id', 'organization_enc_id'], 'required'],
            [['semester', 'internship_duration', 'college_actions', 'is_deleted'], 'integer'],
            [['cgpa'], 'number'],
            [['starting_year', 'ending_year', 'internship_start_date', 'job_year', 'created_on', 'updated_on'], 'safe'],
            [['job_start_month'], 'string'],
            [['user_other_details_enc_id', 'user_enc_id', 'organization_enc_id', 'department_enc_id', 'educational_requirement_enc_id', 'course_enc_id', 'assigned_college_enc_id', 'section_enc_id'], 'string', 'max' => 100],
            [['university_roll_number'], 'string', 'max' => 30],
            [['user_other_details_enc_id'], 'unique'],
            [['course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['course_enc_id' => 'college_course_enc_id']],
            [['section_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeSections::className(), 'targetAttribute' => ['section_enc_id' => 'section_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['department_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['department_enc_id' => 'department_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['assigned_college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCollegeCourses::className(), 'targetAttribute' => ['assigned_college_enc_id' => 'assigned_college_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseEnc()
    {
        return $this->hasOne(CollegeCourses::className(), ['college_course_enc_id' => 'course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionEnc()
    {
        return $this->hasOne(CollegeSections::className(), ['section_enc_id' => 'section_enc_id']);
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
    public function getDepartmentEnc()
    {
        return $this->hasOne(Departments::className(), ['department_enc_id' => 'department_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCollegeEnc()
    {
        return $this->hasOne(AssignedCollegeCourses::className(), ['assigned_college_enc_id' => 'assigned_college_enc_id']);
    }
}
