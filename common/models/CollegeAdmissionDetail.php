<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_admission_detail}}".
 *
 * @property int $id
 * @property string $admission_detail_enc_id admission detail id
 * @property string $assigned_course_id assigned_college_course_id
 * @property double $fees course fees
 * @property string $scholarship_enc_id scholarship id
 * @property string $selection_process course selection process
 * @property string $eligibility_criteria eligibility criteria
 * @property string $other_details course other details
 * @property string $created_by created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property AssignedCollegeCourses $assignedCourse
 * @property Users $createdBy
 */
class CollegeAdmissionDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_admission_detail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admission_detail_enc_id', 'assigned_course_id', 'created_by'], 'required'],
            [['fees'], 'number'],
            [['selection_process', 'eligibility_criteria', 'other_details'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['admission_detail_enc_id', 'assigned_course_id', 'scholarship_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['admission_detail_enc_id'], 'unique'],
            [['assigned_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCollegeCourses::className(), 'targetAttribute' => ['assigned_course_id' => 'assigned_college_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCourse()
    {
        return $this->hasOne(AssignedCollegeCourses::className(), ['assigned_college_enc_id' => 'assigned_course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
