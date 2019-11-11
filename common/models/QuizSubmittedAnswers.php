<?php

namespace common\models;

/**
 * This is the model class for table "{{%quiz_submitted_answers}}".
 *
 * @property int $id
 * @property string $quiz_submitted_answers_enc_id
 * @property string $quiz_question_pool_enc_id
 * @property string $answer_enc_id
 * @property string $user_enc_id
 * @property string $quiz_slug
 * @property int $consumed_time
 * @property int $is_correct
 */
class QuizSubmittedAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz_submitted_answers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_submitted_answers_enc_id', 'quiz_question_pool_enc_id', 'answer_enc_id', 'user_enc_id', 'quiz_slug', 'consumed_time'], 'required'],
            [['consumed_time', 'is_correct'], 'integer'],
            [['quiz_submitted_answers_enc_id', 'quiz_question_pool_enc_id', 'answer_enc_id', 'user_enc_id', 'quiz_slug'], 'string', 'max' => 100],
            [['quiz_submitted_answers_enc_id'], 'unique'],
        ];
    }
}
