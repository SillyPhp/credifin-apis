<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar}}".
 *
 * @property int $id Primary Key
 * @property string $webinar_enc_id Webinar Encrypted Encrypted ID
 * @property string $name
 * @property string $title
 * @property string $description
 * @property int $session_for 0 as both, 1 as EY, 2 as Colleges
 * @property int $seats
 * @property string $slug
 * @property string $image
 * @property string $image_location
 * @property string $email_sharing_image
 * @property string $email_sharing_image_location
 * @property double $price
 * @property double $gst
 * @property string $availability
 * @property int $for_all_colleges 1 as all colleges, 0 as selected colleges
 * @property string $other_platforms Other platform links like zoom etc..
 * @property string $platform_webinar_id webinar unique id by zoom or other platform
 * @property int $webinar_conduct_on 0 as EY, 1 as Other Platform
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property AssignedWebinarTo[] $assignedWebinarTos
 * @property AssignedWebinarWidgetTemplate[] $assignedWebinarWidgetTemplates
 * @property UserWebinarInterest[] $userWebinarInterests
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property WebinarEvents[] $webinarEvents
 * @property WebinarOutcomes[] $webinarOutcomes
 * @property WebinarPayments[] $webinarPayments
 * @property WebinarRegistrations[] $webinarRegistrations
 * @property WebinarWidgetTemplates[] $webinarWidgetTemplates
 */
class Webinar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%webinar}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['webinar_enc_id', 'name', 'title', 'description', 'session_for', 'seats', 'slug', 'created_by'], 'required'],
            [['description', 'availability', 'other_platforms'], 'string'],
            [['session_for', 'seats', 'for_all_colleges', 'webinar_conduct_on', 'is_deleted'], 'integer'],
            [['price', 'gst'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['webinar_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name', 'title', 'slug', 'image', 'image_location', 'email_sharing_image', 'email_sharing_image_location'], 'string', 'max' => 200],
            [['platform_webinar_id'], 'string', 'max' => 255],
            [['webinar_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getAssignedWebinarWidgetTemplates()
    {
        return $this->hasMany(AssignedWebinarWidgetTemplate::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserWebinarInterests()
    {
        return $this->hasMany(UserWebinarInterest::className(), ['webinar_enc_id' => 'webinar_enc_id']);
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
    public function getWebinarEvents()
    {
        return $this->hasMany(WebinarEvents::className(), ['webinar_enc_id' => 'webinar_enc_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarWidgetTemplates()
    {
        return $this->hasMany(WebinarWidgetTemplates::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }
}
