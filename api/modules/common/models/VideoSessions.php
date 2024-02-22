<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%video_sessions}}".
 *
 * @property int $id Primary Key
 * @property string $session_enc_id Encrypted Key
 * @property int $expire_time
 * @property string $app_id
 * @property string $channel_name
 * @property string $session_token
 * @property int $is_active
 * @property string $created_by
 * @property string $created_on
 *
 * @property AssignedVideoSessions[] $assignedVideoSessions
 * @property ClassAccess[] $classAccesses
 * @property Users $createdBy
 */
class VideoSessions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%video_sessions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_enc_id', 'expire_time', 'app_id', 'channel_name', 'session_token', 'created_by'], 'required'],
            [['expire_time', 'is_active'], 'integer'],
            [['created_on'], 'safe'],
            [['session_enc_id', 'app_id', 'channel_name', 'created_by'], 'string', 'max' => 100],
            [['session_token'], 'string', 'max' => 200],
            [['session_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedVideoSessions()
    {
        return $this->hasMany(AssignedVideoSessions::className(), ['session_enc_id' => 'session_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassAccesses()
    {
        return $this->hasMany(ClassAccess::className(), ['session_enc_id' => 'session_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
