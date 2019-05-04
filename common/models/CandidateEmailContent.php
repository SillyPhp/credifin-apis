<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%candidate_email_content}}".
 *
 * @property int $id Primary Key
 * @property string $email_content_id Encrypted ID
 * @property string $email_log_enc_id Foreign key to Candidate Email Logs
 * @property string $user_enc_id Foregin to Users table
 * @property string $application_enc_id Foreign key to employer applications
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 */
class CandidateEmailContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%candidate_email_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_content_id', 'email_log_enc_id', 'user_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['email_content_id', 'email_log_enc_id', 'user_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
        ];
    }

}
