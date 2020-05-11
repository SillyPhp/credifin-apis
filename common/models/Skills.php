<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%skills}}".
 *
 * @property int $id Primary Key
 * @property string $skill_enc_id Skill Encrypted ID
 * @property string $skill Skill
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Skill information was added to database
 * @property string $created_by By which User Skill information was added
 * @property string $last_updated_on On which date Skill information was updated
 * @property string $last_updated_by By which User Skill information was updated
 * @property string $status Skill Status (Publish, Pending)
 * @property int $is_deleted Is Skill Deleted (0 As False, 1 As True)
 *
 * @property ApplicationSkills[] $applicationSkills
 * @property ApplicationSkillsTemplate[] $applicationSkillsTemplates
 * @property AssignedSkills[] $assignedSkills
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 * @property UserPreferredSkills[] $userPreferredSkills
 * @property UserSkills[] $userSkills
 */
class Skills extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%skills}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['skill_enc_id', 'skill', 'created_on'], 'required'],
            [['skill', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['skill_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['skill_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkills()
    {
        return $this->hasMany(ApplicationSkills::className(), ['skill_enc_id' => 'skill_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationSkillsTemplates()
    {
        return $this->hasMany(ApplicationSkillsTemplate::className(), ['skill_enc_id' => 'skill_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedSkills()
    {
        return $this->hasMany(AssignedSkills::className(), ['skill_enc_id' => 'skill_enc_id']);
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredSkills()
    {
        return $this->hasMany(UserPreferredSkills::className(), ['skill_enc_id' => 'skill_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSkills()
    {
        return $this->hasMany(UserSkills::className(), ['skill_enc_id' => 'skill_enc_id']);
    }
}
