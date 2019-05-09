<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%new_organization_reviews}}".
 *
 * @property int $id Primary Key
 * @property string $review_enc_id Review Encrypted ID
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $average_rating Average Rating
 * @property int $reviewer_type Type of Reviewer (0 as Former Employee, 1 as Current Employee, 2 as former college Student 3 as current college student 4 as former school student 5 as current school student 6 as former institute stuudent 7 as current institute student)
 * @property int $overall_experience Overall Experience
 * @property int $skill_development Skill Development & Learning
 * @property int $work_life Work-Life Balance
 * @property int $compensation Compensation & Benefits
 * @property int $organization_culture Organization Culture
 * @property int $job_security Job Security
 * @property int $growth Growth & Opportunities
 * @property int $work Work Satisfaction
 * @property int $academics Academics
 * @property int $faculty_teaching_quality Faculty & Teaching Quality
 * @property int $infrastructure Infrastructure
 * @property int $accomodation_food Accomodation & Food
 * @property int $placements_internships Placements/Internships
 * @property int $social_life_extracurriculars Social Life/Extracurriculars
 * @property int $culture_diversity Culture
 * @property int $student_engagement student_engagement
 * @property int $school_infrastructure school_infrastructure
 * @property int $faculty faculty
 * @property int $value_for_money value_for_money
 * @property int $teacihng_style teaching_style
 * @property int $coverage_of_subject_matter coverage_of_subject_matter
 * @property int $accessibility_of_faculty accessibility_of_faculty
 * @property int $co_curricular_activities co_curricular_activities
 * @property int $leadership_development leadership_development
 * @property int $sports sports
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $educational_stream_enc_id Foreign Key to education requirements
 * @property string $category_enc_id Foreign Key to Categories Table
 * @property string $designation_enc_id Foreign Key to Designation Table
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
 * @property Qualifications $educationalStreamEnc
 * @property Users $createdBy
 * @property Cities $cityEnc
 * @property Categories $categoryEnc
 * @property Users $lastUpdatedBy
 * @property UnclaimedOrganizations $organizationEnc
 * @property Designations $designationEnc
 */
class NewOrganizationReviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%new_organization_reviews}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['review_enc_id', 'organization_enc_id', 'average_rating', 'reviewer_type', 'city_enc_id', 'likes', 'dislikes', 'from_date', 'created_by'], 'required'],
            [['average_rating'], 'number'],
            [['reviewer_type', 'overall_experience', 'skill_development', 'work_life', 'compensation', 'organization_culture', 'job_security', 'growth', 'work', 'academics', 'faculty_teaching_quality', 'infrastructure', 'accomodation_food', 'placements_internships', 'social_life_extracurriculars', 'culture_diversity', 'student_engagement', 'school_infrastructure', 'faculty', 'value_for_money', 'teaching_style', 'coverage_of_subject_matter', 'accessibility_of_faculty', 'co_curricular_activities', 'leadership_development', 'sports', 'show_user_details', 'status', 'is_deleted'], 'integer'],
            [['likes', 'dislikes'], 'string'],
            [['from_date', 'to_date', 'created_on', 'last_updated_on'], 'safe'],
            [['review_enc_id', 'organization_enc_id', 'city_enc_id', 'educational_stream_enc_id', 'category_enc_id', 'designation_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['review_enc_id'], 'unique'],
            [['educational_stream_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualifications::className(), 'targetAttribute' => ['educational_stream_enc_id' => 'qualification_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['designation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation_enc_id' => 'designation_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryEnc()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'category_enc_id']);
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(UnclaimedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignationEnc()
    {
        return $this->hasOne(Designations::className(), ['designation_enc_id' => 'designation_enc_id']);
    }
}
