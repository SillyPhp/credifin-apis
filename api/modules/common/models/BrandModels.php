<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%brand_models}}".
 *
 * @property int $id
 * @property string $model_enc_id model id
 * @property string $brand_enc_id brand id
 * @property string $name model name
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Brands $brandEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Products[] $products
 */
class BrandModels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%brand_models}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_enc_id', 'brand_enc_id', 'name', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['model_enc_id', 'brand_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 40],
            [['model_enc_id'], 'unique'],
            [['brand_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brands::className(), 'targetAttribute' => ['brand_enc_id' => 'brand_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandEnc()
    {
        return $this->hasOne(Brands::className(), ['brand_enc_id' => 'brand_enc_id']);
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
        return $this->hasMany(Products::className(), ['model_enc_id' => 'model_enc_id']);
    }
}
