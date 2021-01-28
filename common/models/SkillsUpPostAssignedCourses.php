<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_post_assigned_courses}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_enc_id Post Encrypted ID
 * @property string $course_enc_id
 * @property string $post_enc_id
 * @property string $created_on On which date  information was added to database
 * @property string $created_by By which User  information was added
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User  information was updated
 *
 * @property Courses $courseEnc
 * @property SkillsUpPosts $postEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class SkillsUpPostAssignedCourses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%skills_up_post_assigned_courses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_enc_id', 'course_enc_id', 'post_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['assigned_enc_id', 'course_enc_id', 'post_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_enc_id'], 'unique'],
            [['course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::className(), 'targetAttribute' => ['course_enc_id' => 'course_enc_id']],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillsUpPosts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseEnc()
    {
        return $this->hasOne(Courses::className(), ['course_enc_id' => 'course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEnc()
    {
        return $this->hasOne(SkillsUpPosts::className(), ['post_enc_id' => 'post_enc_id']);
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
