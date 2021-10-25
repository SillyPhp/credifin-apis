<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%erexx_college_rejection_reasons}}".
 *
 * @property int $id
 * @property string $erexx_college_rejection_reasons_enc_id
 * @property string $erexx_college_rejection_enc_id
 * @property string $reason_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted
 *
 * @property RejectionReasons $reasonEnc
 * @property Users $createdBy
 * @property ErexxCollegeRejections $erexxCollegeRejectionEnc
 * @property Users $createdBy0
 */
class ErexxCollegeRejectionReasons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%erexx_college_rejection_reasons}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['erexx_college_rejection_reasons_enc_id', 'erexx_college_rejection_enc_id', 'reason_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['erexx_college_rejection_reasons_enc_id', 'erexx_college_rejection_enc_id', 'reason_enc_id', 'created_by'], 'string', 'max' => 100],
            [['erexx_college_rejection_reasons_enc_id'], 'unique'],
            [['reason_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => RejectionReasons::className(), 'targetAttribute' => ['reason_enc_id' => 'rejection_reason_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['erexx_college_rejection_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ErexxCollegeRejections::className(), 'targetAttribute' => ['erexx_college_rejection_enc_id' => 'erexx_college_rejection_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReasonEnc()
    {
        return $this->hasOne(RejectionReasons::className(), ['rejection_reason_enc_id' => 'reason_enc_id']);
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
    public function getErexxCollegeRejectionEnc()
    {
        return $this->hasOne(ErexxCollegeRejections::className(), ['erexx_college_rejection_enc_id' => 'erexx_college_rejection_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
