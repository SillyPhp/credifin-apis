<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_fee_amount}}".
 *
 * @property int $id Primary Key
 * @property string $application_fee_amount_enc_id Application Fee Amount Encrypted ID
 * @property string $organization_enc_id Organization Enc Id
 * @property string $loan_type_enc_id Loan Type Enc id
 * @property int $amount Amount
 * @property double $gst GST Tax
 * @property int $status 0 as Inactive, 1 as Active
 * @property string $created_on On which date application fee amount was added to database
 * @property string $created_by By which User application fee amount was added
 *
 * @property Users $createdBy
 * @property Organizations $organizationEnc
 * @property LoanTypes $loanTypeEnc
 */
class OrganizationFeeAmount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_fee_amount}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_fee_amount_enc_id', 'organization_enc_id', 'loan_type_enc_id', 'amount', 'gst', 'created_by'], 'required'],
            [['amount', 'status'], 'integer'],
            [['gst'], 'number'],
            [['created_on'], 'safe'],
            [['application_fee_amount_enc_id', 'organization_enc_id', 'loan_type_enc_id', 'created_by'], 'string', 'max' => 100],
            [['application_fee_amount_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['loan_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanTypes::className(), 'targetAttribute' => ['loan_type_enc_id' => 'loan_type_enc_id']],
        ];
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanTypeEnc()
    {
        return $this->hasOne(LoanTypes::className(), ['loan_type_enc_id' => 'loan_type_enc_id']);
    }
}
