<?php

namespace common\models;

/**
 * This is the model class for table "{{%employee_benefits}}".
 *
 * @property int $id Primary Key
 * @property string $benefit_enc_id Benefit Encrypted ID
 * @property string $benefit Benefit
 * @property string $icon Benefit Icon
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Benefit information was added to database
 * @property string $created_by By which User Benefit information was added
 * @property string $last_updated_on On which date Benefit information was updated
 * @property string $last_updated_by By which User Benefit information was updated
 * @property string $status Benefit Status (Publish, Pending)
 * @property int $is_deleted Is Benefit Deleted (0 As False, 1 As True)
 *
 * @property ApplicationEmployeeBenefits[] $applicationEmployeeBenefits
 * @property OrganizationEmployeeBenefits[] $organizationEmployeeBenefits
 */
class EmployeeBenefits extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%employee_benefits}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['benefit_enc_id', 'benefit', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['is_deleted'], 'integer'],
            [['benefit_enc_id', 'benefit', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 50],
            [['benefit_enc_id'], 'unique'],
            [['benefit'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEmployeeBenefits() {
        return $this->hasMany(ApplicationEmployeeBenefits::className(), ['benefit_enc_id' => 'benefit_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEmployeeBenefits() {
        return $this->hasMany(OrganizationEmployeeBenefits::className(), ['benefit_enc_id' => 'benefit_enc_id']);
    }

}
