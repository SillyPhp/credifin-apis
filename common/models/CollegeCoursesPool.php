<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_courses_pool}}".
 *
 * @property int $id
 * @property string $course_enc_id
 * @property string $parent_enc_id
 * @property string $type
 * @property string $course_name Course Name
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property string $updated_on
 * @property string $updated_by
 * @property string $status
 * @property int $is_deleted 0 false,1 true
 *
 * @property AssignedCollegeCourses[] $assignedCollegeCourses
 * @property AssignedUnclaimCollegeCourses[] $assignedUnclaimCollegeCourses
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property CollegeCoursesPool $parentEnc
 * @property CollegeCoursesPool[] $collegeCoursesPools
 */
class CollegeCoursesPool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_courses_pool}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_enc_id', 'course_name', 'created_by'], 'required'],
            [['type', 'status'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['course_enc_id', 'parent_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['course_name'], 'string', 'max' => 200],
            [['course_enc_id'], 'unique'],
            [['course_name', 'type'], 'unique', 'targetAttribute' => ['course_name', 'type']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['parent_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCoursesPool::className(), 'targetAttribute' => ['parent_enc_id' => 'course_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCollegeCourses()
    {
        return $this->hasMany(AssignedCollegeCourses::className(), ['course_enc_id' => 'course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedUnclaimCollegeCourses()
    {
        return $this->hasMany(AssignedUnclaimCollegeCourses::className(), ['course_enc_id' => 'course_enc_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentEnc()
    {
        return $this->hasOne(CollegeCoursesPool::className(), ['course_enc_id' => 'parent_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCoursesPools()
    {
        return $this->hasMany(CollegeCoursesPool::className(), ['parent_enc_id' => 'course_enc_id']);
    }
}
