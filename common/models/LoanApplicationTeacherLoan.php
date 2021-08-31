<?php
namespace common\models;

/**
 * This is the model class for table "{{%loan_application_teacher_loan}}".
 *
 * @property int $id Primary Key
 * @property string $teacher_loan_enc_id Encrypted ID
 * @property string $loan_app_enc_id
 * @property string $institution_name
 * @property string $employement_type
 * @property int $years
 * @property int $months
 * @property string $created_on On which date  information was added to database
 * @property string $created_by By which User  information was added
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User information was updated
 * @property int $is_deleted Is Deleted (0 as False, 1 as True)
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class LoanApplicationTeacherLoan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_teacher_loan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_loan_enc_id', 'loan_app_enc_id', 'institution_name', 'employement_type', 'years', 'months', 'created_by'], 'required'],
            [['employement_type'], 'string'],
            [['years', 'months', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['teacher_loan_enc_id', 'loan_app_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['institution_name'], 'string', 'max' => 255],
            [['teacher_loan_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }
}
