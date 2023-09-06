<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_application_pd}}".
 *
 * @property int $id Primary id
 * @property string $loan_application_pd_enc_id Loan Applications Pd Enc Id
 * @property string $loan_app_enc_id Loan App Enc Id
 * @property int $status 0 as Initiated, 1 as Completed
 * @property string $assigned_to Assigned to user enc id
 * @property string $preferred_date Preferred Date in Json Format
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Users $assignedTo
 */
class LoanApplicationPd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_pd}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_application_pd_enc_id', 'loan_app_enc_id', 'status', 'created_by'], 'required'],
            [['status'], 'integer'],
            [['preferred_date'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['loan_application_pd_enc_id', 'loan_app_enc_id', 'assigned_to', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['loan_application_pd_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['assigned_to' => 'user_enc_id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'assigned_to']);
    }
}
