<?php

namespace common\models;

/**
 * This is the model class for table "{{%question_pool_tags}}".
 *
 * @property int $id Primary Key
 * @property string $question_tag_enc_id Video Tag Encrypted ID
 * @property string $question_pool_enc_id Foreign Key to Question Pool
 * @property string $tag_enc_id Foreign Key to Tags Table
 * @property string $created_on On which date Video Tag information was added to database
 * @property string $created_by By which User Video Tag information was added
 * @property string $last_updated_on On which date Video nTag information was updated
 * @property string $last_updated_by By which User Video Tag information was updated
 * @property int $is_deleted Is Tag Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Tags $tagEnc
 * @property QuestionsPool $questionPoolEnc
 */
class QuestionPoolTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question_pool_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_tag_enc_id', 'question_pool_enc_id', 'tag_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['question_tag_enc_id', 'question_pool_enc_id', 'tag_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['question_tag_enc_id'], 'unique'],
            [['question_pool_enc_id', 'tag_enc_id'], 'unique', 'targetAttribute' => ['question_pool_enc_id', 'tag_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['tag_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_enc_id' => 'tag_enc_id']],
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
    public function getTagEnc()
    {
        return $this->hasOne(Tags::className(), ['tag_enc_id' => 'tag_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionPoolEnc()
    {
        return $this->hasOne(QuestionsPool::className(), ['question_pool_enc_id' => 'question_pool_enc_id']);
    }
}
