<?php

namespace common\models;

/**
 * This is the model class for table "{{%quiz_answers_pool}}".
 *
 * @property int $id
 * @property string $quiz_answer_pool_enc_id
 * @property string $quiz_question_pool_enc_id
 * @property string $answer
 * @property int $is_answer
 *
 * @property QuizQuestionsPool $quizQuestionPoolEnc
 */
class QuizAnswersPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz_answers_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_answer_pool_enc_id', 'quiz_question_pool_enc_id', 'answer'], 'required'],
            [['is_answer'], 'integer'],
            [['quiz_answer_pool_enc_id', 'quiz_question_pool_enc_id', 'answer'], 'string', 'max' => 100],
            [['quiz_answer_pool_enc_id'], 'unique'],
            [['quiz_question_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizQuestionsPool::className(), 'targetAttribute' => ['quiz_question_pool_enc_id' => 'quiz_question_pool_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestionPoolEnc()
    {
        return $this->hasOne(QuizQuestionsPool::className(), ['quiz_question_pool_enc_id' => 'quiz_question_pool_enc_id']);
    }
}