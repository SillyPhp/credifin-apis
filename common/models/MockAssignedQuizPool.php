<?php

namespace common\models;

/**
 * This is the model class for table "{{%mock_assigned_quiz_pool}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_quiz_pool_enc_id Quiz Encrypted ID
 * @property string $quiz_enc_id Foreign Key to MockQuizzes Table
 * @property string $quiz_pool_enc_id Foreign Key to MockQuizPool Table
 * @property string $min Minimum value per pool
 * @property double $max Maximum value per pool
 * @property int $is_deleted
 *
 * @property MockQuizzes $quizEnc
 * @property MockQuizPool $quizPoolEnc
 */
class MockAssignedQuizPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_assigned_quiz_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_quiz_pool_enc_id', 'quiz_enc_id', 'quiz_pool_enc_id', 'min'], 'required'],
            [['max'], 'number'],
            [['is_deleted'], 'integer'],
            [['assigned_quiz_pool_enc_id', 'quiz_enc_id', 'quiz_pool_enc_id', 'min'], 'string', 'max' => 100],
            [['assigned_quiz_pool_enc_id'], 'unique'],
            [['quiz_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockQuizzes::className(), 'targetAttribute' => ['quiz_enc_id' => 'quiz_enc_id']],
            [['quiz_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockQuizPool::className(), 'targetAttribute' => ['quiz_pool_enc_id' => 'quiz_pool_enc_id']],
        ];
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
    public function getQuizPoolEnc()
    {
        return $this->hasOne(MockQuizPool::className(), ['quiz_pool_enc_id' => 'quiz_pool_enc_id']);
    }
}
