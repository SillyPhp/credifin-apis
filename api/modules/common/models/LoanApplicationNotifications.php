<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_application_notifications}}".
 *
 * @property int $id Primary Key
 * @property string $notification_enc_id Notification Encrypted ID
 * @property string $loan_application_enc_id loan_application_enc_id
 * @property string $message Post Notification
 * @property string $created_on On which date Post Notification information was added to database
 * @property string $created_by Foreign Key to Users Table
 * @property string $last_updated_on On which date Post Notification information was updated
 * @property string $last_updated_by
 * @property int $status Post Notification Status (0 as Pending, 1 as Approved, 2 as Rejected)
 * @property string $source
 * @property int $is_deleted Is Notification Deleted (0 as False, 1 as True)
 *
 * @property LoanApplications $loanApplicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class LoanApplicationNotifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_notifications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_enc_id', 'loan_application_enc_id', 'message', 'created_by'], 'required'],
            [['message', 'source'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['notification_enc_id', 'loan_application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['notification_enc_id'], 'unique'],
            [['loan_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_application_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'notification_enc_id' => Yii::t('common', 'Notification Enc ID'),
            'loan_application_enc_id' => Yii::t('common', 'Loan Application Enc ID'),
            'message' => Yii::t('common', 'Message'),
            'created_on' => Yii::t('common', 'Created On'),
            'created_by' => Yii::t('common', 'Created By'),
            'last_updated_on' => Yii::t('common', 'Last Updated On'),
            'last_updated_by' => Yii::t('common', 'Last Updated By'),
            'status' => Yii::t('common', 'Status'),
            'is_deleted' => Yii::t('common', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_application_enc_id']);
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
}
