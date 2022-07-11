<?php
namespace common\models;
/**
 * This is the model class for table "{{%assigned_loan_provider}}".
 *
 * @property int $id
 * @property string $assigned_loan_provider_enc_id assigned_loan_schemes_enc_id
 * @property string $loan_application_enc_id linked to loan application
 * @property string $provider_enc_id linked to organization_enc_id
 * @property string $scheme_enc_id linked to organization schemes
 * @property int $status 0 as New Lead, 1 as Accepted, 2 as Pre Verification, 3 as Under Process, 4 as Senctioned, 5 as Disbursed 10 as Rejected
 * @property string $created_by linked to user table
 * @property string $created_on created on
 * @property string $updated_on updated on
 * @property string $updated_by linked to user table
 * @property int $is_deleted 0 false,1 true
 *
 * @property Organizations $providerEnc
 * @property OrganizationLoanSchemes $schemeEnc
 * @property LoanApplications $loanApplicationEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class AssignedLoanProvider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_loan_provider}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_loan_provider_enc_id', 'loan_application_enc_id', 'provider_enc_id'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['assigned_loan_provider_enc_id', 'loan_application_enc_id', 'provider_enc_id', 'scheme_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['provider_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['provider_enc_id' => 'organization_enc_id']],
            [['scheme_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLoanSchemes::className(), 'targetAttribute' => ['scheme_enc_id' => 'scheme_enc_id']],
            [['loan_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_application_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviderEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'provider_enc_id']);
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
    public function getLoanApplicationEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_application_enc_id']);
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
