<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar}}".
 *
 * @property int $id Primary Key
 * @property string $webinar_enc_id Webinar Encrypted Encrypted ID
 * @property string $session_enc_id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property int $session_for 0 as both, 1 as EY, 2 as Colleges
 * @property int $seats
 * @property string $slug
 * @property string $image
 * @property string $image_location
 * @property double $price
 * @property double $gst
 * @property string $availability
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property AssignedWebinarTo[] $assignedWebinarTos
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property WebinarSessions $sessionEnc
 * @property WebinarEvents[] $webinarEvents
 * @property WebinarPayments[] $webinarPayments
 * @property WebinarRegistrations[] $webinarRegistrations
 */
class Webinar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar}}';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessionEnc()
    {
        return $this->hasOne(WebinarSessions::className(), ['session_enc_id' => 'session_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEvents()
    {
        return $this->hasMany(WebinarEvents::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarPayments()
    {
        return $this->hasMany(WebinarPayments::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRegistrations()
    {
        return $this->hasMany(WebinarRegistrations::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }
}
