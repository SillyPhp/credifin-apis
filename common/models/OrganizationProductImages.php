<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_product_images}}".
 *
 * @property int $id Primary Key
 * @property string $image_enc_id Image Encrypted ID
 * @property string $product_enc_id Foreign Key to Organization Products Table
 * @property string $image Image
 * @property string $image_location Image Location
 * @property string $title Image Title
 * @property string $alt Alternative Text of Image
 * @property string $created_on On which date Image information was added to database
 * @property string $created_by By which User Image information was added
 * @property string $last_updated_on On which date Image information was updated
 * @property string $last_updated_by By which User Image information was updated
 * @property int $is_deleted Is Image Deleted (0 as False, 1 as True)
 *
 * @property OrganizationProducts $productEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class OrganizationProductImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_product_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_enc_id', 'product_enc_id', 'image', 'image_location', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['image_enc_id', 'product_enc_id', 'image', 'image_location', 'title', 'alt', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['image_enc_id'], 'unique'],
            [['product_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationProducts::className(), 'targetAttribute' => ['product_enc_id' => 'product_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductEnc()
    {
        return $this->hasOne(OrganizationProducts::className(), ['product_enc_id' => 'product_enc_id']);
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
