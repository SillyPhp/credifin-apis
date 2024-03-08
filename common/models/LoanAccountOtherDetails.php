<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_account_other_details}}".
 *
 * @property int $id
 * @property string $detail_enc_id
 * @property string $loan_account_enc_id
 * @property string $type
 * @property string $value
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property LoanAccounts $loanAccountEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class LoanAccountOtherDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_account_other_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail_enc_id', 'loan_account_enc_id', 'type', 'value', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['detail_enc_id', 'loan_account_enc_id', 'type', 'value', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['loan_account_enc_id'], 'unique'],
            [['loan_account_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanAccounts::className(), 'targetAttribute' => ['loan_account_enc_id' => 'loan_account_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detail_enc_id' => 'Detail Enc ID',
            'loan_account_enc_id' => 'Loan Account Enc ID',
            'type' => 'Type',
            'value' => 'Value',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAccountEnc()
    {
        return $this->hasOne(LoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
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
