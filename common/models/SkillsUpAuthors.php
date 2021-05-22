<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_authors}}".
 *
 * @property int $id
 * @property string $skills_up_author_enc_id
 * @property string $post_enc_id Post enc Id
 * @property string $author_enc_id Author enc id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Authors $authorEnc
 * @property SkillsUpPosts $postEnc
 */
class SkillsUpAuthors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%skills_up_authors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['skills_up_author_enc_id', 'post_enc_id', 'author_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['skills_up_author_enc_id', 'post_enc_id', 'author_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['skills_up_author_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['author_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::className(), 'targetAttribute' => ['author_enc_id' => 'author_enc_id']],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillsUpPosts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
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
    public function getAuthorEnc()
    {
        return $this->hasOne(Authors::className(), ['author_enc_id' => 'author_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEnc()
    {
        return $this->hasOne(SkillsUpPosts::className(), ['post_enc_id' => 'post_enc_id']);
    }
}
