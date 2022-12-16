<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_other_details}}".
 *
 * @property int $id primary key
 * @property string $product_other_detail_enc_id product other detail id
 * @property string $other_detail product other detail
 * @property int $ownership_type 1.I bought it new 2.I'm the Second Owner 3.I'm the Third Owner 4.I'm the Fourth Owner
 * @property string $variant variant
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Products[] $products
 */
class ProductOtherDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_other_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_other_detail_enc_id', 'other_detail', 'created_by'], 'required'],
            [['other_detail'], 'string'],
            [['ownership_type', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['product_other_detail_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['variant'], 'string', 'max' => 50],
            [['product_other_detail_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
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
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['product_other_detail_enc_id' => 'product_other_detail_enc_id']);
    }
}
