<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_preferred_skills}}".
 *
 * @property int $id Primary Key
 * @property string $preferred_skill_enc_id Preferred Skill Encrypted ID
 * @property string $skill_enc_id Foreign Key to Skills Table
 * @property string $preference_enc_id Foreign Key to User Preferences Table
 * @property string $created_on On which date User Preferred Skill information was added to database
 * @property string $created_by By which User Preferred Skill information was added
 * @property string $last_updated_on On which date User Preferred Skill information was updated
 * @property string $last_updated_by By which User Preferred Skill information was updated
 * @property int $is_deleted Is User Preferred Skill Deleted (0 As False, 1 As True)
 *
 * @property Skills $skillEnc
 * @property UserPreferences $preferenceEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserPreferredSkills extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_preferred_skills}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['preferred_skill_enc_id', 'skill_enc_id', 'preference_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['preferred_skill_enc_id', 'skill_enc_id', 'preference_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['preferred_skill_enc_id'], 'unique'],
            [['skill_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skills::className(), 'targetAttribute' => ['skill_enc_id' => 'skill_enc_id']],
            [['preference_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPreferences::className(), 'targetAttribute' => ['preference_enc_id' => 'preference_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillEnc() {
        return $this->hasOne(Skills::className(), ['skill_enc_id' => 'skill_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferenceEnc() {
        return $this->hasOne(UserPreferences::className(), ['preference_enc_id' => 'preference_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

}
