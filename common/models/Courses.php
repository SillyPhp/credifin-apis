<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%courses}}".
 *
 * @property int $id
 * @property string $course_enc_id Course enc Id
 * @property string $source_enc_id source course provider enc id
 * @property string $title Course Name
 * @property string $description
 * @property string $url Course Url
 * @property string $image Course Thumbnail
 * @property string $banner_image Course Thumbnail  banner
 * @property int $is_paid 1 is paid and 0 is free
 * @property string $currency Currency Code
 * @property double $price Course Price
 * @property double $discount Any Discount
 * @property int $course_duration Course duration
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property CourseLabels[] $courseLabels
 * @property Users $lastUpdatedBy
 * @property SkillsUpSources $sourceEnc
 * @property CoursesAuthors[] $coursesAuthors
 * @property CoursesCategories[] $coursesCategories
 * @property SkillsUpPostAssignedCourses[] $skillsUpPostAssignedCourses
 */
class Courses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%courses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_enc_id', 'title', 'is_paid', 'price'], 'required'],
            [['description'], 'string'],
            [['is_paid', 'course_duration'], 'integer'],
            [['price', 'discount'], 'number'],
            [['last_updated_on'], 'safe'],
            [['course_enc_id', 'source_enc_id', 'currency', 'last_updated_by'], 'string', 'max' => 100],
            [['title', 'url', 'image', 'banner_image'], 'string', 'max' => 255],
            [['course_enc_id'], 'unique'],
            [['url'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['source_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillsUpSources::className(), 'targetAttribute' => ['source_enc_id' => 'source_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseLabels()
    {
        return $this->hasMany(CourseLabels::className(), ['course_enc_id' => 'course_enc_id']);
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
    public function getSourceEnc()
    {
        return $this->hasOne(SkillsUpSources::className(), ['source_enc_id' => 'source_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoursesAuthors()
    {
        return $this->hasMany(CoursesAuthors::className(), ['course_enc_id' => 'course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoursesCategories()
    {
        return $this->hasMany(CoursesCategories::className(), ['course_enc_id' => 'course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPostAssignedCourses()
    {
        return $this->hasMany(SkillsUpPostAssignedCourses::className(), ['course_enc_id' => 'course_enc_id']);
    }
}
