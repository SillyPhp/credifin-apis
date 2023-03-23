<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property string $product_enc_id product id
 * @property string $model_enc_id model id
 * @property string $dealer_enc_id dealer id
 * @property string $assigned_category_enc_id product category
 * @property string $name product name
 * @property string $slug product slug
 * @property double $price product price
 * @property double $discounted_price discounted_price
 * @property string $description product description
 * @property string $city_enc_id city id
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property string $status status
 * @property int $is_deleted 0 false,1 true
 *
 * @property ProductEnquiry[] $productEnquiries
 * @property ProductImages[] $productImages
 * @property ProductOtherDetails[] $productOtherDetails
 * @property BrandModels $modelEnc
 * @property Users $dealerEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property AssignedCategories $assignedCategoryEnc
 * @property Cities $cityEnc
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_enc_id', 'model_enc_id', 'dealer_enc_id', 'assigned_category_enc_id', 'price', 'created_by'], 'required'],
            [['price', 'discounted_price'], 'number'],
            [['description', 'status'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['product_enc_id', 'model_enc_id', 'dealer_enc_id', 'assigned_category_enc_id', 'name', 'slug', 'city_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['product_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['model_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => BrandModels::className(), 'targetAttribute' => ['model_enc_id' => 'model_enc_id']],
            [['dealer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['dealer_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductEnquiries()
    {
        return $this->hasMany(ProductEnquiry::className(), ['product_id' => 'product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::className(), ['product_enc_id' => 'product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductOtherDetails()
    {
        return $this->hasMany(ProductOtherDetails::className(), ['product_enc_id' => 'product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelEnc()
    {
        return $this->hasOne(BrandModels::className(), ['model_enc_id' => 'model_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'dealer_enc_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategoryEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }
}
