<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mock_taken_quizzes}}".
 *
 * @property int $id Primary Key
 * @property string $taken_quiz_enc_id Quiz Encrypted ID
 * @property string $quiz_enc_id Foreign Key to MockQuizzes table
 * @property string $user_enc_id Student or user who take quiz
 * @property int $total_marks total quiz marks
 * @property int $negative_marks negative marks
 * @property int $obtained_marks obtained marks
 * @property string $created_on
 *
 * @property MockTakenQuizQuestions[] $mockTakenQuizQuestions
 * @property MockQuizzes $quizEnc
 * @property Users $userEnc
 */
class MockTakenQuizzes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_taken_quizzes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taken_quiz_enc_id', 'quiz_enc_id', 'user_enc_id', 'total_marks'], 'required'],
            [['total_marks', 'negative_marks', 'obtained_marks'], 'integer'],
            [['created_on'], 'safe'],
            [['taken_quiz_enc_id', 'quiz_enc_id', 'user_enc_id'], 'string', 'max' => 100],
            [['taken_quiz_enc_id'], 'unique'],
            [['quiz_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockQuizzes::className(), 'targetAttribute' => ['quiz_enc_id' => 'quiz_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockTakenQuizQuestions()
    {
        return $this->hasMany(MockTakenQuizQuestions::className(), ['taken_quiz_enc_id' => 'taken_quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizEnc()
    {
        return $this->hasOne(MockQuizzes::className(), ['quiz_enc_id' => 'quiz_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }
}
