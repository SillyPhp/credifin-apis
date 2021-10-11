<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_cutoff}}".
 *
 * @property int $id
 * @property string $college_cut_off_enc_id
 * @property string $assgined_course_enc_id
 * @property string $college_enc_id
 * @property double $general
 * @property double $obc
 * @property double $sc
 * @property double $st
 * @property double $pwd
 * @property double $ews
 * @property int $mode 0 percentage, 1 percentile
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property AssignedCollegeCourses $assginedCourseEnc
 * @property Organizations $collegeEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class CollegeCutoff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_cutoff}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['college_cut_off_enc_id', 'assgined_course_enc_id', 'college_enc_id', 'created_by'], 'required'],
            [['general', 'obc', 'sc', 'st', 'pwd', 'ews'], 'number'],
            [['mode', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['college_cut_off_enc_id', 'assgined_course_enc_id', 'college_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['college_cut_off_enc_id'], 'unique'],
            [['assgined_course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCollegeCourses::className(), 'targetAttribute' => ['assgined_course_enc_id' => 'assigned_college_enc_id']],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssginedCourseEnc()
    {
        return $this->hasOne(AssignedCollegeCourses::className(), ['assigned_college_enc_id' => 'assgined_course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
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
}
