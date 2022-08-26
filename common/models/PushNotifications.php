<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%push_notifications}}".
 *
 * @property int $id
 * @property string $push_notification_enc_id
 * @property string $user_enc_id user id
 * @property string $token notification token
 * @property string $title notification title
 * @property string $description notification description
 * @property string $link notification link
 * @property string $device_id device id
 * @property string $created_on created on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Users $userEnc
 */
class PushNotifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%push_notifications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['push_notification_enc_id', 'token', 'title', 'description', 'link', 'device_id', 'created_on'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['push_notification_enc_id', 'user_enc_id', 'device_id'], 'string', 'max' => 100],
            [['token', 'description'], 'string', 'max' => 255],
            [['title', 'link'], 'string', 'max' => 150],
            [['push_notification_enc_id'], 'unique'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
