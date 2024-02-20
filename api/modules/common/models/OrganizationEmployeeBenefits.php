<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_employee_benefits}}".
 *
 * @property int $id Primary Key
 * @property string $organization_benefit_enc_id Organization Benefit Encrypted ID
 * @property string $benefit_enc_id Foreign Key to Employee Benefits Table
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property int $is_available Is Benefit Available (0 as False, 1 as True)
 * @property string $created_on On which date Organization Benefit information was added to database
 * @property string $created_by By which User Organization Benefit information was added
 * @property string $last_updated_on On which date Organization Benefit information was updated
 * @property string $last_updated_by By which User Organization Benefit information was updated
 * @property int $is_deleted Is Organization Benefit Deleted (0 As False, 1 As True)
 *
 * @property EmployeeBenefits $benefitEnc
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class OrganizationEmployeeBenefits extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%organization_employee_benefits}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['organization_benefit_enc_id', 'benefit_enc_id', 'organization_enc_id', 'created_on', 'created_by'], 'required'],
            [['is_available', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['organization_benefit_enc_id', 'benefit_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['organization_benefit_enc_id'], 'unique'],
            [['benefit_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeBenefits::className(), 'targetAttribute' => ['benefit_enc_id' => 'benefit_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBenefitEnc() {
        return $this->hasOne(EmployeeBenefits::className(), ['benefit_enc_id' => 'benefit_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc() {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

}
