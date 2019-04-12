<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%conversation_messages}}".
 *
 * @property int $id Primary Key
 * @property string $message_enc_id Message Encrypted ID
 * @property string $conversation_enc_id Foreign Key to Conversations Table
 * @property string $participant_enc_id Foreign Key to Participants Table
 * @property string $message Message
 * @property string $created_on On which date Message information was added to database
 * @property string $created_by By which User Message information was added
 * @property string $last_updated_on On which date Message information was updated
 * @property string $last_updated_by By which User Message information was updated
 *
 * @property Conversations $conversationEnc
 * @property ConversationParticipants $participantEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ConversationMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%conversation_messages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_enc_id', 'conversation_enc_id', 'participant_enc_id', 'message', 'created_by'], 'required'],
            [['message'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['message_enc_id', 'conversation_enc_id', 'participant_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['message_enc_id'], 'unique'],
            [['conversation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conversations::className(), 'targetAttribute' => ['conversation_enc_id' => 'conversation_enc_id']],
            [['participant_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConversationParticipants::className(), 'targetAttribute' => ['participant_enc_id' => 'participant_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationEnc()
    {
        return $this->hasOne(Conversations::className(), ['conversation_enc_id' => 'conversation_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantEnc()
    {
        return $this->hasOne(ConversationParticipants::className(), ['participant_enc_id' => 'participant_enc_id']);
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
