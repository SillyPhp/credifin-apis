<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_assigned_categories}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_category_enc_id Assigned Category Encrypted ID
 * @property string $category_enc_id Foreign Key to Categories Table
 * @property string $parent_enc_id Foreign Key to Categories Table
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $assigned_to Assigned To
 * @property string $created_on On which date Category information was added to database
 * @property string $created_by By which User Category information was added
 * @property string $last_updated_on On which date Category information was updated
 * @property string $last_updated_by By which User Category information was updated
 * @property int $is_deleted Is Deleted (0 as False, 1 as True)
 *
 * @property Categories $categoryEnc
 * @property Categories $parentEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 */
class OrganizationAssignedCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_assigned_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_category_enc_id', 'category_enc_id', 'organization_enc_id', 'assigned_to', 'created_by'], 'required'],
            [['assigned_to'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_category_enc_id', 'category_enc_id', 'parent_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_category_enc_id'], 'unique'],
            [['category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_enc_id' => 'category_enc_id']],
            [['parent_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['parent_enc_id' => 'category_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryEnc()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentEnc()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'parent_enc_id']);
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
}
