<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jobs_data}}".
 *
 * @property int $id Primary Key
 * @property string $career_data_enc_id Career Data Encrypted ID
 * @property string $job_title Job Title
 * @property string $designation Designation
 * @property string $job_profile Job Profile
 * @property int $salary Salary
 * @property int $ctc CTC
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property int $experience Experience
 * @property string $company_name Company Name
 *
 * @property Cities $cityEnc
 */
class JobsData extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%jobs_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['career_data_enc_id', 'job_title', 'designation', 'job_profile', 'salary', 'city_enc_id', 'experience'], 'required'],
            [['salary', 'ctc', 'experience'], 'integer'],
            [['career_data_enc_id', 'city_enc_id', 'company_name'], 'string', 'max' => 100],
            [['job_title', 'designation', 'job_profile'], 'string', 'max' => 50],
            [['career_data_enc_id'], 'unique'],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc() {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

}
