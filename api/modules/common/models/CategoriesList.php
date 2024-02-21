<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%categories_list}}".
 *
 * @property int $id Primary Key
 * @property string $category_enc_id Category Encrypted ID
 * @property string $name Category Name
 * @property string $slug Category Slug
 * @property string $parent_enc_id Foreign Key to Categories Table
 * @property string $created_on On which date Category information was added to database
 * @property string $created_by By which User Category information was added
 * @property string $last_updated_on On which date Category information was updated
 * @property string $last_updated_by By which User Category information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class CategoriesList extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%categories_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_enc_id', 'name', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['category_enc_id', 'name', 'slug', 'parent_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['category_enc_id'], 'unique'],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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

}
