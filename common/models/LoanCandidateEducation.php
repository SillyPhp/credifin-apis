<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_candidate_education}}".
 *
 * @property int $id
 * @property string $loan_candidate_edu_enc_id
 * @property string $loan_app_enc_id
 * @property string $qualification_enc_id
 * @property string $institution
 * @property double $obtained_marks
 * @property string $proof_image
 * @property string $proof_image_name
 * @property string $proof_image_location
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanQualificationType $qualificationEnc
 */
class LoanCandidateEducation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_candidate_education}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_candidate_edu_enc_id', 'loan_app_enc_id', 'created_by'], 'required'],
            [['obtained_marks'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_candidate_edu_enc_id', 'loan_app_enc_id', 'qualification_enc_id', 'proof_image', 'proof_image_name', 'proof_image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['institution'], 'string', 'max' => 250],
            [['loan_candidate_edu_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['qualification_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanQualificationType::className(), 'targetAttribute' => ['qualification_enc_id' => 'qualification_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'loan_candidate_edu_enc_id' => Yii::t('common', 'Loan Candidate Edu Enc ID'),
            'loan_app_enc_id' => Yii::t('common', 'Loan App Enc ID'),
            'qualification_enc_id' => Yii::t('common', 'Qualification Enc ID'),
            'institution' => Yii::t('common', 'Institution'),
            'obtained_marks' => Yii::t('common', 'Obtained Marks'),
            'proof_image' => Yii::t('common', 'Proof Image'),
            'proof_image_name' => Yii::t('common', 'Proof Image Name'),
            'proof_image_location' => Yii::t('common', 'Proof Image Location'),
            'created_by' => Yii::t('common', 'Created By'),
            'created_on' => Yii::t('common', 'Created On'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'updated_on' => Yii::t('common', 'Updated On'),
            'is_deleted' => Yii::t('common', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualificationEnc()
    {
        return $this->hasOne(LoanQualificationType::className(), ['qualification_enc_id' => 'qualification_enc_id']);
    }
}
