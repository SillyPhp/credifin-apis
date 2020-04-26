<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_sections}}".
 *
 * @property int $id
 * @property string $section_enc_id section encrypted id
 * @property string $college_course_enc_id college course encrypted id
 * @property string $section_name section name
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property CollegeCourses $collegeCourseEnc
 * @property Users $createdBy
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
            [['section_enc_id', 'college_course_enc_id', 'section_name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['section_enc_id', 'college_course_enc_id', 'created_by'], 'string', 'max' => 100],
            [['section_name'], 'string', 'max' => 50],
            [['section_enc_id'], 'unique'],
            [['college_course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeCourses::className(), 'targetAttribute' => ['college_course_enc_id' => 'college_course_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeCourseEnc()
    {
        return $this->hasOne(CollegeCourses::className(), ['college_course_enc_id' => 'college_course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
