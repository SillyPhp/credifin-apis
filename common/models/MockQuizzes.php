<?php

namespace common\models;

/**
 * This is the model class for table "{{%mock_quizzes}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_enc_id Quiz Encrypted ID
 * @property string $name Name of the Quiz
 * @property int $per_ques_marks
 * @property int $total_marks
 * @property int $per_ques_time
 * @property int $total_time
 * @property int $negetive_marks
 * @property string $slug Quiz Slug
 * @property int $total_questions Number of Question that will displayed on play quiz
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted
 *
 * @property MockAssignedQuizPool[] $mockAssignedQuizPools
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class MockQuizzes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_quizzes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_enc_id', 'name', 'slug', 'total_questions', 'created_by'], 'required'],
            [['per_ques_marks', 'total_marks', 'per_ques_time', 'total_time', 'negetive_marks', 'total_questions', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['quiz_enc_id', 'name', 'slug', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockAssignedQuizPools()
    {
        return $this->hasMany(MockAssignedQuizPool::className(), ['quiz_enc_id' => 'quiz_enc_id']);
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
