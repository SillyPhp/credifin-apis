<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_application_images}}".
 *
 * @property int $id
 * @property string $loan_application_image_enc_id
 * @property string $product_image_enc_id
 * @property string $loan_app_enc_id
 * @property string $name
 * @property string $image
 * @property string $image_location
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Users $createdBy
 * @property LoanApplications $loanAppEnc
 * @property FinancerLoanProductImages $productImageEnc
 */
class LoanApplicationImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_application_image_enc_id', 'product_image_enc_id', 'loan_app_enc_id', 'name', 'image', 'image_location', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_application_image_enc_id', 'product_image_enc_id', 'loan_app_enc_id', 'name', 'image', 'image_location', 'created_by'], 'string', 'max' => 100],
            [['loan_application_image_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['product_image_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProductImages::className(), 'targetAttribute' => ['product_image_enc_id' => 'product_image_enc_id']],
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
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImageEnc()
    {
        return $this->hasOne(FinancerLoanProductImages::className(), ['product_image_enc_id' => 'product_image_enc_id']);
    }
}
