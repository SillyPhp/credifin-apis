<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%candidate_rejection_reasons}}".
 *
 * @property int $id
 * @property string $candidate_rejection_reasons_enc_id
 * @property string $candidate_rejection_enc_id
 * @property string $rejection_reasons_enc_id
 * @property string $created_on
 * @property string $created_by
 *
 * @property CandidateRejection $candidateRejectionEnc
 * @property RejectionReasons $rejectionReasonsEnc
 * @property Users $createdBy
 */
class CandidateRejectionReasons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%candidate_rejection_reasons}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['candidate_rejection_reasons_enc_id', 'candidate_rejection_enc_id', 'rejection_reasons_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['candidate_rejection_reasons_enc_id', 'candidate_rejection_enc_id', 'rejection_reasons_enc_id', 'created_by'], 'string', 'max' => 100],
            [['candidate_rejection_reasons_enc_id'], 'unique'],
            [['candidate_rejection_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CandidateRejection::className(), 'targetAttribute' => ['candidate_rejection_enc_id' => 'candidate_rejection_enc_id']],
            [['rejection_reasons_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => RejectionReasons::className(), 'targetAttribute' => ['rejection_reasons_enc_id' => 'rejection_reason_enc_id']],
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
    public function getRejectionReasonsEnc()
    {
        return $this->hasOne(RejectionReasons::className(), ['rejection_reason_enc_id' => 'rejection_reasons_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
