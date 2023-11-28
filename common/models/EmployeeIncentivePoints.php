<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%employee_incentive_points}}".
 *
 * @property int $id
 * @property string $points_enc_id
 * @property string $loan_app_enc_id
 * @property string $user_enc_id
 * @property string $points
 * @property double $points_value
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_on
 * @property string $updated_by
 * @property int $is_deleted
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class EmployeeIncentivePoints extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employee_incentive_points}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['points_enc_id', 'loan_app_enc_id', 'user_enc_id', 'points', 'points_value', 'created_on', 'created_by'], 'required'],
            [['points_value'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['points_enc_id', 'loan_app_enc_id', 'user_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['points'], 'string', 'max' => 60],
            [['points_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
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
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
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
