<?php

namespace common\models;


/**
 * This is the model class for table "{{%loan_application_options}}".
 *
 * @property int $id Primary Key
 * @property string $option_enc_id Option Encrypted ID
 * @property string $loan_app_enc_id
 * @property int $application_by who is filing the application 0 as self or student itself 1 as parent 2 as execitive
 * @property int $number_of_loans number of previous loans if nay
 * @property double $total_loan_amount
 * @property double $monthly_emi
 * @property string $property_requirement
 * @property string $comment
 * @property string $follow_up_on
 * @property string $follow_up_by
 * @property string $created_on On which date  information was added to database
 * @property string $created_by Foreign Key to Users Table
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by
 * @property int $is_deleted Is  Deleted (0 as False, 1 as True)
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Users $followUpBy
 */
class LoanApplicationOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_options}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_enc_id', 'loan_app_enc_id'], 'required'],
            [['application_by', 'number_of_loans', 'is_deleted'], 'integer'],
            [['total_loan_amount', 'monthly_emi'], 'number'],
            [['property_requirement', 'comment'], 'string'],
            [['follow_up_on', 'created_on', 'last_updated_on'], 'safe'],
            [['option_enc_id', 'loan_app_enc_id', 'follow_up_by', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['option_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['follow_up_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['follow_up_by' => 'user_enc_id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowUpBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'follow_up_by']);
    }
}
