<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rejection_reasons}}".
 *
 * @property int $id
 * @property string $rejection_reason_enc_id
 * @property string $reason
 * @property int $reason_by 0 college,1 company
 * @property int $reason_for 0 company, 1 job
 * @property string $organization_enc_id
 * @property string $status Pending,Approved
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property CandidateRejectionReasons[] $candidateRejectionReasons
 * @property ErexxCollegeRejectionReasons[] $erexxCollegeRejectionReasons
 * @property Users $createdBy
 * @property Organizations $organizationEnc
 */
class RejectionReasons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rejection_reasons}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rejection_reason_enc_id', 'reason', 'reason_by', 'created_by'], 'required'],
            [['reason_by', 'reason_for', 'is_deleted'], 'integer'],
            [['status'], 'string'],
            [['created_on'], 'safe'],
            [['rejection_reason_enc_id', 'reason', 'organization_enc_id', 'created_by'], 'string', 'max' => 100],
            [['rejection_reason_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidateRejectionReasons()
    {
        return $this->hasMany(CandidateRejectionReasons::className(), ['rejection_reasons_enc_id' => 'rejection_reason_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxCollegeRejectionReasons()
    {
        return $this->hasMany(ErexxCollegeRejectionReasons::className(), ['reason_enc_id' => 'rejection_reason_enc_id']);
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
