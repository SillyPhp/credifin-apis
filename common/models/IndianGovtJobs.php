<?php

namespace common\models;


/**
 * This is the model class for table "{{%indian_govt_jobs}}".
 *
 * @property int $id Primary Key
 * @property string $job_enc_id Job Encrypted ID
 * @property string $Organizations name of the organizations
 * @property string $Location location
 * @property string $Position job title or position
 * @property string $Eligibility qualification
 * @property string $Pdf_link link to govt cdn pdf
 * @property string $slug slug
 * @property string $Last_date last date to apply
 * @property string $job_id unique job id for website
 * @property string $Data content
 * @property string $created_by user who posted
 * @property string $created_on Time date
 *
 * @property AssignedIndianJobs[] $assignedIndianJobs
 * @property IndianGovtDepartments[] $deptEncs
 * @property Users $createdBy
 */
class IndianGovtJobs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%indian_govt_jobs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_enc_id', 'Organizations', 'Location', 'Position', 'Pdf_link', 'job_id', 'Data', 'created_by'], 'required'],
            [['Position', 'Eligibility', 'Data'], 'string'],
            [['created_on'], 'safe'],
            [['job_enc_id', 'created_by'], 'string', 'max' => 100],
            [['Organizations', 'Location', 'Pdf_link', 'slug', 'Last_date', 'job_id'], 'string', 'max' => 200],
            [['job_enc_id'], 'unique'],
            [['job_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedIndianJobs()
    {
        return $this->hasMany(AssignedIndianJobs::className(), ['job_enc_id' => 'job_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptEncs()
    {
        return $this->hasMany(IndianGovtDepartments::className(), ['dept_enc_id' => 'dept_enc_id'])->viaTable('{{%assigned_indian_jobs}}', ['job_enc_id' => 'job_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
