<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mock_quizzes}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_enc_id Quiz Encrypted ID
 * @property string $label_enc_id Foreign Key to MockLables table, here will come course / class label id
 * @property string $name Name of the Quiz
 * @property int $per_ques_marks
 * @property int $total_marks
 * @property int $per_ques_time
 * @property int $total_time
 * @property int $negative_marks
 * @property string $slug Quiz Slug
 * @property int $total_questions Number of Question that will displayed on play quiz
 * @property string $for_sections Sections store in comma separated form like (A,B,C)
 * @property string $course_enc_id course or class id
 * @property string $assigned_college_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted
 *
 * @property MockAssignedQuizPool[] $mockAssignedQuizPools
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property MockLabels $labelEnc
 * @property CollegeCourses $courseEnc
 * @property AssignedCollegeCourses $assignedCollegeEnc
 * @property MockTakenQuizzes[] $mockTakenQuizzes
 */
class MockQuizzes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_quizzes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_enc_id', 'name', 'slug', 'total_questions', 'created_by'], 'required'],
            [['per_ques_marks', 'total_marks', 'per_ques_time', 'total_time', 'negative_marks', 'total_questions', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['quiz_enc_id', 'label_enc_id', 'name', 'slug', 'for_sections', 'course_enc_id', 'assigned_college_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['label_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockLabels::className(), 'targetAttribute' => ['label_enc_id' => 'label_enc_id']],
            [['course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['course_enc_id' => 'college_course_enc_id']],
            [['assigned_college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCollegeCourses::className(), 'targetAttribute' => ['assigned_college_enc_id' => 'assigned_college_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockAssignedQuizPools()
    {
        return $this->hasMany(MockAssignedQuizPool::className(), ['quiz_enc_id' => 'quiz_enc_id']);
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
    public function getLabelEnc()
    {
        return $this->hasOne(MockLabels::className(), ['label_enc_id' => 'label_enc_id']);
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
    public function getAssignedCollegeEnc()
    {
        return $this->hasOne(AssignedCollegeCourses::className(), ['assigned_college_enc_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockTakenQuizzes()
    {
        return $this->hasMany(MockTakenQuizzes::className(), ['quiz_enc_id' => 'quiz_enc_id']);
    }
}
