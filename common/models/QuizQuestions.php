<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%quiz_questions}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_question_enc_id Quiz Question Encrypted ID
 * @property string $quiz_enc_id Quiz Encrypted Id
 * @property string $category Quiz Category
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
 * @property QuizAnswers[] $quizAnswers
 * @property Quiz $quizEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class QuizQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz_questions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_question_enc_id', 'quiz_enc_id', 'category', 'type', 'difficulty', 'question', 'created_by'], 'required'],
            [['type', 'difficulty', 'question'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['quiz_question_enc_id', 'quiz_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['category'], 'string', 'max' => 50],
            [['quiz_question_enc_id'], 'unique'],
            [['quiz_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_enc_id' => 'quiz_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAnswers()
    {
        return $this->hasMany(QuizAnswers::className(), ['quiz_question_enc_id' => 'quiz_question_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizEnc()
    {
        return $this->hasOne(Quiz::className(), ['quiz_enc_id' => 'quiz_enc_id']);
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
