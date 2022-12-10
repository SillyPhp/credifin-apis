<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_images}}".
 *
 * @property int $id
 * @property string $image_enc_id image id
 * @property string $product_enc_id product id
 * @property string $image image
 * @property string $image_location image location
 * @property string $alt image name
 * @property string $type image type
 * @property string $created_by created by
 * @property string $created_on created on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Products $productEnc
 * @property Users $createdBy
 */
class ProductImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_enc_id', 'product_enc_id', 'image', 'image_location', 'created_by'], 'required'],
            [['type'], 'string'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['image_enc_id', 'product_enc_id', 'image', 'image_location', 'created_by'], 'string', 'max' => 100],
            [['alt'], 'string', 'max' => 50],
            [['image_enc_id'], 'unique'],
            [['product_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_enc_id' => 'product_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductEnc()
    {
        return $this->hasOne(Products::className(), ['product_enc_id' => 'product_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
