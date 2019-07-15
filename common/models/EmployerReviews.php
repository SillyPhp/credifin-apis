<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%employer_reviews}}".
 *
 * @property int $id Primary Key
 * @property string $employer_review_enc_id Review Encrypted ID
 * @property string $review_enc_id
 * @property double $average_rating Average Rating
 * @property int $is_current_employee Is Current Employee (0 as Former Employee, 1 as Current Employee)
 * @property int $skill_development Skill Development & Learning
 * @property int $work_life Work-Life Balance
 * @property int $compensation Compensation & Benefits
 * @property int $organization_culture Organization Culture
 * @property int $job_security Job Security
 * @property int $growth Growth & Opportunities
 * @property int $work Work Satisfaction
 * @property string $city_enc_id Foreign Key to Cities Table
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
 * @property Reviews $reviewEnc
 * @property Cities $cityEnc
 * @property Categories $categoryEnc
 * @property Designations $designationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class EmployerReviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employer_reviews}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_review_enc_id', 'review_enc_id', 'average_rating', 'skill_development', 'work_life', 'compensation', 'organization_culture', 'job_security', 'growth', 'work', 'city_enc_id', 'category_enc_id', 'likes', 'dislikes', 'from_date'], 'required'],
            [['average_rating'], 'number'],
            [['is_current_employee', 'skill_development', 'work_life', 'compensation', 'organization_culture', 'job_security', 'growth', 'work', 'show_user_details', 'status', 'is_deleted'], 'integer'],
            [['likes', 'dislikes'], 'string'],
            [['from_date', 'to_date', 'created_on', 'last_updated_on'], 'safe'],
            [['employer_review_enc_id', 'review_enc_id', 'city_enc_id', 'category_enc_id', 'designation_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['employer_review_enc_id'], 'unique'],
            [['review_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reviews::className(), 'targetAttribute' => ['review_enc_id' => 'reviews_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
            [['designation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation_enc_id' => 'designation_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
}
