<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_skills}}".
 *
 * @property int $id Primary Key
 * @property string $user_skill_enc_id User Skill Encrypted ID
 * @property string $skill_enc_id Foreign Key to Skills Table
 * @property string $created_on On which date User Skill information was added to database
 * @property string $created_by By which User Skill information was added
 * @property string $last_updated_on On which date User Skill information was updated
 * @property string $last_updated_by By which User Skill information was updated
 * @property int $is_deleted Is User Skill Deleted (0 As False, 1 As True)
 *
 * @property Skills $skillEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserSkills extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_skills}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_skill_enc_id', 'skill_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['user_skill_enc_id', 'skill_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['user_skill_enc_id'], 'unique'],
            [['skill_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skills::className(), 'targetAttribute' => ['skill_enc_id' => 'skill_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillEnc()
    {
        return $this->hasOne(Skills::className(), ['skill_enc_id' => 'skill_enc_id']);
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
