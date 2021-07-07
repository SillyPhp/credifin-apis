<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_sanction_reports}}".
 *
 * @property int $id
 * @property string $report_enc_id
 * @property string $loan_app_enc_id
 * @property string $loan_provider_id
 * @property string $file_number
 * @property double $loan_amount
 * @property double $processing_fee
 * @property double $rate_of_interest
 * @property int $total_installments
 * @property int $discounting
 * @property string $approved_by
 * @property int $fldg
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property CollectedDocuments[] $collectedDocuments
 * @property LoanApplicationLogs[] $loanApplicationLogs
 * @property LoanEmiStructure[] $loanEmiStructures
 * @property LoanApplications $loanAppEnc
 * @property Organizations $loanProvider
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class LoanSanctionReports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_sanction_reports}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_enc_id', 'loan_app_enc_id', 'loan_provider_id', 'file_number', 'loan_amount', 'processing_fee', 'rate_of_interest', 'total_installments'], 'required'],
            [['loan_amount', 'processing_fee', 'rate_of_interest'], 'number'],
            [['total_installments', 'discounting', 'fldg'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['report_enc_id', 'loan_app_enc_id', 'loan_provider_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['file_number', 'approved_by'], 'string', 'max' => 50],
            [['report_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['loan_provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['loan_provider_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectedDocuments()
    {
        return $this->hasMany(CollectedDocuments::className(), ['sanctioned_report_id' => 'report_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationLogs()
    {
        return $this->hasMany(LoanApplicationLogs::className(), ['sanctioned_report_id' => 'report_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanEmiStructures()
    {
        return $this->hasMany(LoanEmiStructure::className(), ['sanction_report_enc_id' => 'report_enc_id']);
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
    public function getLoanProvider()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'loan_provider_id']);
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
