<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_verification_locations}}".
 *
 * @property int $id
 * @property string $loan_verification_enc_id loan verification encrypted id
 * @property string $loan_app_enc_id loan application enc id
 * @property string $location_name location name
 * @property string $local_address location local address
 * @property double $latitude latitude of location
 * @property double $longitude longitude of location
 * @property string $created_on created on
 * @property string $created_by created by
 * @property string $updated_on updated on
 * @property string $updated_by updated by
 * @property int $is_deleted 0 false, 1 true
 *
 * @property LoanApplications $loanAppEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class LoanVerificationLocations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_verification_locations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_verification_enc_id', 'loan_app_enc_id', 'created_by'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_verification_enc_id', 'loan_app_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['location_name'], 'string', 'max' => 250],
            [['local_address'], 'string', 'max' => 500],
            [['loan_verification_enc_id'], 'unique'],
            [['loan_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplications::className(), 'targetAttribute' => ['loan_app_enc_id' => 'loan_app_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }
}
