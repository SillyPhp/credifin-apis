<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_application_logs}}".
 *
 * @property int $id
 * @property string $app_log_enc_id
 * @property string $loan_app_enc_id Foreign Key to lJCWPnNNVy3d95ppLp7M_loan_applications Table
 * @property string $description
 * @property string $created_by Foreign Key to lJCWPnNNVy3d95ppLp7M_users Table
 * @property string $created_on
 * @property int $is_reconsidered 0 as false, 1 as true
 * @property int $status 0 as New Lead, 1 as Accepted, 2 as Pre Verification,4 as Under Process 5 as Senctioned 6 as Disbursed 10 as Rejected
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
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
            [['is_reconsidered', 'status'], 'integer'],
            [['app_log_enc_id', 'loan_app_enc_id', 'created_by'], 'string', 'max' => 100],
            [['app_log_enc_id'], 'unique'],
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
