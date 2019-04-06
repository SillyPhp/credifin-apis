<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%conversation_participants}}".
 *
 * @property int $id Primary Key
 * @property string $participant_enc_id Participant Encrypted ID
 * @property string $conversation_enc_id Foreign Key to Conversations Table
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $organization_enc_id
 * @property string $created_on On which date Participant information was added to database
 * @property string $created_by By which User Participant information was added
 * @property string $last_updated_on On which date Participant information was updated
 * @property string $last_updated_by By which User Participant information was updated
 *
 * @property ConversationMessages[] $conversationMessages
 * @property Conversations $conversationEnc
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ConversationParticipants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%conversation_participants}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['participant_enc_id', 'conversation_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['participant_enc_id', 'conversation_enc_id', 'user_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['participant_enc_id'], 'unique'],
            [['conversation_enc_id', 'user_enc_id'], 'unique', 'targetAttribute' => ['conversation_enc_id', 'user_enc_id']],
            [['conversation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conversations::className(), 'targetAttribute' => ['conversation_enc_id' => 'conversation_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationMessages()
    {
        return $this->hasMany(ConversationMessages::className(), ['participant_enc_id' => 'participant_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }
}
