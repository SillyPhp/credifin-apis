<?php

namespace common\models;

/**
 * This is the model class for table "{{%erexx_employer_applications}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id application Encrypted ID
 * @property string $employer_application_enc_id Employer application Encrypted ID
 * @property string $college_enc_id College Encrypted ID
 * @property int $is_college_approved 1 for Approved and 0 for Pending
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property string $status
 * @property int $is_deleted
 *
 * @property EmployerApplications $employerApplicationEnc
 * @property Organizations $collegeEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ErexxEmployerApplications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%erexx_employer_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_enc_id', 'employer_application_enc_id', 'college_enc_id', 'created_by'], 'required'],
            [['is_college_approved', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['application_enc_id', 'employer_application_enc_id', 'college_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_enc_id'], 'unique'],
            [['employer_application_enc_id', 'college_enc_id', 'is_deleted'], 'unique', 'targetAttribute' => ['employer_application_enc_id', 'college_enc_id', 'is_deleted']],
            [['employer_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['employer_application_enc_id' => 'application_enc_id']],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplicationEnc()
    {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'employer_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
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
