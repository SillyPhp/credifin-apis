<?php

namespace common\models;

/**
 * This is the model class for table "{{%assigned_skills}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_skill_enc_id Assigned Skill Encrypted ID
 * @property string $skill_enc_id Foreign Key to Skills Table
 * @property string $category_enc_id Foreign Key to Categories List Table
 * @property string $created_on On which date Assigned Skill information was added to database
 * @property string $created_by By which User Assigned Skill information was added
 * @property string $last_updated_on On which date Assigned Skill information was updated
 * @property string $last_updated_by By which User Assigned Skill information was updated
 * @property string $status Assigned Skill Status (Approved, Pending)
 * @property int $is_deleted Is Assigned Skill Deleted (0 As False, 1 As True)
 *
 * @property Skills $skillEnc
 * @property Categories $categoryEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class AssignedSkills extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%assigned_skills}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['assigned_skill_enc_id', 'skill_enc_id', 'category_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['is_deleted'], 'integer'],
            [['assigned_skill_enc_id', 'skill_enc_id', 'category_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_skill_enc_id'], 'unique'],
            [['skill_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skills::className(), 'targetAttribute' => ['skill_enc_id' => 'skill_enc_id']],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
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
    public function getCategoryEnc() {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'category_enc_id']);
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
