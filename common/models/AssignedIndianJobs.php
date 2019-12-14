<?php

namespace common\models;


/**
 * This is the model class for table "{{%assigned_indian_jobs}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_job_enc_id Assigned Industry Encrypted ID
 * @property string $job_enc_id Foreign Key to Industries Table
 * @property string $dept_enc_id Foreign Key to Business Activities Table
 * @property string $created_on On which date Industry information was added to database
 * @property string $created_by By which User Industry information was added
 * @property string $last_updated_on On which date Industry information was updated
 * @property string $last_updated_by By which User Industry information was updated
 *
 * @property IndianGovtJobs $jobEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property IndianGovtDepartments $deptEnc
 */
class AssignedIndianJobs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_indian_jobs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_job_enc_id', 'job_enc_id', 'dept_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['assigned_job_enc_id', 'job_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['dept_enc_id'], 'string', 'max' => 200],
            [['assigned_job_enc_id'], 'unique'],
            [['job_enc_id', 'dept_enc_id'], 'unique', 'targetAttribute' => ['job_enc_id', 'dept_enc_id']],
            [['job_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => IndianGovtJobs::className(), 'targetAttribute' => ['job_enc_id' => 'job_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['dept_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => IndianGovtDepartments::className(), 'targetAttribute' => ['dept_enc_id' => 'dept_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobEnc()
    {
        return $this->hasOne(IndianGovtJobs::className(), ['job_enc_id' => 'job_enc_id']);
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
    public function getDeptEnc()
    {
        return $this->hasOne(IndianGovtDepartments::className(), ['dept_enc_id' => 'dept_enc_id']);
    }
}
