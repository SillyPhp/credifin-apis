<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigning_loan_accounts}}".
 *
 * @property int $id
 * @property string $assign_loan_enc_id assign loan enc id
 * @property string $foreign_id foreign id
 * @property string $shared_by loan app shared by
 * @property string $shared_to loan app shared to
 * @property string $access access to shared user
 * @property int $user_type
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
 */
class AssigningLoanAccounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assigning_loan_accounts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assign_loan_enc_id', 'shared_by', 'shared_to', 'user_type', 'created_by'], 'required'],
            [['access', 'status'], 'string'],
            [['user_type', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['assign_loan_enc_id', 'foreign_id', 'shared_by', 'shared_to', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assign_loan_enc_id'], 'unique'],
            [['shared_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['shared_by' => 'user_enc_id']],
            [['shared_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['shared_to' => 'user_enc_id']],
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
            'assign_loan_enc_id' => 'Assign Loan Enc ID',
            'foreign_id' => 'Foreign ID',
            'shared_by' => 'Shared By',
            'shared_to' => 'Shared To',
            'access' => 'Access',
            'user_type' => 'User Type',
            'status' => 'Status',
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
