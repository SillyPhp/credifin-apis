<?php

namespace common\models;

/**
 * This is the model class for table "{{%quizs}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_enc_id Quiz Encrypted ID
 * @property string $quiz_pool_enc_id Foreign Key to QuizPool Table
 * @property string $name Name of the Quiz
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
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $display 1 as true , 0 as False
 * @property int $is_login 1 as true 0 as false
 * @property int $duration quiz timing in min
 * @property int $status
 * @property int $is_deleted
 *
 * @property QuizPool $quizPoolEnc
 * @property AssignedCategories $assignedCategoryEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class Quizs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quizs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_enc_id', 'quiz_pool_enc_id', 'name', 'slug', 'type', 'num_of_ques', 'template', 'created_by'], 'required'],
            [['type', 'num_of_ques', 'template', 'display', 'is_login', 'duration', 'status', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['quiz_enc_id', 'quiz_pool_enc_id', 'name', 'assigned_category_enc_id', 'slug', 'background_image', 'background_image_location', 'sharing_image', 'sharing_image_location', 'title', 'keywords', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 160],
            [['quiz_enc_id'], 'unique'],
            [['name', 'slug', 'type', 'is_deleted'], 'unique', 'targetAttribute' => ['name', 'slug', 'type', 'is_deleted']],
            [['quiz_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizPool::className(), 'targetAttribute' => ['quiz_pool_enc_id' => 'quiz_pool_enc_id']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
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
}
