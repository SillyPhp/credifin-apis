<?php

namespace common\models;

/**
 * This is the model class for table "{{%quiz_questions_pool}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_question_pool_enc_id Quiz Question Encrypted ID
 * @property string $quiz_pool_enc_id Quiz Encrypted Id
 * @property string $type Quiz Type
 * @property string $difficulty Quiz Difficulty
 * @property string $question Quiz Question
 * @property string $image Image
 * @property string $image_location Image Location
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $status
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property QuizAnswersPool[] $quizAnswersPools
 * @property QuizPool $quizPoolEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class QuizQuestionsPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz_questions_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_question_pool_enc_id', 'quiz_pool_enc_id', 'question', 'created_by'], 'required'],
            [['type', 'difficulty', 'question'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['quiz_question_pool_enc_id', 'quiz_pool_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_question_pool_enc_id'], 'unique'],
            [['quiz_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizPool::className(), 'targetAttribute' => ['quiz_pool_enc_id' => 'quiz_pool_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAnswersPools()
    {
        return $this->hasMany(QuizAnswersPool::className(), ['quiz_question_pool_enc_id' => 'quiz_question_pool_enc_id']);
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
