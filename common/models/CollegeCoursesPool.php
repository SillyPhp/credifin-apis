<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_courses_pool}}".
 *
 * @property int $id
 * @property string $course_enc_id
 * @property string $course_name Course Name
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property string $updated_on
 * @property string $updated_by
 * @property int $is_deleted 0 false,1 true
 *
 * @property AssignedCollegeCourses[] $assignedCollegeCourses
 * @property Users $updatedBy
 * @property Users $createdBy
 */
class CollegeCoursesPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%college_courses_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_enc_id', 'course_name', 'created_by', 'created_on'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['course_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['course_name'], 'string', 'max' => 200],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
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
}
