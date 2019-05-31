<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%quiz_answers}}".
 *
 * @property int $id
 * @property string $quiz_answer_enc_id
 * @property string $quiz_question_enc_id
 * @property string $answer
 * @property int $is_answer
 *
 * @property QuizQuestions $quizQuestionEnc
 */
class QuizAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz_answers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_answer_enc_id', 'quiz_question_enc_id', 'answer'], 'required'],
            [['is_answer'], 'integer'],
            [['quiz_answer_enc_id', 'quiz_question_enc_id', 'answer'], 'string', 'max' => 100],
            [['quiz_answer_enc_id'], 'unique'],
            [['quiz_question_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizQuestions::className(), 'targetAttribute' => ['quiz_question_enc_id' => 'quiz_question_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestionEnc()
    {
        return $this->hasOne(QuizQuestions::className(), ['quiz_question_enc_id' => 'quiz_question_enc_id']);
    }
}
