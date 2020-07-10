<?php

namespace common\models;

/**
 * This is the model class for table "{{%email_logs}}".
 *
 * @property int $id Primary Key
 * @property string $email_log_enc_id Encrypted Key
 * @property int $email_type 1 as Alerts, 2 as Preffered Emails, 3 interview notifier 4 as Update User Profile, 5 Welcome Email, 6 invitation
 * @property string $user_enc_id User who has been sent the email
 * @property string $organization_enc_id Organization email has been sent to
 * @property string $receiver_email Receiver Email
 * @property string $receiver_name Receiver Name
 * @property string $receiver_phone Receiver Phone
 * @property string $subject Subject of email
 * @property string $template Template of Email
 * @property string $data Email data
 * @property int $is_sent  0 yes, 1 no
 * @property string $created_on
 * @property string $last_updated_on
 *
 * @property Users $userEnc
 * @property Organizations $organizationEnc
 */
class EmailLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_log_enc_id', 'email_type', 'user_enc_id', 'receiver_email', 'subject', 'template'], 'required'],
            [['email_type', 'is_sent'], 'integer'],
            [['data'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['email_log_enc_id', 'user_enc_id', 'organization_enc_id', 'receiver_name', 'template'], 'string', 'max' => 100],
            [['receiver_email'], 'string', 'max' => 50],
            [['receiver_phone'], 'string', 'max' => 15],
            [['subject'], 'string', 'max' => 255],
            [['email_log_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
