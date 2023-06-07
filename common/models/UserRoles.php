<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_roles}}".
 *
 * @property int $id Primary Key
 * @property string $role_enc_id Role Encrypted ID
 * @property string $user_type_enc_id Foreign Key to user type enc id
 * @property string|null $user_enc_id Foreign Key to user  enc id
 * @property string|null $organization_enc_id Foreign Key to organization enc id
 * @property string|null $designation_enc_id Foreign Key to desiganation enc id
 * @property string|null $designation_id Foreign Key to financer assigned designation
 * @property string|null $employee_code employee code
 * @property string|null $reporting_person reporting person id
 * @property string|null $branch_enc_id branch enc id
 * @property string|null $grade grades
 * @property string $created_on current time stamp
 * @property string $created_by create by enc id
 * @property string|null $updated_by updated by
 * @property string|null $updated_on updated on
 * @property int $is_deleted 0 as not deleted, 1 as deleted
 *
 * @property OrganizationLocations $branchEnc
 * @property FinancerAssignedDesignations $designation
 * @property Designations $designationEnc
 * @property LoanApplicationCommissions[] $loanApplicationCommissions
 * @property Organizations $organizationEnc
 * @property Users $reportingPerson
 * @property Users $userEnc
 * @property UserTypes $userTypeEnc
 */
class UserRoles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_roles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_enc_id', 'user_type_enc_id', 'created_on', 'created_by'], 'required'],
            [['grade'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['role_enc_id', 'user_type_enc_id', 'user_enc_id', 'organization_enc_id', 'designation_enc_id', 'designation_id', 'employee_code', 'reporting_person', 'branch_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['role_enc_id'], 'unique'],
            [['user_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::className(), 'targetAttribute' => ['user_type_enc_id' => 'user_type_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['designation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation_enc_id' => 'designation_enc_id']],
            [['reporting_person'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['reporting_person' => 'user_enc_id']],
            [['branch_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationLocations::className(), 'targetAttribute' => ['branch_enc_id' => 'location_enc_id']],
            [['designation_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancerAssignedDesignations::className(), 'targetAttribute' => ['designation_id' => 'assigned_designation_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicationCommissions()
    {
        return $this->hasMany(LoanApplicationCommissions::className(), ['role_enc_id' => 'role_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTypeEnc()
    {
        return $this->hasOne(UserTypes::className(), ['user_type_enc_id' => 'user_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignationEnc()
    {
        return $this->hasOne(Designations::className(), ['designation_enc_id' => 'designation_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportingPerson()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'reporting_person']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchEnc()
    {
        return $this->hasOne(OrganizationLocations::className(), ['location_enc_id' => 'branch_enc_id']);
    }

    /**
     * Gets query for [[Designation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDesignation()
    {
        return $this->hasOne(FinancerAssignedDesignations::className(), ['assigned_designation_enc_id' => 'designation_id']);
    }
}
