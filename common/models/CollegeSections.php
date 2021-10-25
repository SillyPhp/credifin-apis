<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_sections}}".
 *
 * @property int $id
 * @property string $section_enc_id section encrypted id
 * @property string $assigned_college_enc_id college course encrypted id
 * @property string $section_name section name
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Users $createdBy
 * @property AssignedCollegeCourses $assignedCollegeEnc
 * @property OnlineClasses[] $onlineClasses
 * @property UserOtherDetails[] $userOtherDetails
 */
class CollegeSections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%college_sections}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_enc_id', 'assigned_college_enc_id', 'section_name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['section_enc_id', 'assigned_college_enc_id', 'created_by'], 'string', 'max' => 100],
            [['section_name'], 'string', 'max' => 50],
            [['section_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['assigned_college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCollegeCourses::className(), 'targetAttribute' => ['assigned_college_enc_id' => 'assigned_college_enc_id']],
        ];
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
    public function getAssignedCollegeEnc()
    {
        return $this->hasOne(AssignedCollegeCourses::className(), ['assigned_college_enc_id' => 'assigned_college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineClasses()
    {
        return $this->hasMany(OnlineClasses::className(), ['section_enc_id' => 'section_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOtherDetails()
    {
        return $this->hasMany(UserOtherDetails::className(), ['section_enc_id' => 'section_enc_id']);
    }
}
