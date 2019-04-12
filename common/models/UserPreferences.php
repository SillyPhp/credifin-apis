<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_preferences}}".
 *
 * @property int $id Primary Key
 * @property string $preference_enc_id Preference Encrypted ID
 * @property string $job_profile Foreign Key to Categories Table
 * @property string $type Type (Full Time, Part Time, Work from Home)
 * @property string $assigned_to
 * @property string $timings_from Timings From
 * @property string $timings_to Timings To
 * @property string $salary Monthly Salary
 * @property string $min_expected_salary Minimum Expected Salary
 * @property string $max_expected_salary Maximum Expected Salary
 * @property string $experience Minimum Experience Required
 * @property string $working_days Working Days
 * @property string $sat_frequency Saturday Frequency
 * @property string $sun_frequency Sunday Frequency
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property Categories $jobProfile
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property UserPreferredIndustries[] $userPreferredIndustries
 * @property UserPreferredLocations[] $userPreferredLocations
 * @property UserPreferredSkills[] $userPreferredSkills
 */
class UserPreferences extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_preferences}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preference_enc_id', 'job_profile', 'type', 'assigned_to', 'timings_from', 'timings_to', 'min_expected_salary', 'max_expected_salary', 'experience', 'working_days', 'created_on', 'created_by'], 'required'],
            [['type', 'assigned_to', 'experience', 'sat_frequency', 'sun_frequency'], 'string'],
            [['timings_from', 'timings_to', 'created_on', 'last_updated_on'], 'safe'],
            [['salary', 'min_expected_salary', 'max_expected_salary'], 'number'],
            [['is_deleted'], 'integer'],
            [['preference_enc_id', 'job_profile', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['working_days'], 'string', 'max' => 30],
            [['preference_enc_id'], 'unique'],
            [['job_profile'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['job_profile' => 'category_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobProfile()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'job_profile']);
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
    public function getUserPreferredIndustries()
    {
        return $this->hasMany(UserPreferredIndustries::className(), ['preference_enc_id' => 'preference_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredLocations()
    {
        return $this->hasMany(UserPreferredLocations::className(), ['preference_enc_id' => 'preference_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredSkills()
    {
        return $this->hasMany(UserPreferredSkills::className(), ['preference_enc_id' => 'preference_enc_id']);
    }
}