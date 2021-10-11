<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_emi_structure}}".
 *
 * @property int $id
 * @property string $loan_structure_enc_id loan structure enc Id
 * @property string $sanction_report_enc_id customer application enc id
 * @property string $due_date
 * @property double $amount monthly emi
 * @property double $stamp_paper_cost stamp paper cost if ay attach
 * @property double $insurance innsurance if any
 * @property int $is_advance 0 as not advance, 1 as advance
 * @property string $created_on created on
 * @property string $created_by user who created emi structure
 * @property string $last_updated_on last updated on
 * @property string $last_updated_by last updated by
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property LoanSanctionReports $sanctionReportEnc
 * @property LoanRepayments[] $loanRepayments
 */
class LoanEmiStructure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_emi_structure}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_structure_enc_id', 'sanction_report_enc_id', 'due_date', 'amount', 'created_by'], 'required'],
            [['due_date', 'created_on', 'last_updated_on'], 'safe'],
            [['amount', 'stamp_paper_cost', 'insurance'], 'number'],
            [['is_advance'], 'integer'],
            [['loan_structure_enc_id', 'sanction_report_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['loan_structure_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['sanction_report_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanSanctionReports::className(), 'targetAttribute' => ['sanction_report_enc_id' => 'report_enc_id']],
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSanctionReportEnc()
    {
        return $this->hasOne(LoanSanctionReports::className(), ['report_enc_id' => 'sanction_report_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepayments()
    {
        return $this->hasMany(LoanRepayments::className(), ['loan_structure_enc_id' => 'loan_structure_enc_id']);
    }
}
