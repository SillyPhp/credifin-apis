<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_purpose}}".
 *
 * @property int $id
 * @property string $loan_purpose_enc_id
 * @property string $fee_component_enc_id
 * @property string $loan_app_enc_id
 * @property string $created_by
 * @property string $created_on
 *
 * @property OrganizationFeeComponents $feeComponentEnc
 * @property Users $createdBy
 * @property LoanApplications $loanAppEnc
 */
class LoanPurpose extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_purpose}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_purpose_enc_id', 'fee_component_enc_id', 'loan_app_enc_id'], 'required'],
            [['created_on'], 'safe'],
            [['loan_purpose_enc_id', 'fee_component_enc_id', 'loan_app_enc_id', 'created_by'], 'string', 'max' => 100],
            [['loan_purpose_enc_id'], 'unique'],
            [['fee_component_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationFeeComponents::className(), 'targetAttribute' => ['fee_component_enc_id' => 'fee_component_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dsbedutech', 'ID'),
            'loan_purpose_enc_id' => Yii::t('dsbedutech', 'Loan Purpose Enc ID'),
            'fee_component_enc_id' => Yii::t('dsbedutech', 'Fee Component Enc ID'),
            'loan_app_enc_id' => Yii::t('dsbedutech', 'Loan App Enc ID'),
            'created_by' => Yii::t('dsbedutech', 'Created By'),
            'created_on' => Yii::t('dsbedutech', 'Created On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeComponentEnc()
    {
        return $this->hasOne(OrganizationFeeComponents::className(), ['fee_component_enc_id' => 'fee_component_enc_id']);
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
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }
}
