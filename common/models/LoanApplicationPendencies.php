<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_application_pendencies}}".
 *
 * @property int $id
 * @property string $loan_pendency_enc_id
 * @property string $pendencies_enc_id
 * @property string $loan_co_app_enc_id
 * @property string $loan_app_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_on
 * @property string $updated_by
 * @property int $is_deleted
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property FinancerLoanProductPendencies $pendenciesEnc
 * @property LoanCoApplicants $loanCoAppEnc
 * @property LoanApplications $loanAppEnc
 * @property LoanApplicationPendencyDocuments[] $loanApplicationPendencyDocuments
 */
class LoanApplicationPendencies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_pendencies}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_pendency_enc_id', 'pendencies_enc_id', 'loan_app_enc_id', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_pendency_enc_id', 'pendencies_enc_id', 'loan_co_app_enc_id', 'loan_app_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['loan_pendency_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['pendencies_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerLoanProductPendencies::className(), 'targetAttribute' => ['pendencies_enc_id' => 'pendencies_enc_id']],
            [['loan_co_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanCoApplicants::className(), 'targetAttribute' => ['loan_co_app_enc_id' => 'loan_co_app_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPendenciesEnc()
    {
        return $this->hasOne(FinancerLoanProductPendencies::className(), ['pendencies_enc_id' => 'pendencies_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCoAppEnc()
    {
        return $this->hasOne(LoanCoApplicants::className(), ['loan_co_app_enc_id' => 'loan_co_app_enc_id']);
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
    public function getLoanApplicationPendencyDocuments()
    {
        return $this->hasMany(LoanApplicationPendencyDocuments::className(), ['loan_pendency_enc_id' => 'loan_pendency_enc_id']);
    }
}
