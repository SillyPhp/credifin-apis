<?php
namespace common\models;

/**
 * This is the model class for table "{{%quiz_assigned_group}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_assigned_group_enc_id Quiz Assigned Group Encrypted ID
 * @property string $quiz_pool_enc_id Foreign Key to QuizPool Table
 * @property string $assigned_group_enc_id Foreign Key to GroupPool Table
 * @property string $created_by
 * @property string $created_on
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Quizzes $quizPoolEnc
 * @property AssignedCategories $assignedGroupEnc
 */
class QuizAssignedGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz_assigned_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_assigned_group_enc_id', 'quiz_pool_enc_id', 'assigned_group_enc_id', 'created_by', 'created_on'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['quiz_assigned_group_enc_id', 'quiz_pool_enc_id', 'assigned_group_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_assigned_group_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['quiz_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quizzes::className(), 'targetAttribute' => ['quiz_pool_enc_id' => 'quiz_enc_id']],
            [['assigned_group_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_group_enc_id' => 'assigned_category_enc_id']],
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
    public function getQuizPoolEnc()
    {
        return $this->hasOne(Quizzes::className(), ['quiz_enc_id' => 'quiz_pool_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedGroupEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_group_enc_id']);
    }
}
