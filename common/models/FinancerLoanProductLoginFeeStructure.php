<?php
namespace common\models;


/**
 * This is the model class for table "{{%financer_loan_product_login_fee_structure}}".
 *
 * @property int $id Primary Id
 * @property string $financer_loan_product_no_dues_enc_id Fees enc id
 * @property string $financer_loan_product_enc_id Product enc id
 * @property string $name Name
 * @property double $amount Amount
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property FinancerLoanProducts $financerLoanProductEnc
 */
class FinancerLoanProductLoginFeeStructure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_loan_product_login_fee_structure}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['financer_loan_product_no_dues_enc_id', 'financer_loan_product_enc_id', 'name', 'amount', 'created_by'], 'required'],
            [['amount'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['financer_loan_product_no_dues_enc_id', 'financer_loan_product_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['financer_loan_product_no_dues_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['financer_loan_product_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProducts::className(), 'targetAttribute' => ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']],
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
    public function getFinancerLoanProductEnc()
    {
        return $this->hasOne(FinancerLoanProducts::className(), ['financer_loan_product_enc_id' => 'financer_loan_product_enc_id']);
    }
}
