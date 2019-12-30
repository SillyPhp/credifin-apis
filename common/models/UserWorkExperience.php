<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_work_experience}}".
 *
 * @property int $id Primary Key
 * @property string $experience_enc_id Work Experience Encrypted ID
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $company Company Name
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $title Title
 * @property string $description Description
 * @property string $from_date From Date
 * @property string $to_date To Date
 * @property int $is_current Is Currently Working (1 as Yes, 0 as No)
 * @property string $created_on On which date User Work Experience information was added to database
 * @property string $created_by By which User Work Experience information was added
 * @property string $last_updated_on On which date User Work Experience information was updated
 * @property string $last_updated_by By which User User Work Experience information was updated
 */
class UserWorkExperience extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_work_experience}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['experience_enc_id', 'user_enc_id', 'company', 'description', 'from_date', 'created_by'], 'required'],
            [['description'], 'string'],
            [['from_date', 'to_date', 'created_on', 'last_updated_on'], 'safe'],
            [['ctc', 'salary', 'is_current'], 'integer'],
            [['experience_enc_id', 'user_enc_id', 'company', 'city_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 50],
            [['experience_enc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc() {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }

}
