<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%institute_students_review}}".
 *
 * @property int $id Primary Key
 * @property string $institute_student_review_enc_id Organization Review Encrypted ID
 * @property string $review_enc_id type of review
 * @property string $average_rating Average Rating
 * @property int $is_current_employee Is Current Employee (0 as Former Employee, 1 as Current Employee)
 * @property int $student_engagement
 * @property int $infrastructure
 * @property int $faculty
 * @property int $value_for_money
 * @property int $teaching_style
 * @property int $coverage_of_subject_matter
 * @property int $accessibility_of_faculty
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $educational_stream_enc_id Foreign Key to Qualifications
 * @property string $likes Things you like about the Organization
 * @property string $dislikes Things you dislike about the Organization
 * @property string $from_date From Date
 * @property string $to_date To Date
 * @property int $show_user_details Show User Details (0 as No, 1 as Yes)
 * @property string $created_on On which date Organization Review  information was added to database
 * @property string $created_by By which User Organization Review information was added
 * @property string $last_updated_on On which date Organization Review  information was updated
 * @property string $last_updated_by By which User Organization Review information was updated
 * @property int $status Organization Review Status (0 as Pending, 1 as Approved)
 * @property int $is_deleted Is Organization Review Deleted (0 as False, 1 as True)
 *
 * @property Reviews $reviewEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Qualifications $educationalStreamEnc
 * @property Cities $cityEnc
 */
class InstituteStudentsReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%institute_students_review}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['institute_student_review_enc_id', 'average_rating', 'student_engagement', 'infrastructure', 'faculty', 'value_for_money', 'teaching_style', 'coverage_of_subject_matter', 'accessibility_of_faculty', 'city_enc_id', 'likes', 'dislikes', 'from_date', 'created_by'], 'required'],
            [['average_rating'], 'number'],
            [['is_current_employee', 'student_engagement', 'infrastructure', 'faculty', 'value_for_money', 'teaching_style', 'coverage_of_subject_matter', 'accessibility_of_faculty', 'show_user_details', 'status', 'is_deleted'], 'integer'],
            [['likes', 'dislikes'], 'string'],
            [['from_date', 'to_date', 'created_on', 'last_updated_on'], 'safe'],
            [['institute_student_review_enc_id', 'review_enc_id', 'city_enc_id', 'educational_stream_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['institute_student_review_enc_id'], 'unique'],
            [['review_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reviews::className(), 'targetAttribute' => ['review_enc_id' => 'reviews_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['educational_stream_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualifications::className(), 'targetAttribute' => ['educational_stream_enc_id' => 'qualification_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewEnc()
    {
        return $this->hasOne(Reviews::className(), ['reviews_enc_id' => 'review_enc_id']);
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
    public function getEducationalStreamEnc()
    {
        return $this->hasOne(Qualifications::className(), ['qualification_enc_id' => 'educational_stream_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }
}
