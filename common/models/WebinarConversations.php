<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar_conversations}}".
 *
 * @property int $id Primary Key
 * @property string $conversation_enc_id Conversation Encrypted ID
 * @property string $webinar_enc_id Foreign Key to webinars table
 * @property int $conversation_type Type of Conversation (1 as Private Chat, 2 as Group Chat)
 * @property string $created_on On which date Conversation information was added to database
 * @property string $created_by By which User Conversation information was added
 * @property string $last_updated_on On which date Conversation information was updated
 * @property string $last_updated_by By which User Conversation information was updated
 *
 * @property WebianarConversationMessages[] $webianarConversationMessages
 * @property Webinars $webinarEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
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
            [['conversation_enc_id', 'webinar_enc_id', 'created_by'], 'required'],
            [['conversation_type'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['conversation_enc_id', 'webinar_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['conversation_enc_id'], 'unique'],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinars::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebianarConversationMessages()
    {
        return $this->hasMany(WebianarConversationMessages::className(), ['conversation_enc_id' => 'conversation_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinars::className(), ['webinar_enc_id' => 'webinar_enc_id']);
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
}
