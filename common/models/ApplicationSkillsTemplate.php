<?php

namespace common\models;

/**
 * This is the model class for table "{{%application_skills_template}}".
 *
 * @property int $id Primary Key
 * @property string $application_skill_enc_id Application Skill Encrypted ID
 * @property string $skill_enc_id Foreign Key to Skills Table
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property string $created_on On which date Application Skill information was added to database
 * @property string $created_by By which User Application Skill information was added
 * @property string $last_updated_on On which date Application Skill information was updated
 * @property string $last_updated_by By which User Application Skill information was updated
 * @property int $is_deleted Is Application Skill Deleted (0 As False, 1 As True)
 *
 * @property ApplicationTemplates $applicationEnc
 * @property Skills $skillEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationSkillsTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application_skills_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_skill_enc_id', 'skill_enc_id', 'application_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['application_skill_enc_id', 'skill_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_skill_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTemplates::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['skill_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skills::className(), 'targetAttribute' => ['skill_enc_id' => 'skill_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(ApplicationTemplates::className(), ['application_enc_id' => 'application_enc_id']);
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
