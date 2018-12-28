<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_categories}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_category_enc_id Assigned Category Encrypted ID
 * @property string $category_enc_id Foreign Key to Categories Table
 * @property string $parent_enc_id Foreign Key to Categories Table
 * @property string $assigned_to Assigned To
 * @property string $created_on On which date Category information was added to database
 * @property string $created_by By which User Category information was added
 * @property string $last_updated_on On which date Category information was updated
 * @property string $last_updated_by By which User Category information was updated
 * @property string $status Assigned Category Status (Approved, Pending)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Categories $categoryEnc
 * @property Categories $parentEnc
 * @property EducationalRequirements[] $educationalRequirements
 * @property EmployerApplications[] $employerApplications
 * @property JobDescription[] $jobDescriptions
 * @property Skills[] $skills
 */
class AssignedCategories extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%assigned_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['assigned_category_enc_id', 'category_enc_id', 'assigned_to', 'created_on', 'created_by'], 'required'],
            [['assigned_to', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['assigned_category_enc_id', 'category_enc_id', 'parent_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_category_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
            [['parent_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['parent_enc_id' => 'category_enc_id']],
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryEnc() {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentEnc() {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'parent_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalRequirements() {
        return $this->hasMany(EducationalRequirements::className(), ['category_enc_id' => 'assigned_category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['title' => 'assigned_category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobDescriptions() {
        return $this->hasMany(JobDescription::className(), ['category_enc_id' => 'assigned_category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkills() {
        return $this->hasMany(Skills::className(), ['category_enc_id' => 'assigned_category_enc_id']);
    }

}
