<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%candidate_consider_jobs}}".
 *
 * @property int $id
 * @property string $consider_job_enc_id
 * @property string $candidate_rejection_enc_id
 * @property string $application_enc_id
 * @property string $created_on
 * @property string $created_by
 *
 * @property CandidateRejection $candidateRejectionEnc
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 */
class CandidateConsiderJobs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%candidate_consider_jobs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consider_job_enc_id', 'candidate_rejection_enc_id', 'application_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['consider_job_enc_id', 'candidate_rejection_enc_id', 'application_enc_id', 'created_by'], 'string', 'max' => 100],
            [['consider_job_enc_id'], 'unique'],
            [['candidate_rejection_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CandidateRejection::className(), 'targetAttribute' => ['candidate_rejection_enc_id' => 'candidate_rejection_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateRejectionEnc()
    {
        return $this->hasOne(CandidateRejection::className(), ['candidate_rejection_enc_id' => 'candidate_rejection_enc_id']);
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
}
