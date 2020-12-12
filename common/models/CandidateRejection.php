<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%candidate_rejection}}".
 *
 * @property int $id
 * @property string $candidate_rejection_enc_id
 * @property string $applied_application_enc_id
 * @property int $rejection_type 1 permanent reject, 2 consider for other job, 3 save for latter
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 false, 1 true
 *
 * @property CandidateConsiderJobs[] $candidateConsiderJobs
 * @property AppliedApplications $appliedApplicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property CandidateRejectionReasons[] $candidateRejectionReasons
 */
class CandidateRejection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%candidate_rejection}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['candidate_rejection_enc_id', 'applied_application_enc_id', 'rejection_type', 'created_on', 'created_by'], 'required'],
            [['rejection_type', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['candidate_rejection_enc_id', 'applied_application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['candidate_rejection_enc_id'], 'unique'],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateConsiderJobs()
    {
        return $this->hasMany(CandidateConsiderJobs::className(), ['candidate_rejection_enc_id' => 'candidate_rejection_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc()
    {
        return $this->hasOne(AppliedApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
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
    public function getCandidateRejectionReasons()
    {
        return $this->hasMany(CandidateRejectionReasons::className(), ['candidate_rejection_enc_id' => 'candidate_rejection_enc_id']);
    }
}
