<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_preferred_job_profile}}".
 *
 * @property int $id Primary Key
 * @property string $preferred_job_profile_enc_id Preferred Job Profile Encrypted ID
 * @property string $job_profile_enc_id Foreign Key to Job Profile Table
 * @property string $preference_enc_id Foreign Key to User Preferences Table
 * @property string $created_on On which date User Preferred Job Profile information was added to database
 * @property string $created_by By which User Preferred Job Profile information was added
 * @property string $last_updated_on On which date User Preferred Job Profile information was updated
 * @property string $last_updated_by By which User Preferred Job Profile information was updated
 * @property int $is_deleted Is User Preferred Skill Deleted (0 As False, 1 As True)
 *
 * @property Categories $jobProfileEnc
 * @property UserPreferences $preferenceEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserPreferredJobProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_preferred_job_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preferred_job_profile_enc_id', 'job_profile_enc_id', 'preference_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['preferred_job_profile_enc_id', 'job_profile_enc_id', 'preference_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['preferred_job_profile_enc_id'], 'unique'],
            [['job_profile_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['job_profile_enc_id' => 'category_enc_id']],
            [['preference_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPreferences::className(), 'targetAttribute' => ['preference_enc_id' => 'preference_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobProfileEnc()
    {
        return $this->hasOne(Categories::className(), ['category_enc_id' => 'job_profile_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreferenceEnc()
    {
        return $this->hasOne(UserPreferences::className(), ['preference_enc_id' => 'preference_enc_id']);
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
