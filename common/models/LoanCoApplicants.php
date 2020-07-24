<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_co_applicants}}".
 *
 * @property int $id
 * @property string $loan_co_app_enc_id
 * @property string $loan_app_enc_id organization_enc_id
 * @property string $name
 * @property string $relation
 * @property int $employment_type 0 as Non Working, 1 as Salaried, 2 as Self Employed
 * @property double $annual_income
 * @property string $pan_number co borrower pan card number
 * @property string $created_by user_enc_id
 * @property string $created_on created on
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 */
class LoanCoApplicants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_co_applicants}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_co_app_enc_id', 'loan_app_enc_id', 'name', 'relation', 'employment_type', 'annual_income', 'created_by', 'created_on'], 'required'],
            [['relation'], 'string'],
            [['employment_type'], 'integer'],
            [['annual_income'], 'number'],
            [['created_on'], 'safe'],
            [['loan_co_app_enc_id', 'loan_app_enc_id', 'name', 'created_by'], 'string', 'max' => 100],
            [['pan_number'], 'string', 'max' => 15],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
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
}
