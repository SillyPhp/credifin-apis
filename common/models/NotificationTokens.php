<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%notification_tokens}}".
 *
 * @property int $id
 * @property string $token_enc_id
 * @property string $user_enc_id
 * @property string $token
 * @property string $device_id
 * @property string $created_on
 * @property string $token_expired_on
 * @property int $is_deleted
 *
 * @property Users $userEnc
 */
class NotificationTokens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notification_tokens}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token_enc_id', 'user_enc_id', 'token'], 'required'],
            [['created_on', 'token_expired_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['token_enc_id', 'user_enc_id', 'device_id'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 255],
            [['token_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
        ];
    }

   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }
}
