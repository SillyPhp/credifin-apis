<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_video_sessions}}".
 *
 * @property int $id
 * @property string $assigned_video_enc_id
 * @property string $expire_date session expiry date
 * @property string $class_enc_id class encrypted id
 * @property string $session_enc_id session id
 * @property string $status video status
 * @property string $video_session_end_time end time session
 * @property string $created_by created by id
 * @property string $created_on created on time
 *
 * @property OnlineClasses $classEnc
 * @property VideoSessions $sessionEnc
 * @property Teachers $createdBy
 */
class AssignedVideoSessions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_video_sessions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_video_enc_id', 'expire_date', 'class_enc_id', 'session_enc_id', 'created_by'], 'required'],
            [['expire_date', 'video_session_end_time', 'created_on'], 'safe'],
            [['status'], 'string'],
            [['assigned_video_enc_id', 'class_enc_id', 'session_enc_id', 'created_by'], 'string', 'max' => 100],
            [['assigned_video_enc_id'], 'unique'],
            [['class_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OnlineClasses::className(), 'targetAttribute' => ['class_enc_id' => 'class_enc_id']],
            [['session_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => VideoSessions::className(), 'targetAttribute' => ['session_enc_id' => 'session_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Teachers::className(), 'targetAttribute' => ['created_by' => 'teacher_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassEnc()
    {
        return $this->hasOne(OnlineClasses::className(), ['class_enc_id' => 'class_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessionEnc()
    {
        return $this->hasOne(VideoSessions::className(), ['session_enc_id' => 'session_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Teachers::className(), ['teacher_enc_id' => 'created_by']);
    }
}
