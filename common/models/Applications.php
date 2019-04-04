<?php

namespace common\models;

/**
 * This is the model class for table "{{%applications}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Application Encrypted ID
 * @property int $application_id Application ID
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property string $email Email
 * @property string $contact Phone Number
 * @property string $qualification_enc_id Foreign Key to Qualifications Table
 * @property string $college School/College/University
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property int $status Application Status (1 as Pending, 2 as Accepted, 3 as Rejected)
 * @property string $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property ApplicationAnswers[] $applicationAnswers
 * @property Qualifications $qualificationEnc
 * @property Cities $cityEnc
 */
class Applications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_enc_id', 'application_id', 'first_name', 'last_name', 'email', 'contact', 'qualification_enc_id', 'college', 'city_enc_id'], 'required'],
            [['application_id', 'status'], 'integer'],
            [['application_enc_id', 'qualification_enc_id', 'city_enc_id'], 'string', 'max' => 100],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['email', 'college'], 'string', 'max' => 50],
            [['contact'], 'string', 'max' => 15],
            [['is_deleted'], 'string', 'max' => 1],
            [['application_enc_id'], 'unique'],
            [['application_id'], 'unique'],
            [['qualification_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualifications::className(), 'targetAttribute' => ['qualification_enc_id' => 'qualification_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationAnswers()
    {
        return $this->hasMany(ApplicationAnswers::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualificationEnc()
    {
        return $this->hasOne(Qualifications::className(), ['qualification_enc_id' => 'qualification_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }
}