<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%applied_email_logs}}".
 *
 * @property int $id Primary Key
 * @property string $email_log_enc_id Encrypted Key
 * @property string $applied_enc_id
 * @property int $is_sent  1 yes, 0 no
 * @property string $created_on
 * @property string $last_updated_on
 *
 * @property AppliedApplications $appliedEnc
 */
class AppliedEmailLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%applied_email_logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_log_enc_id', 'applied_enc_id'], 'required'],
            [['is_sent'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['email_log_enc_id', 'applied_enc_id'], 'string', 'max' => 100],
            [['email_log_enc_id'], 'unique'],
            [['applied_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedApplications::className(), 'targetAttribute' => ['applied_enc_id' => 'applied_application_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dsbedutech', 'ID'),
            'email_log_enc_id' => Yii::t('dsbedutech', 'Email Log Enc ID'),
            'applied_enc_id' => Yii::t('dsbedutech', 'Applied Enc ID'),
            'is_sent' => Yii::t('dsbedutech', 'Is Sent'),
            'created_on' => Yii::t('dsbedutech', 'Created On'),
            'last_updated_on' => Yii::t('dsbedutech', 'Last Updated On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedEnc()
    {
        return $this->hasOne(AppliedApplications::className(), ['applied_application_enc_id' => 'applied_enc_id']);
    }
}
