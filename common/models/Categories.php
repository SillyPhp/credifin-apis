<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property int $id Primary Key
 * @property string $category_enc_id Category Encrypted ID
 * @property string $name Category Name
 * @property string $slug Category Slug
 * @property string $icon Category Icon
 * @property string $parent_enc_id Foreign Key to Categories Table
 * @property string $created_on On which date Category information was added to database
 * @property string $created_by By which User Category information was added
 * @property string $last_updated_on On which date Category information was updated
 * @property string $last_updated_by By which User Category information was updated
 *
 * @property AssignedCategories[] $assignedCategories
 * @property AssignedCategories[] $assignedCategories0
 * @property BlogCategories[] $blogCategories
 * @property Categories $parentEnc
 * @property Categories[] $categories
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property EmployerApplications[] $employerApplications
 * @property PostCategories[] $postCategories
 */
class Categories extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_enc_id', 'name', 'slug', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['category_enc_id', 'name', 'slug', 'parent_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 50],
            [['category_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['name'], 'unique'],
            [['parent_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['parent_enc_id' => 'category_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategories() {
        return $this->hasMany(AssignedCategories::className(), ['category_enc_id' => 'category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategories0() {
        return $this->hasMany(AssignedCategories::className(), ['parent_enc_id' => 'category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogCategories() {
        return $this->hasMany(BlogCategories::className(), ['category_enc_id' => 'category_enc_id']);
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
    public function getCategories() {
        return $this->hasMany(Categories::className(), ['parent_enc_id' => 'category_enc_id']);
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
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['preferred_industry' => 'category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories() {
        return $this->hasMany(PostCategories::className(), ['category_enc_id' => 'category_enc_id']);
    }

}
