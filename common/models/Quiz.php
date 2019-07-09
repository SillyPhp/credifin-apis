<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%quiz}}".
 *
 * @property int $id Primary Key
 * @property string $name Name of the Quiz
 * @property string $quiz_enc_id Quiz Encrypted ID
 * @property string $assigned_category_enc_id Quiz Category
 * @property string $slug Quiz Slug
 * @property int $type 1 as Cricket
 * @property int $template Template of the Quiz
 * @property string $background_image
 * @property string $background_image_location
 * @property string $sharing_image
 * @property string $sharing_image_location
 * @property string $title Quiz Title
 * @property string $keywords Quiz Keywords
 * @property string $description Quiz Description
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $display
 * @property int $status
 * @property int $is_deleted
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property AssignedCategories $assignedCategoryEnc
 * @property QuizQuestions[] $quizQuestions
 */
class Quiz extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quiz}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'quiz_enc_id', 'slug', 'type', 'template', 'created_by'], 'required'],
            [['type', 'template', 'display', 'status', 'is_deleted'], 'integer'],
            [['description'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['name', 'quiz_enc_id', 'assigned_category_enc_id', 'slug', 'background_image', 'background_image_location', 'sharing_image', 'sharing_image_location', 'title', 'keywords', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_enc_id'], 'unique'],
            [['name', 'slug', 'type'], 'unique', 'targetAttribute' => ['name', 'slug', 'type']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
        ];
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
    public function getAssignedCategoryEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestions()
    {
        return $this->hasMany(QuizQuestions::className(), ['quiz_enc_id' => 'quiz_enc_id']);
    }
}
