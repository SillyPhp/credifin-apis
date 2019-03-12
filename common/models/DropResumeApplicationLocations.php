<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%drop_resume_application_locations}}".
 *
 * @property int $id Primary Key
 * @property string $applied_location_enc_id Applied Location Encrypted ID
 * @property string $applied_application_enc_id Foreign Key to Drop Resume Applications Table
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $created_on On which date Applied Location information was added to database
 * @property string $created_by By which User Applied Location information was added
 * @property string $last_updated_on On which date Applied Location information was updated
 * @property string $last_updated_by By which User Applied Location information was updated
 *
 * @property DropResumeApplications $appliedApplicationEnc
 * @property Cities $cityEnc
 * @property Users $userEnc
 */
class DropResumeApplicationLocations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%drop_resume_application_locations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applied_location_enc_id', 'applied_application_enc_id', 'city_enc_id', 'user_enc_id', 'created_by', 'last_updated_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['applied_location_enc_id', 'applied_application_enc_id', 'city_enc_id', 'user_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['applied_location_enc_id'], 'unique'],
            [['applied_application_enc_id', 'city_enc_id', 'user_enc_id'], 'unique', 'targetAttribute' => ['applied_application_enc_id', 'city_enc_id', 'user_enc_id']],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropResumeApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc()
    {
        return $this->hasOne(DropResumeApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }
}