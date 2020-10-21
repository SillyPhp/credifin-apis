<?php

namespace common\models;

/**
 * This is the model class for table "{{%loan_applications_college_preference}}".
 *
 * @property int $id Primary Key
 * @property string $preference_enc_id preference enc id of college
 * @property string $loan_app_enc_id Encrypted Key
 * @property string $college_name
 * @property int $sequence
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_by
 * @property string $last_updated_on
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property LoanApplications $loanAppEnc
 */
class LoanApplicationsCollegePreference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_applications_college_preference}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preference_enc_id', 'loan_app_enc_id', 'college_name'], 'required'],
            [['sequence'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['preference_enc_id', 'loan_app_enc_id', 'college_name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['preference_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }
}
