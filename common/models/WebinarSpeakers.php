<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar_speakers}}".
 *
 * @property int $id
 * @property string $assigned_speaker_enc_id
 * @property string $webinar_enc_id
 * @property string $speaker_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Webinars $webinarEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Speakers $speakerEnc
 */
class WebinarSpeakers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_speakers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_speaker_enc_id', 'webinar_enc_id', 'speaker_enc_id', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_speaker_enc_id', 'webinar_enc_id', 'speaker_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_speaker_enc_id'], 'unique'],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinars::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['speaker_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speakers::className(), 'targetAttribute' => ['speaker_enc_id' => 'speaker_enc_id']],
        ];
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeakerEnc()
    {
        return $this->hasOne(Speakers::className(), ['speaker_enc_id' => 'speaker_enc_id']);
    }
}
