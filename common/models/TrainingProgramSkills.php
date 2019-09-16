<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%training_program_skills}}".
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
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Skills $skillEnc
 * @property TrainingProgramApplication $applicationEnc
 */
class TrainingProgramSkills extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%training_program_skills}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_skill_enc_id', 'skill_enc_id', 'application_enc_id', 'created_on'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['application_skill_enc_id', 'skill_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_skill_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['skill_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skills::className(), 'targetAttribute' => ['skill_enc_id' => 'skill_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrainingProgramApplication::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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
    public function getSkillEnc()
    {
        return $this->hasOne(Skills::className(), ['skill_enc_id' => 'skill_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(TrainingProgramApplication::className(), ['application_enc_id' => 'application_enc_id']);
    }
}
