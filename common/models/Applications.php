<?php

namespace common\models;

/**
 * This is the model class for table "{{%applications}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Application Encrypted ID
 * @property int $application_id Application ID
 * @property string $application_type_enc_id Foreign Keys to Application types Table
 * @property string $user_enc_id Foreign Keys to Users Table
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property string $email Email
 * @property string $contact Phone Number
 * @property string $qualification_enc_id Foreign Key to Qualifications Table
 * @property string $college School/College/University
 * @property string $city_enc_id Foreign Key to Cities Table
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property int $status Application Status (1 as Pending, 2 as Accepted, 3 as Rejected)
 * @property int $reviews 1 as Excellent, 2 as Good, 3 as Average, 4 as Bad
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property ApplicationAnswers[] $applicationAnswers
 * @property Qualifications $qualificationEnc
 * @property Cities $cityEnc
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property ApplicationTypes $applicationTypeEnc
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
            [['application_enc_id', 'application_id', 'application_type_enc_id', 'user_enc_id', 'qualification_enc_id', 'college', 'created_by'], 'required'],
            [['application_id', 'status', 'reviews', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['application_enc_id', 'application_type_enc_id', 'user_enc_id', 'qualification_enc_id', 'city_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['email', 'college'], 'string', 'max' => 50],
            [['contact'], 'string', 'max' => 15],
            [['application_enc_id', 'application_id', 'user_enc_id'], 'unique', 'targetAttribute' => ['application_enc_id', 'application_id', 'user_enc_id']],
            [['qualification_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualifications::className(), 'targetAttribute' => ['qualification_enc_id' => 'qualification_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['application_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTypes::className(), 'targetAttribute' => ['application_type_enc_id' => 'application_type_enc_id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
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
    public function getApplicationTypeEnc()
    {
        return $this->hasOne(ApplicationTypes::className(), ['application_type_enc_id' => 'application_type_enc_id']);
    }
}
