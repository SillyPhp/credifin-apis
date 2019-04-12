<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%conversations}}".
 *
 * @property int $id Primary Key
 * @property string $conversation_enc_id Conversation Encrypted ID
 * @property string $name Conversation Name
 * @property int $conversation_type Type of Conversation (1 as Private Chat, 2 as Group Chat)
 * @property string $created_on On which date Conversation information was added to database
 * @property string $created_by By which User Conversation information was added
 * @property string $last_updated_on On which date Conversation information was updated
 * @property string $last_updated_by By which User Conversation information was updated
 *
 * @property ConversationMessages[] $conversationMessages
 * @property ConversationParticipants[] $conversationParticipants
 * @property Users[] $userEncs
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class Conversations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%conversations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conversation_enc_id', 'created_by'], 'required'],
            [['conversation_type'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['conversation_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['conversation_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationMessages()
    {
        return $this->hasMany(ConversationMessages::className(), ['conversation_enc_id' => 'conversation_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationParticipants()
    {
        return $this->hasMany(ConversationParticipants::className(), ['conversation_enc_id' => 'conversation_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEncs()
    {
        return $this->hasMany(Users::className(), ['user_enc_id' => 'user_enc_id'])->viaTable('{{%conversation_participants}}', ['conversation_enc_id' => 'conversation_enc_id']);
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
