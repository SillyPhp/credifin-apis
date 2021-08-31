<?php

namespace common\models;

/**
 * This is the model class for table "{{%webinar_conversations}}".
 *
 * @property int $id Primary Key
 * @property string $conversation_enc_id Conversation Encrypted ID
 * @property string $webinar_event_enc_id Foreign Key to webinars table
 * @property int $conversation_type Type of Conversation (1 as Private Chat, 2 as Group Chat)
 * @property string $created_on On which date Conversation information was added to database
 * @property string $created_by By which User Conversation information was added
 * @property string $last_updated_on On which date Conversation information was updated
 * @property string $last_updated_by By which User Conversation information was updated
 *
 * @property WebinarConversationMessages[] $webinarConversationMessages
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property WebinarEvents $webinarEventEnc
 */
class WebinarConversations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_conversations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conversation_enc_id', 'webinar_event_enc_id', 'created_by'], 'required'],
            [['conversation_type'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['conversation_enc_id', 'webinar_event_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['conversation_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['webinar_event_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarEvents::className(), 'targetAttribute' => ['webinar_event_enc_id' => 'event_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarConversationMessages()
    {
        return $this->hasMany(WebinarConversationMessages::className(), ['conversation_enc_id' => 'conversation_enc_id']);
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEventEnc()
    {
        return $this->hasOne(WebinarEvents::className(), ['event_enc_id' => 'webinar_event_enc_id']);
    }
}
