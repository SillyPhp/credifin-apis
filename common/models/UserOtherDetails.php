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
 * @property int $semester
 * @property string $starting_year
 * @property string $ending_year
 * @property string $university_roll_number
 * @property string $internship_start_date
 * @property int $internship_duration 0 as 6 weeks, 1 as 3 months, 2 as 6 months, 3 as 1 year
 * @property string $job_start_month
 * @property string $job_year
 * @property int $college_actions 0 as approved, 1 as blocked, 2 as rejected
 */
class UserOtherDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_other_details}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_other_details_enc_id', 'user_enc_id', 'organization_enc_id', 'department_enc_id', 'educational_requirement_enc_id', 'semester', 'starting_year', 'ending_year', 'university_roll_number'], 'required'],
            [['semester', 'internship_duration', 'college_actions'], 'integer'],
            [['starting_year', 'ending_year', 'internship_start_date', 'job_year'], 'safe'],
            [['job_start_month'], 'string'],
            [['user_other_details_enc_id', 'user_enc_id', 'organization_enc_id', 'department_enc_id', 'educational_requirement_enc_id'], 'string', 'max' => 100],
            [['university_roll_number'], 'string', 'max' => 20],
            [['user_other_details_enc_id'], 'unique'],
            [['university_roll_number'], 'unique'],
        ];
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
    public function getEducationalRequirementEnc()
    {
        return $this->hasOne(EducationalRequirements::className(), ['educational_requirement_enc_id' => 'educational_requirement_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }
}


