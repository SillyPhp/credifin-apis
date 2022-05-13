<?php

namespace common\models;

/**
 * This is the model class for table "{{%notifications}}".
 *
 * @property int $id Primary Key
 * @property string $notification_enc_id Notification Encrypted ID
 * @property string $user_enc_id loan_application_enc_id
 * @property string $application_enc_id Post Notification
 * @property string $created_on On which date Post Notification information was added to database
 * @property string $created_by Foreign Key to Users Table
 * @property int $status Post Notification Status (0 as Pending, 1 as Approved, 2 as Rejected)
 * @property int $is_deleted Is Notification Deleted (0 as False, 1 as True)
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
            [['notification_enc_id', 'user_enc_id', 'application_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['notification_enc_id', 'user_enc_id', 'application_enc_id', 'created_by'], 'string', 'max' => 100],
            [['notification_enc_id'], 'unique'],
        ];
    }

}
