<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%quizzes}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_enc_id Quiz Encrypted ID
 * @property string $quiz_pool_enc_id Foreign Key to QuizPool Table
 * @property string $currency_enc_id Foreign Key to Currencies Table
 * @property string $name Name of the Quiz
 * @property double $price Price of Quiz
 * @property int $total_marks
 * @property int $time_duration
 * @property int $correct_answer_marks
 * @property int $negetive_marks
 * @property string $assigned_category_enc_id Foreign Key to AssignedCategories Table
 * @property string $slug Quiz Slug
 * @property int $type 1 as Cricket
 * @property int $num_of_ques Number of Question that will displayed on play quiz
 * @property int $template Template of the Quiz
 * @property string $background_image
 * @property string $background_image_location
 * @property string $sharing_image
 * @property string $sharing_image_location
 * @property string $title Quiz Title for SEO Purpose
 * @property string $keywords Quiz Keywords for SEO Purpose
 * @property string $description Quiz Description for SEO Purpose
 * @property string $quiz_start_datetime
 * @property string $quiz_end_datetime
 * @property string $registration_start_datetime
 * @property string $registration_end_datetime
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $display 1 as true , 0 as False
 * @property int $is_login 1 as true 0 as false
 * @property int $is_paid 0 as Free, 1 as Paid
 * @property int $duration quiz timing in min
 * @property int $status
 * @property int $quiz_type quiz type 1 as gaming,2 as skill and 3 as examination
 * @property int $is_deleted
 *
 * @property QuizAssignedGroup[] $quizAssignedGroups
 * @property QuizPayments[] $quizPayments
 * @property QuizRegistration[] $quizRegistrations
 * @property QuizRewards[] $quizRewards
 * @property QuizSponsors[] $quizSponsors
 * @property QuizWidgetTemplates[] $quizWidgetTemplates
 * @property QuizPool $quizPoolEnc
 * @property AssignedCategories $assignedCategoryEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Currencies $currencyEnc
 */
class Quizzes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quizzes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_enc_id', 'quiz_pool_enc_id', 'name', 'slug', 'type', 'num_of_ques', 'template', 'created_by'], 'required'],
            [['price'], 'number'],
            [['total_marks', 'time_duration', 'correct_answer_marks', 'negetive_marks', 'type', 'num_of_ques', 'template', 'display', 'is_login', 'is_paid', 'duration', 'status', 'quiz_type', 'is_deleted'], 'integer'],
            [['description'], 'string'],
            [['quiz_start_datetime', 'quiz_end_datetime', 'registration_start_datetime', 'registration_end_datetime', 'created_on', 'last_updated_on'], 'safe'],
            [['quiz_enc_id', 'quiz_pool_enc_id', 'currency_enc_id', 'name', 'assigned_category_enc_id', 'slug', 'background_image', 'background_image_location', 'sharing_image', 'sharing_image_location', 'title', 'keywords', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_enc_id'], 'unique'],
            [['name', 'slug', 'type', 'is_deleted'], 'unique', 'targetAttribute' => ['name', 'slug', 'type', 'is_deleted']],
            [['quiz_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizPool::className(), 'targetAttribute' => ['quiz_pool_enc_id' => 'quiz_pool_enc_id']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['currency_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['currency_enc_id' => 'currency_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAssignedGroups()
    {
        return $this->hasMany(QuizAssignedGroup::className(), ['quiz_pool_enc_id' => 'quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizPayments()
    {
        return $this->hasMany(QuizPayments::className(), ['quiz_enc_id' => 'quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizRegistrations()
    {
        return $this->hasMany(QuizRegistration::className(), ['quiz_enc_id' => 'quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizRewards()
    {
        return $this->hasMany(QuizRewards::className(), ['quiz_enc_id' => 'quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSponsors()
    {
        return $this->hasMany(QuizSponsors::className(), ['quiz_enc_id' => 'quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizWidgetTemplates()
    {
        return $this->hasMany(QuizWidgetTemplates::className(), ['quiz_enc_id' => 'quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizPoolEnc()
    {
        return $this->hasOne(QuizPool::className(), ['quiz_pool_enc_id' => 'quiz_pool_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategoryEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
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
    public function getCurrencyEnc()
    {
        return $this->hasOne(Currencies::className(), ['currency_enc_id' => 'currency_enc_id']);
    }
}
