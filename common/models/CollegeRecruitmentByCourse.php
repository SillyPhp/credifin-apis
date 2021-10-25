<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_recruitment_by_course}}".
 *
 * @property int $id
 * @property string $college_recruitment_by_course_enc_id encrypted id
 * @property string $college_enc_id college enc id
 * @property string $assigned_course_enc_id Course id
 * @property double $average_package Average Package
 * @property double $highest_package Highest Package
 * @property int $total_offers Total Offers
 * @property int $students_placed No. of Students Placed
 * @property int $companies_visiting Companies Visiting
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Organizations $collegeEnc
 * @property AssignedCollegeCourses $assignedCourseEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class CollegeRecruitmentByCourse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_recruitment_by_course}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['college_recruitment_by_course_enc_id', 'college_enc_id', 'assigned_course_enc_id', 'created_by'], 'required'],
            [['average_package', 'highest_package'], 'number'],
            [['total_offers', 'students_placed', 'companies_visiting', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['college_recruitment_by_course_enc_id', 'college_enc_id', 'assigned_course_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['college_recruitment_by_course_enc_id'], 'unique'],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['assigned_course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCollegeCourses::className(), 'targetAttribute' => ['assigned_course_enc_id' => 'assigned_college_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCourseEnc()
    {
        return $this->hasOne(AssignedCollegeCourses::className(), ['assigned_college_enc_id' => 'assigned_course_enc_id']);
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
}
