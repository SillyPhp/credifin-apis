<?php

namespace common\models;

/**
 * This is the model class for table "{{%application_options_template}}".
 *
 * @property int $id Primary Key
 * @property string $option_enc_id Option Encrypted ID
 * @property string $application_enc_id Foreign Key To Employer Applications Table
 * @property string $wage_type Wage Type
 * @property double $fixed_wage Fixed Wage
 * @property double $min_wage Minimum Wage
 * @property double $max_wage Maximum Wage
 * @property double $ctc Cost To Company
 * @property string $wage_duration Wage Duration
 * @property int $has_placement_offer Has any Pre Placement Offer (0 as No, 1 as Yes)
 * @property double $pre_placement_offer Pre Placement Offer
 * @property string $working_days Working Days
 * @property string $saturday_frequency Saturday Working Frequency
 * @property string $sunday_frequency Sunday Working Frequency
 * @property string $interview_start_date Interview Start Date Time
 * @property string $interview_end_date Interview End Date Time
 * @property int $has_questionnaire Has Questionnaire (0 as No, 1 as Yes)
 * @property int $internship_duration Duration of Internship
 * @property string $internship_duration_type Internship Duration Type
 * @property string $created_on On which date Wage information was added to database
 * @property string $created_by By which User Wage information was added
 * @property string $last_updated_on On which date Wage information was updated
 * @property string $last_updated_by By which User Wage information was updated
 *
 * @property ApplicationTemplates $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationOptionsTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application_options_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_enc_id', 'application_enc_id', 'created_by'], 'required'],
            [['wage_type', 'wage_duration', 'saturday_frequency', 'sunday_frequency', 'internship_duration_type'], 'string'],
            [['fixed_wage', 'min_wage', 'max_wage', 'ctc', 'pre_placement_offer'], 'number'],
            [['has_placement_offer', 'has_questionnaire', 'internship_duration'], 'integer'],
            [['interview_start_date', 'interview_end_date', 'created_on', 'last_updated_on'], 'safe'],
            [['option_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['working_days'], 'string', 'max' => 30],
            [['option_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTemplates::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(ApplicationTemplates::className(), ['application_enc_id' => 'application_enc_id']);
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
