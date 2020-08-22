<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_application_logs}}".
 *
 * @property int $id
 * @property string $app_log_enc_id
 * @property string $loan_app_enc_id Foreign Key to lJCWPnNNVy3d95ppLp7M_loan_applications Table
 * @property string $organization_enc_id
 * @property string $sanctioned_report_id
 * @property string $scheme_enc_id
 * @property string $description
 * @property string $created_by Foreign Key to lJCWPnNNVy3d95ppLp7M_users Table
 * @property string $created_on
 * @property int $is_reconsidered 0 as false, 1 as true
 * @property int $loan_status 0 as New Lead, 1 as Accepted, 2 as Pre Verification, 3 as Under Process, 4 as Senctioned, 5 as Disbursed 10 as Rejected
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Organizations $organizationEnc
 * @property OrganizationLoanSchemes $schemeEnc
 * @property LoanSanctionReports $sanctionedReport
 */
class LoanApplicationLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_application_logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_log_enc_id', 'loan_app_enc_id', 'created_by'], 'required'],
            [['description'], 'string'],
            [['created_on'], 'safe'],
            [['is_reconsidered', 'loan_status'], 'integer'],
            [['app_log_enc_id', 'loan_app_enc_id', 'organization_enc_id', 'sanctioned_report_id', 'scheme_enc_id', 'created_by'], 'string', 'max' => 100],
            [['app_log_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['scheme_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLoanSchemes::className(), 'targetAttribute' => ['scheme_enc_id' => 'scheme_enc_id']],
            [['sanctioned_report_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanSanctionReports::className(), 'targetAttribute' => ['sanctioned_report_id' => 'report_enc_id']],
        ];
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchemeEnc()
    {
        return $this->hasOne(OrganizationLoanSchemes::className(), ['scheme_enc_id' => 'scheme_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSanctionedReport()
    {
        return $this->hasOne(LoanSanctionReports::className(), ['report_enc_id' => 'sanctioned_report_id']);
    }
}
