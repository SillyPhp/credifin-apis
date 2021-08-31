<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%path_to_claim_org_loan_application}}".
 *
 * @property int $id Primary Key
 * @property string $bridge_enc_id Name
 * @property string $loan_app_enc_id
 * @property string $assigned_course_enc_id
 * @property string $country_enc_id
 * @property string $created_by
 *
 * @property Users $createdBy
 * @property AssignedCollegeCourses $assignedCourseEnc
 * @property LoanApplications $loanAppEnc
 */
class PathToClaimOrgLoanApplication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%path_to_claim_org_loan_application}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bridge_enc_id', 'loan_app_enc_id', 'assigned_course_enc_id'], 'required'],
            [['bridge_enc_id', 'loan_app_enc_id', 'assigned_course_enc_id', 'country_enc_id', 'created_by'], 'string', 'max' => 100],
            [['bridge_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['assigned_course_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCollegeCourses::className(), 'targetAttribute' => ['assigned_course_enc_id' => 'assigned_college_enc_id']],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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
    public function getAssignedCourseEnc()
    {
        return $this->hasOne(AssignedCollegeCourses::className(), ['assigned_college_enc_id' => 'assigned_course_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(LoanApplications::className(), ['loan_app_enc_id' => 'loan_app_enc_id']);
    }
    public function getCountryEnc()
    {
        return $this->hasOne(Countries::className(), ['country_enc_id' => 'country_enc_id']);
    }
}
