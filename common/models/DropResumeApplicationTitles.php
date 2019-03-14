<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%drop_resume_application_titles}}".
 *
 * @property int $id Primary Key
 * @property string $applied_title_enc_id Applied Title Encrypted ID
 * @property string $applied_application_enc_id Foreign Key to Drop Resume Applications Table
 * @property string $title Foreign Key to Organization Assigned Table
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property string $created_on On which date Applied Titile information was added to database
 * @property string $created_by By which User Applied Title information was added
 * @property string $last_updated_on On which date Applied Title information was updated
 * @property string $last_updated_by By which User Applied Title information was updated
 * @property int $status Application Status (0 as Pending, 1 as Shortlisted, 2 as Rejected)
 *
 * @property DropResumeApplications $appliedApplicationEnc
 * @property OrganizationAssignedCategories $title0
 * @property Users $userEnc
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class DropResumeApplicationTitles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%drop_resume_application_titles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applied_title_enc_id', 'applied_application_enc_id', 'title', 'user_enc_id', 'created_by', 'last_updated_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'integer'],
            [['applied_title_enc_id', 'applied_application_enc_id', 'title', 'user_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['applied_application_enc_id', 'title', 'user_enc_id'], 'unique', 'targetAttribute' => ['applied_application_enc_id', 'title', 'user_enc_id']],
            [['applied_title_enc_id'], 'unique'],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropResumeApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['title'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationAssignedCategories::className(), 'targetAttribute' => ['title' => 'assigned_category_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getTitle0()
    {
        return $this->hasOne(OrganizationAssignedCategories::className(), ['assigned_category_enc_id' => 'title']);
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
    public function getApplicationEnc()
    {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
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
