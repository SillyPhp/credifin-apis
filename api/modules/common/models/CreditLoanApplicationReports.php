<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%credit_loan_application_reports}}".
 *
 * @property int $id table id
 * @property string $report_enc_id table primary key and encrypted key
 * @property string $response_enc_id response_enc_id
 * @property string $loan_app_enc_id loan_app_enc_id
 * @property string $loan_co_app_enc_id loan_co_app_enc_id
 * @property string $created_on current datetime of the entry
 * @property string $created_by user id of the user who created the entry
 * @property int $is_deleted 1 as deleted and 0 as not deleted
 *
 * @property Users $createdBy
 * @property CreditResponseData $responseEnc
 * @property LoanApplications $loanAppEnc
 * @property LoanCoApplicants $loanCoAppEnc
 */
class CreditLoanApplicationReports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%credit_loan_application_reports}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_enc_id', 'response_enc_id', 'loan_app_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['report_enc_id', 'response_enc_id', 'loan_app_enc_id', 'loan_co_app_enc_id', 'created_by'], 'string', 'max' => 100],
            [['report_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['response_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CreditResponseData::className(), 'targetAttribute' => ['response_enc_id' => 'response_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['loan_co_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanCoApplicants::className(), 'targetAttribute' => ['loan_co_app_enc_id' => 'loan_co_app_enc_id']],
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
    public function getResponseEnc()
    {
        return $this->hasOne(CreditResponseData::className(), ['response_enc_id' => 'response_enc_id']);
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
    public function getLoanCoAppEnc()
    {
        return $this->hasOne(LoanCoApplicants::className(), ['loan_co_app_enc_id' => 'loan_co_app_enc_id']);
    }
}
