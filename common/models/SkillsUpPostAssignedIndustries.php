<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_post_assigned_industries}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_industry_enc_id Post Encrypted ID
 * @property string $industry_enc_id
 * @property string $post_enc_id
 * @property string $created_on On which date  information was added to database
 * @property string $created_by By which User  information was added
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User  information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Industries $industryEnc
 * @property SkillsUpPosts $postEnc
 */
class SkillsUpPostAssignedIndustries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%skills_up_post_assigned_industries}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_industry_enc_id', 'industry_enc_id', 'post_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['assigned_industry_enc_id', 'industry_enc_id', 'post_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_industry_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['industry_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['industry_enc_id' => 'industry_enc_id']],
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
    public function getIndustryEnc()
    {
        return $this->hasOne(Industries::className(), ['industry_enc_id' => 'industry_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEnc()
    {
        return $this->hasOne(SkillsUpPosts::className(), ['post_enc_id' => 'post_enc_id']);
    }
}
