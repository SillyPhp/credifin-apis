<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills_up_sources}}".
 *
 * @property int $id Primary Key
 * @property string $source_enc_id Post Encrypted ID
 * @property string $name
 * @property string $url
 * @property string $image
 * @property string $image_location
 * @property string $description
 * @property string $created_on On which date  information was added to database
 * @property string $created_by By which User  information was added
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User  information was updated
 * @property int $is_deleted
 *
 * @property SkillsUpPosts[] $skillsUpPosts
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class SkillsUpSources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%skills_up_sources}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_enc_id', 'name', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['source_enc_id', 'name', 'url', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['source_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillsUpPosts()
    {
        return $this->hasMany(SkillsUpPosts::className(), ['source_enc_id' => 'source_enc_id']);
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
