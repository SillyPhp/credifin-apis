<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_likes_dislikes}}".
 *
 * @property int $id Primary Key
 * @property string $post_like_dislike_enc_id Feedback Encrypted ID
 * @property string $post_enc_id Foreign Key to POST table
 * @property int $feedback_status 1 as like 0 as unlike 2 as dislike
 * @property string $remarks Any Remarks
 * @property string $created_on On which date  POST Like Dislike information was added to database
 * @property string $created_by By which User POST Like Dislike information was added
 * @property string $last_updated_on On which date POST Like Dislike information was updated
 * @property string $last_updated_by By which User POST Like Dislike  information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property SkillsUpPosts $postEnc
 */
class SkillsUpLikesDislikes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%skills_up_likes_dislikes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_like_dislike_enc_id', 'post_enc_id', 'created_by'], 'required'],
            [['feedback_status'], 'integer'],
            [['remarks'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['post_like_dislike_enc_id', 'post_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['post_like_dislike_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getPostEnc()
    {
        return $this->hasOne(SkillsUpPosts::className(), ['post_enc_id' => 'post_enc_id']);
    }
}
