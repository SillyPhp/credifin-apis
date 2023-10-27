<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_applications_references}}".
 *
 * @property int $id Primary Id
 * @property string $references_enc_id References Enc Id
 * @property string $loan_app_enc_id Loan App Enc Id
 * @property string $type Type
 * @property string $value Value
 * @property string $name Name
 * @property string $reference Reference
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated On
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property LoanApplications $loanAppEnc
 */
class LoanApplicationsReferences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_applications_references}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['references_enc_id', 'loan_app_enc_id', 'value', 'name', 'reference', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['value'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['references_enc_id', 'loan_app_enc_id', 'type', 'name', 'reference', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['references_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
        ];
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
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }
}
