<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_enquiry}}".
 *
 * @property int $id
 * @property string $enquiry_enc_id enquiry id
 * @property string $product_id product id
 * @property string $first_name first name
 * @property string $last_name last name
 * @property string $email email
 * @property string $mobile_number mobile number
 * @property string $message message
 * @property string $status status
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Products $product
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class ProductEnquiry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_enquiry}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enquiry_enc_id', 'product_id', 'first_name', 'last_name', 'email', 'mobile_number', 'message'], 'required'],
            [['message', 'status'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['enquiry_enc_id', 'product_id', 'first_name', 'last_name', 'email', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['mobile_number'], 'string', 'max' => 15],
            [['enquiry_enc_id'], 'unique'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'product_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['product_enc_id' => 'product_id']);
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
}
