<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%candidate_email_logs}}".
 *
 * @property int $id Primary Key
 * @property string $email_log_enc_id Encrypted Key
 * @property int $email_type 1 as Alerts, 2 as Interest Based
 * @property string $subject Subject of email
 * @property string $template Template of Email
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 */
class CandidateEmailLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%candidate_email_logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_log_enc_id', 'email_type', 'subject', 'template', 'created_by'], 'required'],
            [['email_type'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['email_log_enc_id', 'template', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['subject'], 'string', 'max' => 255],
        ];
    }

}
