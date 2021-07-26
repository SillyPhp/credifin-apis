<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%app_invite_email_logs}}".
 *
 * @property int $id Primary Key
 * @property string $email_log_enc_id Encrypted Key
 * @property string $application_enc_id
 * @property int $is_sent  1 yes, 0 no
 * @property string $created_on
 * @property string $last_updated_on
 *
 * @property EmployerApplications $applicationEnc
 */
class AppInviteEmailLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%app_invite_email_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email_log_enc_id'], 'required'],
            [['is_sent'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['email_log_enc_id', 'application_enc_id'], 'string', 'max' => 100],
            [['email_log_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }
}
