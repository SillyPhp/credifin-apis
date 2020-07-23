<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%education_loan_payments}}".
 *
 * @property int $id
 * @property string $education_loan_payment_enc_id loan payment encrypted id
 * @property string $college_enc_id student college id
 * @property string $loan_app_enc_id loan application enc id
 * @property string $payment_token
 * @property int $payment_amount
 * @property double $payment_gst
 * @property string $payment_id payment token/id
 * @property string $payment_status payment status
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property Organizations $collegeEnc
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class EducationLoanPayments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%education_loan_payments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['education_loan_payment_enc_id', 'college_enc_id', 'loan_app_enc_id', 'payment_token', 'payment_amount', 'payment_gst', 'created_by'], 'required'],
            [['payment_gst','payment_amount'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['education_loan_payment_enc_id', 'college_enc_id', 'loan_app_enc_id', 'payment_token', 'payment_id', 'payment_status', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['education_loan_payment_enc_id'], 'unique'],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
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
