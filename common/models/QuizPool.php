<?php

namespace common\models;

/**
 * This is the model class for table "{{%quiz_pool}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_pool_enc_id Quiz Encrypted ID
 * @property string $assigned_category_enc_id Quiz Category
 * @property string $name Name of the Quiz
 * @property string $title Quiz Title
 * @property string $keywords Quiz Keywords
 * @property string $description Quiz Description
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $status
 * @property int $is_deleted
 *
 * @property AssignedCategories $assignedCategoryEnc
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property QuizQuestionsPool[] $quizQuestionsPools
 * @property Quizs[] $quizs
 */
class QuizPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_pool_enc_id', 'name', 'created_by'], 'required'],
            [['keywords', 'description'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['quiz_pool_enc_id', 'assigned_category_enc_id', 'name', 'title', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_pool_enc_id'], 'unique'],
            [['name', 'is_deleted'], 'unique', 'targetAttribute' => ['name', 'is_deleted']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
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
    public function getQuizQuestionsPools()
    {
        return $this->hasMany(QuizQuestionsPool::className(), ['quiz_pool_enc_id' => 'quiz_pool_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizs()
    {
        return $this->hasMany(Quizs::className(), ['quiz_pool_enc_id' => 'quiz_pool_enc_id']);
    }
}
