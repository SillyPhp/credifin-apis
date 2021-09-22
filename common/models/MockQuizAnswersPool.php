<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mock_quiz_answers_pool}}".
 *
 * @property int $id
 * @property string $quiz_answer_pool_enc_id
 * @property string $quiz_question_pool_enc_id
 * @property string $answer
 * @property int $is_answer
 * @property string $created_on
 *
 * @property MockQuizQuestionsPool $quizQuestionPoolEnc
 */
class MockQuizAnswersPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_quiz_answers_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_answer_pool_enc_id', 'quiz_question_pool_enc_id', 'answer'], 'required'],
            [['is_answer'], 'integer'],
            [['created_on'], 'safe'],
            [['quiz_answer_pool_enc_id', 'quiz_question_pool_enc_id'], 'string', 'max' => 100],
            [['answer'], 'string', 'max' => 255],
            [['quiz_answer_pool_enc_id'], 'unique'],
            [['quiz_question_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockQuizQuestionsPool::className(), 'targetAttribute' => ['quiz_question_pool_enc_id' => 'quiz_question_pool_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestionPoolEnc()
    {
        return $this->hasOne(MockQuizQuestionsPool::className(), ['quiz_question_pool_enc_id' => 'quiz_question_pool_enc_id']);
    }
}
