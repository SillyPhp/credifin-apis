<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%online_classes}}".
 *
 * @property int $id
 * @property string $class_enc_id class encrypted id
 * @property string $teacher_enc_id teacher encrypted id
 * @property string $course_enc_id course encrypted id
 * @property string $section_enc_id course section encrypted id
 * @property string $batch batch year
 * @property string $start_time class start time
 * @property string $end_time class end time
 * @property string $class_date class date
 * @property string $created_on class created on time
 * @property string $status Active,Inactive
 * @property int $is_deleted 0 false,1 true
 * @property int $semester 0 false,1 true
 * @property AssignedVideoSessions[] $assignedVideoSessions
 *
 * @property Teachers $teacherEnc
 * @property CollegeCourses $courseEnc
 * @property CollegeSections $sectionEnc
 */
class OnlineClasses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%online_classes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_enc_id', 'teacher_enc_id', 'course_enc_id', 'batch', 'start_time', 'end_time', 'class_date','semester'], 'required'],
            [['batch', 'start_time', 'end_time', 'class_date', 'created_on'], 'safe'],
            [['status'], 'string'],
            [['is_deleted','semester'], 'integer'],
            [['class_enc_id', 'teacher_enc_id', 'course_enc_id', 'section_enc_id'], 'string', 'max' => 100],
            [['class_enc_id'], 'unique'],
            [['teacher_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teachers::className(), 'targetAttribute' => ['teacher_enc_id' => 'teacher_enc_id']],
            [['course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['course_enc_id' => 'college_course_enc_id']],
            [['section_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeSections::className(), 'targetAttribute' => ['section_enc_id' => 'section_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedVideoSessions()
    {
        return $this->hasMany(AssignedVideoSessions::className(), ['class_enc_id' => 'class_enc_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherEnc()
    {
        return $this->hasOne(Teachers::className(), ['teacher_enc_id' => 'teacher_enc_id']);
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
}
