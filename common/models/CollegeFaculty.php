<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_faculty}}".
 *
 * @property int $id
 * @property string $college_faculty_enc_id
 * @property string $college_enc_id
 * @property string $image
 * @property string $image_location
 * @property string $faculty_name
 * @property string $designation_enc_id
 * @property string $department_enc_id
 * @property string $experience
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Designations $designationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Departments $departmentEnc
 */
class CollegeFaculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_faculty}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['college_faculty_enc_id', 'college_enc_id', 'faculty_name', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['college_faculty_enc_id', 'college_enc_id', 'image', 'image_location', 'faculty_name', 'designation_enc_id', 'department_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['experience'], 'string', 'max' => 250],
            [['college_faculty_enc_id'], 'unique'],
            [['designation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation_enc_id' => 'designation_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['department_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['department_enc_id' => 'department_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignationEnc()
    {
        return $this->hasOne(Designations::className(), ['designation_enc_id' => 'designation_enc_id']);
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
    public function getDepartmentEnc()
    {
        return $this->hasOne(Departments::className(), ['department_enc_id' => 'department_enc_id']);
    }
}
