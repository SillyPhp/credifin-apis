<?php

namespace common\models;

/**
 * This is the model class for table "{{%application_employee_benefits}}".
 *
 * @property int $id Primary Key
 * @property string $application_benefit_enc_id Application Benefit Encrypted ID
 * @property string $benefit_enc_id Foreign Key to Employee Benefits Table
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property int $is_available Is Benefit Available (0 as False, 1 as True)
 * @property string $created_on On which date Application Benefit information was added to database
 * @property string $created_by By which User Application Benefit information was added
 * @property string $last_updated_on On which date Application Benefit information was updated
 * @property string $last_updated_by By which User Application Benefit information was updated
 * @property int $is_deleted Is Application Benefit Deleted (0 As False, 1 As True)
 *
 * @property EmployerApplications $applicationEnc
 * @property EmployeeBenefits $benefitEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationEmployeeBenefits extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_employee_benefits}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['application_benefit_enc_id', 'benefit_enc_id', 'application_enc_id', 'created_on', 'created_by'], 'required'],
            [['is_available', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['application_benefit_enc_id', 'benefit_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_benefit_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['benefit_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeBenefits::className(), 'targetAttribute' => ['benefit_enc_id' => 'benefit_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc() {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBenefitEnc() {
        return $this->hasOne(EmployeeBenefits::className(), ['benefit_enc_id' => 'benefit_enc_id']);
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

}
