<?php
namespace common\models;


/**
 * This is the model class for table "{{%loan_application_leads}}".
 *
 * @property int $id Primary Key
 * @property string $lead_enc_id Encrypted Key
 * @property string $application_number application_number
 * @property string $student_name
 * @property string $student_mobile_number
 * @property string $university_name
 * @property string $course_name
 * @property double $course_fee_annual
 * @property int $payment_fee_recieved 0 for not 1 for yes
 * @property string $created_on
 * @property string $created_by may be null or not , filler id who has filled the form
 * @property string $last_updated_by
 * @property string $last_updated_on
 *
 * @property LeadsParentInformation[] $leadsParentInformations
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class LoanApplicationLeads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_application_leads}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lead_enc_id', 'application_number', 'student_name'], 'required'],
            [['course_fee_annual'], 'number'],
            [['payment_fee_recieved'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['lead_enc_id', 'application_number', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['student_name'], 'string', 'max' => 200],
            [['student_mobile_number'], 'string', 'max' => 15],
            [['university_name', 'course_name'], 'string', 'max' => 255],
            [['lead_enc_id'], 'unique'],
            [['application_number'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsParentInformations()
    {
        return $this->hasMany(LeadsParentInformation::className(), ['lead_enc_id' => 'lead_enc_id']);
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
