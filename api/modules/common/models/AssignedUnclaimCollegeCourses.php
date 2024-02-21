<?php
namespace common\models;

/**
 * This is the model class for table "{{%assigned_unclaim_college_courses}}".
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
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property CollegeCoursesPool $courseEnc
 * @property UnclaimedOrganizations $organizationEnc
 * @property PathToUnclaimOrgLoanApplication[] $pathToUnclaimOrgLoanApplications
 */
class AssignedUnclaimCollegeCourses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_unclaim_college_courses}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_college_enc_id', 'organization_enc_id', 'course_enc_id', 'created_by', 'created_on'], 'required'],
            [['course_duration', 'years', 'semesters', 'is_deleted'], 'integer'],
            [['type'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['assigned_college_enc_id', 'organization_enc_id', 'course_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCoursesPool::className(), 'targetAttribute' => ['course_enc_id' => 'course_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }
    /**
     * @inheritdoc
     */


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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
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
        return $this->hasOne(UnclaimedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPathToUnclaimOrgLoanApplications()
    {
        return $this->hasMany(PathToUnclaimOrgLoanApplication::className(), ['assigned_course_enc_id' => 'assigned_college_enc_id']);
    }
}
