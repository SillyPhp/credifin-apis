<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_products}}".
 *
 * @property int $id Primary Key
 * @property string $product_enc_id Product Encrypted ID
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $description Product Description
 * @property string $created_on On which date Product information was added to database
 * @property string $created_by By which User Product information was added
 * @property string $last_updated_on On which date Product information was updated
 * @property string $last_updated_by By which User Product information was updated
 * @property int $is_deleted Is Product Deleted (0 as False, 1 as True)
 *
 * @property OrganizationProductImages[] $organizationProductImages
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class OrganizationProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_products}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_enc_id', 'organization_enc_id', 'created_by'], 'required'],
            [['description'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['product_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['product_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationProductImages()
    {
        return $this->hasMany(OrganizationProductImages::className(), ['product_enc_id' => 'product_enc_id']);
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
