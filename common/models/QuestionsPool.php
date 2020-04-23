<?php

namespace common\models;


/**
 * This is the model class for table "{{%questions_pool}}".
 *
 * @property int $id Primary Key
 * @property string $question_pool_enc_id Question Encrypted ID
 * @property string $topic_enc_id Topic for the question linked to assigned category
 * @property string $questaion_number Question Number
 * @property string $difficulty Difficulty
 * @property int $privacy 1 as Public 0 as Private
 * @property string $question Question
 * @property string $slug Slug of question
 * @property string $image Image
 * @property string $image_location Image Location
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $status
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property QuestionPoolTags[] $questionPoolTags
 * @property AssignedTags[] $tagEncs
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property AssignedCategories $topicEnc
 * @property QuestionsPoolAnswer[] $questionsPoolAnswers
 */
class QuestionsPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%questions_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_pool_enc_id', 'topic_enc_id', 'questaion_number', 'privacy', 'question', 'slug', 'created_by'], 'required'],
            [['difficulty'], 'string'],
            [['privacy', 'status', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['question_pool_enc_id', 'questaion_number', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['topic_enc_id', 'question'], 'string', 'max' => 200],
            [['slug'], 'string', 'max' => 250],
            [['question_pool_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['questaion_number'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['topic_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['topic_enc_id' => 'assigned_category_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionPoolTags()
    {
        return $this->hasMany(QuestionPoolTags::className(), ['question_pool_enc_id' => 'question_pool_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagEncs()
    {
        return $this->hasMany(AssignedTags::className(), ['tag_enc_id' => 'tag_enc_id'])->viaTable('{{%question_pool_tags}}', ['question_pool_enc_id' => 'question_pool_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'topic_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsPoolAnswers()
    {
        return $this->hasMany(QuestionsPoolAnswer::className(), ['question_pool_enc_id' => 'question_pool_enc_id']);
    }
}
