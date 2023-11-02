<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%emi_payment_issues}}".
 *
 * @property int $id Primary Id
 * @property string $emi_payment_issues_enc_id Assigned Dealer Brands Enc Id
 * @property string $loan_account_enc_id
 * @property string $loan_app_enc_id
 * @property int $reasons     1 is legal, 2 is Accidental, 3 is health
 * @property string $remarks
 * @property string $image
 * @property string $image_location
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanApplications $loanAppEnc
 * @property LoanAccounts $loanAccountEnc
 */
class EmiPaymentIssues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%emi_payment_issues}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emi_payment_issues_enc_id', 'loan_account_enc_id', 'reasons', 'remarks', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['reasons', 'is_deleted'], 'integer'],
            [['remarks'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['emi_payment_issues_enc_id', 'loan_account_enc_id', 'loan_app_enc_id', 'image', 'image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['emi_payment_issues_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['loan_account_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanAccounts::className(), 'targetAttribute' => ['loan_account_enc_id' => 'loan_account_enc_id']],
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
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountEnc()
    {
        return $this->hasOne(LoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }
}
