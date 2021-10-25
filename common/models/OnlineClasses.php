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
 * @property string $assigned_college_enc_id assigned college course id
 * @property string $section_enc_id course section encrypted id
 * @property int $semester class semester
 * @property string $subject_name subject name
 * @property string $start_time class start time
 * @property string $end_time class end time
 * @property string $class_date class date
 * @property string $class_type
 * @property string $created_on class created on time
 * @property string $status Active,Inactive,Ended
 * @property int $is_deleted 0 false,1 true
 *
 * @property AssignedVideoSessions[] $assignedVideoSessions
 * @property ClassNotes[] $classNotes
 * @property OnlineClassComments[] $onlineClassComments
 * @property Teachers $teacherEnc
 * @property CollegeCourses $courseEnc
 * @property CollegeSections $sectionEnc
 * @property AssignedCollegeCourses $assignedCollegeEnc
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
            [['class_enc_id', 'teacher_enc_id', 'semester', 'subject_name'], 'required'],
            [['semester', 'is_deleted'], 'integer'],
            [['start_time', 'end_time', 'class_date', 'created_on'], 'safe'],
            [['class_type', 'status'], 'string'],
            [['class_enc_id', 'teacher_enc_id', 'course_enc_id', 'assigned_college_enc_id', 'section_enc_id', 'subject_name'], 'string', 'max' => 100],
            [['class_enc_id'], 'unique'],
            [['teacher_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teachers::className(), 'targetAttribute' => ['teacher_enc_id' => 'teacher_enc_id']],
            [['course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['course_enc_id' => 'college_course_enc_id']],
            [['section_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeSections::className(), 'targetAttribute' => ['section_enc_id' => 'section_enc_id']],
            [['assigned_college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCollegeCourses::className(), 'targetAttribute' => ['assigned_college_enc_id' => 'assigned_college_enc_id']],
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
    public function getClassNotes()
    {
        return $this->hasMany(ClassNotes::className(), ['class_enc_id' => 'class_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineClassComments()
    {
        return $this->hasMany(OnlineClassComments::className(), ['class_enc_id' => 'class_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCollegeEnc()
    {
        return $this->hasOne(AssignedCollegeCourses::className(), ['assigned_college_enc_id' => 'assigned_college_enc_id']);
    }
}
