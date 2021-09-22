<?php

namespace common\models;


/**
 * This is the model class for table "{{%webinar_request_speakers}}".
 *
 * @property int $id
 * @property string $request_speaker_enc_id
 * @property string $speaker_enc_id
 * @property string $webinar_request_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Speakers $speakerEnc
 * @property WebinarRequest $webinarRequestEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class WebinarRequestSpeakers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_request_speakers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_speaker_enc_id', 'speaker_enc_id', 'webinar_request_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['request_speaker_enc_id', 'speaker_enc_id', 'webinar_request_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['request_speaker_enc_id'], 'unique'],
            [['speaker_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speakers::className(), 'targetAttribute' => ['speaker_enc_id' => 'speaker_enc_id']],
            [['webinar_request_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarRequest::className(), 'targetAttribute' => ['webinar_request_enc_id' => 'request_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeakerEnc()
    {
        return $this->hasOne(Speakers::className(), ['speaker_enc_id' => 'speaker_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRequestEnc()
    {
        return $this->hasOne(WebinarRequest::className(), ['request_enc_id' => 'webinar_request_enc_id']);
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
