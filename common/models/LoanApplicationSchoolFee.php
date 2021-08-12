<?php
namespace common\models;


/**
 * This is the model class for table "{{%loan_application_school_fee}}".
 *
 * @property int $id Primary Key
 * @property string $school_fee_enc_id Encrypted ID
 * @property string $loan_app_enc_id
 * @property string $student_name
 * @property string $school_name
 * @property double $loan_amount
 * @property string $class
 * @property string $stream
 * @property string $created_on On which date  information was added to database
 * @property string $created_by By which User  information was added
 * @property string $last_updated_on On which date  information was updated
 * @property string $last_updated_by By which User information was updated
 * @property int $is_deleted Is Deleted (0 as False, 1 as True)
 *
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property LoanApplications $loanAppEnc
 */
class LoanApplicationSchoolFee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_school_fee}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_fee_enc_id', 'loan_app_enc_id', 'student_name', 'school_name', 'loan_amount', 'class'], 'required'],
            [['loan_amount'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['school_fee_enc_id', 'loan_app_enc_id', 'student_name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['school_name', 'class', 'stream'], 'string', 'max' => 255],
            [['school_fee_enc_id'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }
}
