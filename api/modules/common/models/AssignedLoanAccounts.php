<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_loan_accounts}}".
 *
 * @property int $id
 * @property string $assigned_enc_id assigned loan account enc id
 * @property string $loan_account_enc_id loan account enc id
 * @property string $shared_by loan app shared by
 * @property string $shared_to loan app shared to
 * @property string $access access to shared user
 * @property int $user_type 1 id BDO, 2 is Collection Manager
 * @property string $status status for user
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Users $sharedBy
 * @property Users $sharedTo
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanAccounts $loanAccountEnc
 */
class AssignedLoanAccounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigned_loan_accounts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_enc_id', 'shared_by', 'shared_to', 'user_type', 'created_by'], 'required'],
            [['access', 'status'], 'string'],
            [['user_type', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['assigned_enc_id', 'loan_account_enc_id', 'shared_by', 'shared_to', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_enc_id'], 'unique'],
            [['shared_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['shared_by' => 'user_enc_id']],
            [['shared_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['shared_to' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_account_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanAccounts::className(), 'targetAttribute' => ['loan_account_enc_id' => 'loan_account_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'shared_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedTo()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'shared_to']);
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
    public function getLoanAccountEnc()
    {
        return $this->hasOne(LoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }
}
