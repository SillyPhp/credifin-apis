<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinars}}".
 *
 * @property int $id Primary Key
 * @property string $webinar_enc_id Webinar Encrypted Encrypted ID
 * @property string $session_enc_id Foreign Key to WebinarSessions
 * @property string $title Webinar Title
 * @property string $slug Webinar slug
 * @property string $start_datetime
 * @property int $duration Duration save as minutes
 * @property string $image
 * @property string $image_location
 * @property string $availability
 * @property int $seats
 * @property string $description
 * @property int $session_for 0 as both, 1 as EY, 2 as Colleges
 * @property double $price price of webinar
 * @property int $status 0 as yet to start, 1 as ongoing, 2 as ended 3 as technical issues, 4 as cancelled
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property AssignedWebinarTo[] $assignedWebinarTos
 * @property WebinarConversations[] $webinarConversations
 * @property WebinarOutcomes[] $webinarOutcomes
 * @property WebinarRegistrations[] $webinarRegistrations
 * @property WebinarSpeakers[] $webinarSpeakers
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property WebinarSessions $sessionEnc
 */
class Webinars extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinars}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['webinar_enc_id', 'title', 'slug', 'start_datetime', 'duration', 'description', 'session_for', 'created_by'], 'required'],
            [['start_datetime', 'created_on', 'last_updated_on'], 'safe'],
            [['duration', 'seats', 'session_for', 'status', 'is_deleted'], 'integer'],
            [['availability', 'description'], 'string'],
            [['price'], 'number'],
            [['webinar_enc_id', 'session_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['title', 'slug'], 'string', 'max' => 255],
            [['webinar_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['session_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarSessions::className(), 'targetAttribute' => ['session_enc_id' => 'session_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedWebinarTos()
    {
        return $this->hasMany(AssignedWebinarTo::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarConversations()
    {
        return $this->hasMany(WebinarConversations::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarOutcomes()
    {
        return $this->hasMany(WebinarOutcomes::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRegistrations()
    {
        return $this->hasMany(WebinarRegistrations::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarSpeakers()
    {
        return $this->hasMany(WebinarSpeakers::className(), ['webinar_enc_id' => 'webinar_enc_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessionEnc()
    {
        return $this->hasOne(WebinarSessions::className(), ['session_enc_id' => 'session_enc_id']);
    }
}
