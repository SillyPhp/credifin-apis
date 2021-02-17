<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%authors}}".
 *
 * @property int $id
 * @property string $author_enc_id Author enc Id
 * @property string $name  Name
 * @property string $image
 * @property string $image_location
 * @property string $author_bio
 * @property string $website
 * @property string $contact_info
 * @property string $email
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property CoursesAuthors[] $coursesAuthors
 * @property SkillsUpAuthors[] $skillsUpAuthors
 */
class Authors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%authors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_enc_id', 'name', 'created_by'], 'required'],
            [['author_bio'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['author_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name', 'image', 'image_location', 'website', 'email'], 'string', 'max' => 255],
            [['contact_info'], 'string', 'max' => 15],
            [['author_enc_id'], 'unique'],
            [['website'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getCoursesAuthors()
    {
        return $this->hasMany(CoursesAuthors::className(), ['author_enc_id' => 'author_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpAuthors()
    {
        return $this->hasMany(SkillsUpAuthors::className(), ['author_enc_id' => 'author_enc_id']);
    }
}
