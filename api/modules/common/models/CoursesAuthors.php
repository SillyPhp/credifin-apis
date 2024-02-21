<?php

namespace common\models;

/**
 * This is the model class for table "{{%courses_authors}}".
 *
 * @property int $id
 * @property string $course_author_enc_id
 * @property string $course_enc_id Course enc Id
 * @property string $author_enc_id Author enc id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Authors $authorEnc
 * @property Courses $courseEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class CoursesAuthors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%courses_authors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_author_enc_id', 'course_enc_id', 'author_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['course_author_enc_id', 'course_enc_id', 'author_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['course_author_enc_id'], 'unique'],
            [['author_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::className(), 'targetAttribute' => ['author_enc_id' => 'author_enc_id']],
            [['course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::className(), 'targetAttribute' => ['course_enc_id' => 'course_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorEnc()
    {
        return $this->hasOne(Authors::className(), ['author_enc_id' => 'author_enc_id']);
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
