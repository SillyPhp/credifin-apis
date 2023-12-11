<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shared_loan_applications}}".
 *
 * @property int $id
 * @property string $shared_loan_app_enc_id shared loan app enc id
 * @property string $loan_app_enc_id loan app enc id
 * @property string $foreign_id foreign id
 * @property string $shared_by loan app shared by
 * @property string $shared_to loan app shared to
 * @property string $access access to shared user
 * @property string $status status for user
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $sharedBy
 * @property Users $sharedTo
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class SharedLoanApplications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shared_loan_applications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shared_loan_app_enc_id', 'shared_by', 'shared_to', 'access', 'created_by'], 'required'],
            [['access', 'status'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['shared_loan_app_enc_id', 'loan_app_enc_id', 'foreign_id', 'shared_by', 'shared_to', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['shared_loan_app_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['shared_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['shared_by' => 'user_enc_id']],
            [['shared_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['shared_to' => 'user_enc_id']],
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
}
