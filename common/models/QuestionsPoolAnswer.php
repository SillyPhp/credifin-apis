<?php

namespace common\models;


/**
 * This is the model class for table "{{%questions_pool_answer}}".
 *
 * @property int $id Primary Key
 * @property string $answer_enc_id Answer Encrypted ID
 * @property string $question_pool_enc_id Linked To Question Encrypted ID
 * @property string $answer Answer
 * @property string $image Image
 * @property string $image_location Image Location
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property QuestionsPool $questionPoolEnc
 */
class QuestionsPoolAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%questions_pool_answer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_enc_id', 'question_pool_enc_id', 'answer', 'created_by'], 'required'],
            [['answer'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['answer_enc_id', 'question_pool_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['answer_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['question_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionsPool::className(), 'targetAttribute' => ['question_pool_enc_id' => 'question_pool_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionPoolEnc()
    {
        return $this->hasOne(QuestionsPool::className(), ['question_pool_enc_id' => 'question_pool_enc_id']);
    }
}
