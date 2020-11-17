<?php
namespace common\models;

/**
 * This is the model class for table "{{%institute_leads}}".
 *
 * @property int $id Primary Key
 * @property string $lead_enc_id Encrypted ID
 * @property string $organization_name
 * @property string $org_type_name
 * @property string $email
 * @property string $contact
 * @property string $ownership_type
 * @property int $loan_amount
 * @property int $annual_turnover
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property OrganizationTypes $ownershipType
 * @property InstituteLeadsPayments[] $instituteLeadsPayments
 */
class InstituteLeads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%institute_leads}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lead_enc_id', 'organization_name', 'org_type_name', 'email', 'contact', 'ownership_type', 'loan_amount', 'annual_turnover', 'created_on'], 'required'],
            [['loan_amount', 'annual_turnover', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['lead_enc_id', 'org_type_name', 'email', 'ownership_type', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['organization_name'], 'string', 'max' => 200],
            [['contact'], 'string', 'max' => 10],
            [['lead_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['ownership_type'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationTypes::className(), 'targetAttribute' => ['ownership_type' => 'organization_type_enc_id']],
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
    public function getOwnershipType()
    {
        return $this->hasOne(OrganizationTypes::className(), ['organization_type_enc_id' => 'ownership_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituteLeadsPayments()
    {
        return $this->hasMany(InstituteLeadsPayments::className(), ['lead_enc_id' => 'lead_enc_id']);
    }
}
