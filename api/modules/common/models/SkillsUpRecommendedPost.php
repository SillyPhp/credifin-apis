<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_recommended_post}}".
 *
 * @property int $id Primary Key
 * @property string $recommended_enc_id Post Encrypted ID
 * @property string $post_enc_id Post enc id
 * @property string $recommended_by By which User  recomended information mended  was added
 * @property string $recommended_on On which date recommended  information was added to database
 * @property string $remarks any comment by teacher
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User  information was updated
 * @property int $is_deleted
 *
 * @property Users $recommendedBy
 * @property Users $lastUpdatedBy
 * @property SkillsUpPosts $postEnc
 */
class SkillsUpRecommendedPost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%skills_up_recommended_post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recommended_enc_id', 'post_enc_id', 'recommended_by'], 'required'],
            [['recommended_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['recommended_enc_id', 'post_enc_id', 'recommended_by', 'last_updated_by'], 'string', 'max' => 100],
            [['remarks'], 'string', 'max' => 255],
            [['recommended_enc_id'], 'unique'],
            [['recommended_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['recommended_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['post_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillsUpPosts::className(), 'targetAttribute' => ['post_enc_id' => 'post_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'recommended_by']);
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
