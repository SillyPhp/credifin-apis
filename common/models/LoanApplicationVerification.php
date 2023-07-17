<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_application_verification}}".
 *
 * @property int $id Primary id
 * @property string $loan_application_verification_enc_id Loan Applications Verification Enc Id
 * @property string $loan_app_enc_id Loan App Enc Id
 * @property int $type 0 as TVR, 1 as PD
 * @property int $status 0 as Initiated, 1 as Completed
 * @property string $assigned_to Assigned to user enc id
 * @property array $preferred_date Preferred Date in Json Format
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class LoanApplicationVerification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_verification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_application_verification_enc_id', 'loan_app_enc_id', 'type', 'status', 'created_by'], 'required'],
            [['type', 'status'], 'integer'],
            [['preferred_date', 'created_on', 'updated_on'], 'safe'],
            [['loan_application_verification_enc_id', 'loan_app_enc_id', 'assigned_to', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['loan_application_verification_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
