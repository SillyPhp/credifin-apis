<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_status}}".
 *
 * @property int $id
 * @property string $loan_status_enc_id loan status enc id
 * @property string $loan_status loan status name
 * @property int $value loan status value
 * @property int $sequence loan status sequence
 * @property string $status_color status color code
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property AssignedLoanProvider[] $assignedLoanProviders
 * @property FinancerLoanStatus[] $financerLoanStatuses
 * @property Users $createdBy
 */
class LoanStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_status_enc_id', 'loan_status', 'value', 'sequence', 'created_by'], 'required'],
            [['value', 'sequence', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['loan_status_enc_id', 'loan_status', 'created_by'], 'string', 'max' => 100],
            [['status_color'], 'string', 'max' => 7],
            [['updated_by'], 'string', 'max' => 200],
            [['loan_status_enc_id'], 'unique'],
            [['value'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedLoanProviders()
    {
        return $this->hasMany(AssignedLoanProvider::className(), ['status' => 'value']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerLoanStatuses()
    {
        return $this->hasMany(FinancerLoanStatus::className(), ['loan_status_enc_id' => 'loan_status_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
