<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mock_taken_quiz_questions}}".
 *
 * @property int $id Primary Key
 * @property string $taken_question_enc_id Quiz Encrypted ID
 * @property string $taken_quiz_enc_id Foreign Key to MockTakenQuizzes table
 * @property string $quiz_question_pool_enc_id Foreign Key to MockQuizQuestionsPool
 * @property string $quiz_answer_pool_enc_id
 * @property int $is_correct NULL as not attempt, 0 as wrong answer, 1 as right answer
 * @property string $time_taken
 * @property string $created_on
 * @property string $updated_on
 *
 * @property MockTakenQuizzes $takenQuizEnc
 * @property MockQuizQuestionsPool $quizQuestionPoolEnc
 * @property MockQuizAnswersPool $quizAnswerPoolEnc
 */
class MockTakenQuizQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_taken_quiz_questions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taken_question_enc_id', 'taken_quiz_enc_id', 'quiz_question_pool_enc_id'], 'required'],
            [['is_correct'], 'integer'],
            [['time_taken', 'created_on', 'updated_on'], 'safe'],
            [['taken_question_enc_id', 'taken_quiz_enc_id', 'quiz_question_pool_enc_id', 'quiz_answer_pool_enc_id'], 'string', 'max' => 100],
            [['taken_question_enc_id'], 'unique'],
            [['taken_quiz_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockTakenQuizzes::className(), 'targetAttribute' => ['taken_quiz_enc_id' => 'taken_quiz_enc_id']],
            [['quiz_question_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockQuizQuestionsPool::className(), 'targetAttribute' => ['quiz_question_pool_enc_id' => 'quiz_question_pool_enc_id']],
            [['quiz_answer_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockQuizAnswersPool::className(), 'targetAttribute' => ['quiz_answer_pool_enc_id' => 'quiz_answer_pool_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTakenQuizEnc()
    {
        return $this->hasOne(MockTakenQuizzes::className(), ['taken_quiz_enc_id' => 'taken_quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestionPoolEnc()
    {
        return $this->hasOne(MockQuizQuestionsPool::className(), ['quiz_question_pool_enc_id' => 'quiz_question_pool_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAnswerPoolEnc()
    {
        return $this->hasOne(MockQuizAnswersPool::className(), ['quiz_answer_pool_enc_id' => 'quiz_answer_pool_enc_id']);
    }
}
