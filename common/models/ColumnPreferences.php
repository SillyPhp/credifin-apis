<?php

namespace common\models;

/**
 * This is the model class for table "lJCWPnNNVy3d95ppLp7M_column_preferences".
 *
 * @property int $id
 * @property string $column_preference_enc_id Column Preference Enc Id
 * @property string $user_enc_id User Enc Id
 * @property string $loan_type_enc_id
 * @property string $disabled_fields Array of disabled field
 * @property string $created_by Created By
 * @property string $created_on Created On
 * @property string $updated_by Updated By
 * @property string $updated_on Updated On
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property AssignedFinancerLoanType $loanTypeEnc
 */
class ColumnPreferences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lJCWPnNNVy3d95ppLp7M_column_preferences';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['column_preference_enc_id', 'user_enc_id', 'loan_type_enc_id', 'disabled_fields', 'created_by'], 'required'],
            [['disabled_fields'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['column_preference_enc_id', 'user_enc_id', 'loan_type_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['column_preference_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedFinancerLoanType::className(), 'targetAttribute' => ['loan_type_enc_id' => 'loan_type_enc_id']],
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanTypeEnc()
    {
        return $this->hasOne(AssignedFinancerLoanType::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }
}
