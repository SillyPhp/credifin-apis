<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%email_logs}}".
 *
 * @property int $id Primary Key
 * @property string $email_log_enc_id Encrypted Key
 * @property int $email_type 1 as Alerts, 2 as Preffered Emails, 3 interview notifier
 * @property string $user_enc_id User who has been sent the email
 * @property string $organization_enc_id Organization email has been sent to
 * @property string $subject Subject of email
 * @property string $template Template of Email
 * @property int $is_sent  0 yes, 1 no
 * @property string $created_on
 * @property string $last_updated_on
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
            [['email_log_enc_id', 'email_type', 'user_enc_id', 'subject', 'template'], 'required'],
            [['email_type', 'is_sent'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['email_log_enc_id', 'user_enc_id', 'organization_enc_id', 'template'], 'string', 'max' => 100],
            [['subject'], 'string', 'max' => 255],
            [['email_log_enc_id'], 'unique'],
        ];
    }

}
