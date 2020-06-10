<?php

namespace common\models;


/**
 * This is the model class for table "{{%Indian_Govt_Departments}}".
 *
 * @property int $id Primary Key
 * @property string $dept_enc_id
 * @property string $Value
 * @property string $Acronym
 * @property string $slug
 * @property string $LastModified
 * @property string $IsDisabled
 * @property string $image
 * @property string $image_location
 * @property int $total_applications
 * @property string $last_retrieved_by By which User Department information was Last Retrieved
 * @property string $last_retrieved_on On which date Department information was Last Retrieved to database
 *
 * @property Users $lastRetrievedBy
 * @property AssignedIndianJobs[] $assignedIndianJobs
 * @property IndianGovtJobs[] $jobEncs
 */
class IndianGovtDepartments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Indian_Govt_Departments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dept_enc_id', 'Value', 'slug'], 'required'],
            [['total_applications'], 'integer'],
            [['last_retrieved_on'], 'safe'],
            [['dept_enc_id', 'Value', 'slug'], 'string', 'max' => 200],
            [['Acronym', 'IsDisabled'], 'string', 'max' => 10],
            [['LastModified', 'last_retrieved_by'], 'string', 'max' => 100],
            [['image', 'image_location'], 'string', 'max' => 50],
            [['Value'], 'unique'],
            [['slug'], 'unique'],
            [['dept_enc_id'], 'unique'],
            [['last_retrieved_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_retrieved_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastRetrievedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_retrieved_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedIndianJobs()
    {
        return $this->hasMany(AssignedIndianJobs::className(), ['dept_enc_id' => 'dept_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobEncs()
    {
        return $this->hasMany(IndianGovtJobs::className(), ['job_enc_id' => 'job_enc_id'])->viaTable('{{%assigned_indian_jobs}}', ['dept_enc_id' => 'dept_enc_id']);
    }
}
