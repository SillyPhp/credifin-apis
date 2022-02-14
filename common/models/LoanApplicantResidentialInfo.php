<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_applicant_residential_info}}".
 *
 * @property int $id
 * @property string $loan_app_res_info_enc_id
 * @property string $loan_app_enc_id loan encrypted id
 * @property string $loan_co_app_enc_id
 * @property int $residential_type 0 Permanent Address,1 Current Address
 * @property int $type 0 Rented, 1 Owned
 * @property string $address applicant address
 * @property string $city_enc_id
 * @property string $state_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_sane_cur_addr 1 as No, 2 as Yes
 * @property int $is_deleted
 *
 * @property LoanApplications $loanAppEnc
 * @property LoanCoApplicants $loanCoAppEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Cities $cityEnc
 * @property States $stateEnc
 */
class LoanApplicantResidentialInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_applicant_residential_info}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_app_res_info_enc_id', 'created_by'], 'required'],
            [['residential_type', 'type', 'is_sane_cur_addr', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['loan_app_res_info_enc_id', 'loan_app_enc_id', 'loan_co_app_enc_id', 'address', 'city_enc_id', 'state_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['loan_app_res_info_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['loan_co_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanCoApplicants::className(), 'targetAttribute' => ['loan_co_app_enc_id' => 'loan_co_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
            [['state_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_enc_id' => 'state_enc_id']],
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
    public function getLoanCoAppEnc()
    {
        return $this->hasOne(LoanCoApplicants::className(), ['loan_co_app_enc_id' => 'loan_co_app_enc_id']);
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
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStateEnc()
    {
        return $this->hasOne(States::className(), ['state_enc_id' => 'state_enc_id']);
    }
}
