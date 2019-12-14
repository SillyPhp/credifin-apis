<?php
namespace common\models;
/**
 * This is the model class for table "{{%assigned_categories}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_category_enc_id Assigned Category Encrypted ID
 * @property string $category_enc_id Foreign Key to Categories Table
 * @property string $parent_enc_id Foreign Key to Categories Table
 * @property string $assigned_to Assigned To
 * @property string $icon SVG Icon
 * @property string $icon_location SVG Icon Location
 * @property string $icon_png PNG Icon
 * @property string $icon_png_location PNG icon location
 * @property string $banner Banner image for video category
 * @property string $banner_location Banner image Location for video category
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $description description for seo purpose
 * @property string $created_on On which date Category information was added to database
 * @property string $created_by By which User Category information was added
 * @property string $last_updated_on On which date Category information was updated
 * @property string $last_updated_by By which User Category information was updated
 * @property string $status Assigned Category Status (Approved, Pending)
 * @property int $is_deleted Is Assigned Category Deleted (0 as False, 1 as True)
 *
 * @property CareerAdvisePosts[] $careerAdvisePosts
 * @property CategoryTags[] $categoryTags
 * @property QuestionsPool[] $questionsPools
 * @property QuizPool[] $quizPools
 * @property Quizs[] $quizs
 * @property TrainingProgramApplication[] $trainingProgramApplications
 * @property TwitterJobs[] $twitterJobs
 * @property ApplicationTemplates[] $applicationTemplates
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Categories $categoryEnc
 * @property Categories $parentEnc
 * @property EmployerApplications[] $employerApplications
 * @property LearningVideos[] $learningVideos
 * @property PostCategories[] $postCategories
 * @property Users[] $users
 */
class AssignedCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_categories}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_category_enc_id', 'category_enc_id', 'assigned_to'], 'required'],
            [['assigned_to', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_category_enc_id', 'category_enc_id', 'parent_enc_id', 'icon', 'icon_location', 'icon_png', 'icon_png_location', 'banner', 'banner_location', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['assigned_category_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
            [['parent_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['parent_enc_id' => 'category_enc_id']],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareerAdvisePosts()
    {
        return $this->hasMany(CareerAdvisePosts::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryTags()
    {
        return $this->hasMany(CategoryTags::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsPools()
    {
        return $this->hasMany(QuestionsPool::className(), ['topic_enc_id' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizPools()
    {
        return $this->hasMany(QuizPool::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizs()
    {
        return $this->hasMany(Quizs::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgramApplications()
    {
        return $this->hasMany(TrainingProgramApplication::className(), ['title' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitterJobs()
    {
        return $this->hasMany(TwitterJobs::className(), ['job_title' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTemplates()
    {
        return $this->hasMany(ApplicationTemplates::className(), ['title' => 'assigned_category_enc_id']);
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
    public function getCategoryEnc()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentEnc()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'parent_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications()
    {
        return $this->hasMany(EmployerApplications::className(), ['title' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningVideos()
    {
        return $this->hasMany(LearningVideos::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['asigned_job_function' => 'assigned_category_enc_id']);
    }
}