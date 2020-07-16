<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_courses}}".
 *
 * @property int $id
 * @property string $college_course_enc_id
 * @property string $organization_enc_id organization_enc_id
 * @property string $course_name Course Name
 * @property int $course_duration Course Durations
 * @property int $years Course Years
 * @property int $semesters course semesters
 * @property string $type year and semesters
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 * @property string $updated_on
 * @property string $updated_by
 *
 * @property Users $createdBy
 * @property Organizations $organizationEnc
 * @property Users $updatedBy
 * @property CollegeSections[] $collegeSections
 * @property OnlineClasses[] $onlineClasses
 * @property UserOtherDetails[] $userOtherDetails
 */
class CollegeCourses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%college_courses}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['college_course_enc_id', 'organization_enc_id', 'course_name', 'created_by', 'created_on'], 'required'],
            [['course_duration', 'years', 'semesters'], 'integer'],
            [['type'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['college_course_enc_id', 'organization_enc_id', 'course_name', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dsbedutech', 'ID'),
            'college_course_enc_id' => Yii::t('dsbedutech', 'College Course Enc ID'),
            'organization_enc_id' => Yii::t('dsbedutech', 'Organization Enc ID'),
            'course_name' => Yii::t('dsbedutech', 'Course Name'),
            'course_duration' => Yii::t('dsbedutech', 'Course Duration'),
            'years' => Yii::t('dsbedutech', 'Years'),
            'semesters' => Yii::t('dsbedutech', 'Semesters'),
            'type' => Yii::t('dsbedutech', 'Type'),
            'created_by' => Yii::t('dsbedutech', 'Created By'),
            'created_on' => Yii::t('dsbedutech', 'Created On'),
            'updated_on' => Yii::t('dsbedutech', 'Updated On'),
            'updated_by' => Yii::t('dsbedutech', 'Updated By'),
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
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
    public function getCollegeSections()
    {
        return $this->hasMany(CollegeSections::className(), ['college_course_enc_id' => 'college_course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineClasses()
    {
        return $this->hasMany(OnlineClasses::className(), ['course_enc_id' => 'college_course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOtherDetails()
    {
        return $this->hasMany(UserOtherDetails::className(), ['course_enc_id' => 'college_course_enc_id']);
    }
}
