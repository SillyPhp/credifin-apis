<?php
namespace common\models;

/**
 * This is the model class for table "{{%webinar_moderators}}".
 *
 * @property int $id
 * @property string $moderator_enc_id
 * @property string $webinar_event_enc_id
 * @property string $speaker_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property Speakers $speakerEnc
 * @property WebinarEvents $webinarEventEnc
 */
class WebinarModerators extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_moderators}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['moderator_enc_id', 'webinar_event_enc_id', 'speaker_enc_id', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['moderator_enc_id', 'webinar_event_enc_id', 'speaker_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['moderator_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['speaker_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speakers::className(), 'targetAttribute' => ['speaker_enc_id' => 'speaker_enc_id']],
            [['webinar_event_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarEvents::className(), 'targetAttribute' => ['webinar_event_enc_id' => 'event_enc_id']],
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
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
    public function getWebinarEventEnc()
    {
        return $this->hasOne(WebinarEvents::className(), ['event_enc_id' => 'webinar_event_enc_id']);
    }
}
