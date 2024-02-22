<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_embed_posts}}".
 *
 * @property int $id Primary Key
 * @property string $embed_enc_id Post Encrypted ID
 * @property string $body
 * @property string $description
 * @property string $created_on On which date  information was added to database
 * @property string $created_by By which User  information was added
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User  information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property SkillsUpPostAssignedEmbeds[] $skillsUpPostAssignedEmbeds
 */
class SkillsUpEmbedPosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%skills_up_embed_posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['embed_enc_id', 'body', 'created_by'], 'required'],
            [['body', 'description'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['embed_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['embed_enc_id'], 'unique'],
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
    public function getSkillsUpPostAssignedEmbeds()
    {
        return $this->hasMany(SkillsUpPostAssignedEmbeds::className(), ['embed_enc_id' => 'embed_enc_id']);
    }
}
