<?php
namespace common\models;
use Yii;
/**
 * This is the model class for table "{{%quiz_pool}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_pool_enc_id Quiz Encrypted ID
 * @property string $assigned_category_enc_id Quiz Category
 * @property string $group_enc_id
 * @property string $topic_enc_id
 * @property string $subject_enc_id
 * @property string $name Name of the Quiz
 * @property string $title Quiz Title
 * @property string $keywords Quiz Keywords
 * @property string $description Quiz Description
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $status
 * @property int $is_deleted
 * @property int $is_pinned 1 as true and 0 as false
 *
 * @property AssignedCategories $assignedCategoryEnc
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property AssignedCategories $groupEnc
 * @property AssignedCategories $subjectEnc
 * @property Topics $topicEnc
 * @property QuizQuestionsPool[] $quizQuestionsPools
 * @property Quizzes[] $quizzes
 */
class QuizPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_pool_enc_id', 'name', 'created_by'], 'required'],
            [['keywords', 'description'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted', 'is_pinned'], 'integer'],
            [['quiz_pool_enc_id', 'assigned_category_enc_id', 'group_enc_id', 'topic_enc_id', 'subject_enc_id', 'name', 'title', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_pool_enc_id'], 'unique'],
            [['name', 'is_deleted'], 'unique', 'targetAttribute' => ['name', 'is_deleted']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['group_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['group_enc_id' => 'assigned_category_enc_id']],
            [['subject_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['subject_enc_id' => 'assigned_category_enc_id']],
            [['topic_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topics::className(), 'targetAttribute' => ['topic_enc_id' => 'topic_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategoryEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'group_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'subject_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicEnc()
    {
        return $this->hasOne(Topics::className(), ['topic_enc_id' => 'topic_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestionsPools()
    {
        return $this->hasMany(QuizQuestionsPool::className(), ['quiz_pool_enc_id' => 'quiz_pool_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizzes()
    {
        return $this->hasMany(Quizzes::className(), ['quiz_pool_enc_id' => 'quiz_pool_enc_id']);
    }
}
