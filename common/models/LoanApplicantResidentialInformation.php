<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_applicant_residential_information}}".
 *
 * @property int $id
 * @property string $loan_app_res_info_enc_id
 * @property string $loan_app_enc_id loan encrypted id
 * @property string $loan_co_app_enc_id
 * @property int $residential_type 0 Permanent Address,1 Current Address
 * @property int $type 0 Rented, 1 Owned
 * @property string $address applicant address
 * @property string $city applicant city
 * @property string $state applicant state
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted
 *
 * @property States $loanAppEnc
 */
class LoanApplicantResidentialInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_applicant_residential_information}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'loan_app_res_info_enc_id', 'created_by'], 'required'],
            [['id', 'residential_type', 'type', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['loan_app_res_info_enc_id', 'loan_app_enc_id', 'loan_co_app_enc_id', 'address', 'city', 'state', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['loan_app_res_info_enc_id'], 'unique'],
            [['id'], 'unique'],
            [['loan_app_enc_id', 'loan_co_app_enc_id', 'created_by', 'updated_by', 'city', 'state'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id', 'loan_co_app_enc_id' => 'loan_co_app_enc_id', 'created_by' => 'user_enc_id', 'updated_by' => 'user_enc_id', 'city' => 'city_enc_id', 'state' => 'state_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanAppEnc()
    {
        return $this->hasOne(States::className(), ['loan_app_enc_id' => 'loan_app_enc_id', 'loan_co_app_enc_id' => 'loan_co_app_enc_id', 'user_enc_id' => 'updated_by', 'city_enc_id' => 'city', 'state_enc_id' => 'state']);
    }
}
