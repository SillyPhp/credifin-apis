<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%financer_loan_product_pendencies}}".
 *
 * @property int $id Primary Id
 * @property string $pendencies_enc_id Pendencies Enc Id
 * @property string $financer_loan_product_enc_id Product Enc Id
 * @property string $name Pendency
 * @property int $type Pendency Type
 * @property string $created_on Created On
 * @property string $created_by Created by
 * @property string $updated_on Updated On
 * @property string $updated_by Updated BY
 * @property int $is_deleted 0 for false, 1 for true
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property FinancerLoanProducts $financerLoanProductEnc
 * @property LoanApplicationPendencies[] $loanApplicationPendencies
 */
class FinancerLoanProductPendencies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_loan_product_pendencies}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pendencies_enc_id', 'financer_loan_product_enc_id', 'name', 'type', 'created_by'], 'required'],
            [['type', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['pendencies_enc_id', 'financer_loan_product_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['pendencies_enc_id'], 'unique'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationPendencies()
    {
        return $this->hasMany(LoanApplicationPendencies::className(), ['pendencies_enc_id' => 'pendencies_enc_id']);
    }
}
