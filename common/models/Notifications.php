<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%notifications}}".
 *
 * @property int $id Primary Key
 * @property string $notification_enc_id Notification Encrypted ID
 * @property int $notifcation_type Notification type (0 as push, 1 as In App, 2 as whatsapp, 3  as sms)
 * @property string $notification_image
 * @property string $notification_icon
 * @property string $user_enc_id User Enc Id
 * @property string $title
 * @property string $description
 * @property string $link
 * @property string $created_by
 * @property string $created_on On which date Post Notification information was added to database
 * @property int $is_open
 * @property string $opened_on
 * @property int $status Notification Status (0 as Pending, 1 as Sent, 2 as Failed)
 * @property int $is_deleted Is Notification Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $userEnc
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notifications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_enc_id', 'user_enc_id', 'title', 'created_by'], 'required'],
            [['notifcation_type', 'is_open', 'status', 'is_deleted'], 'integer'],
            [['created_on', 'opened_on'], 'safe'],
            [['notification_enc_id', 'user_enc_id', 'title', 'link', 'created_by'], 'string', 'max' => 100],
            [['notification_image', 'notification_icon', 'description'], 'string', 'max' => 200],
            [['notification_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
        ];
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
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }
}
