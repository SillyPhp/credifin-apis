<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%esign_vehicle_loan_details}}".
 *
 * @property int $id
 * @property string $vehicle_loan_id
 * @property string $agreement_id
 * @property string $is_dl driving license yes or no
 * @property string $dl_number driving license number
 * @property int $vehicle_type 1 for 2 wheeler 2 for 3 wheeler  3 for 4 four wheeler
 * @property string $vehicle_purchase_option Purchase or Preowned
 * @property string $make make of vehicle
 * @property string $model_name model name
 * @property string $model_year model year
 * @property string $chassis_number
 * @property string $chassis_image_url
 * @property string $vehicle_conditon condition new or old
 * @property double $invoice_amount
 * @property double $Insurance
 * @property double $rc
 * @property double $accessories
 * @property double $hypothecation
 * @property double $others others expenses
 * @property string $date_created
 * @property string $updated_on
 *
 * @property EsignAgreementDetails $agreement
 */
class EsignVehicleLoanDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%esign_vehicle_loan_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_loan_id', 'agreement_id', 'make', 'model_name', 'model_year', 'chassis_number', 'invoice_amount', 'Insurance', 'rc', 'accessories', 'hypothecation'], 'required'],
            [['is_dl', 'vehicle_purchase_option', 'vehicle_conditon'], 'string'],
            [['vehicle_type'], 'integer'],
            [['invoice_amount', 'Insurance', 'rc', 'accessories', 'hypothecation', 'others'], 'number'],
            [['date_created', 'updated_on'], 'safe'],
            [['vehicle_loan_id', 'agreement_id', 'dl_number', 'make', 'model_name', 'model_year', 'chassis_number', 'chassis_image_url'], 'string', 'max' => 200],
            [['vehicle_loan_id'], 'unique'],
            [['agreement_id'], 'exist', 'skipOnError' => true, 'targetClass' => EsignAgreementDetails::className(), 'targetAttribute' => ['agreement_id' => 'agreement_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgreement()
    {
        return $this->hasOne(EsignAgreementDetails::className(), ['agreement_id' => 'agreement_id']);
    }
}
