<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%employees_cash_report}}".
 *
 * @property int $id
 * @property string $cash_report_enc_id Cash Report Enc Id
 * @property string $parent_cash_report_enc_id Parent Cash Report Enc Id
 * @property string $emi_collection_enc_id Emi Collection Enc Id
 * @property string $received_from Received From Id
 * @property string $given_to Given To Id
 * @property int $type 0 as Collected Cash Emi, 1 as Bank Deposit, 2 as Given to other employee
 * @property string $image Image Name
 * @property string $image_location Image Location
 * @property double $amount Amount
 * @property double $remaining_amount Remaining Amount
 * @property string $remarks Remarks
 * @property string $reference_number Ref no
 * @property int $status 0 as Pending, 1 as Approved, 2 as Waiting for approval
 * @property string $approved_on Approved On
 * @property string $approved_by Approved By
 * @property string $created_on Created On
 * @property string $created_by Created By
 * @property string $updated_on Updated on
 * @property string $updated_by Updated By
 * @property int $is_deleted Is Deleted
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property Users $approvedBy
 * @property EmployeesCashReport $parentCashReportEnc
 * @property EmployeesCashReport[] $employeesCashReports
 * @property Users $receivedFrom
 * @property Users $givenTo
 * @property EmiCollection $emiCollectionEnc
 */
class EmployeesCashReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employees_cash_report}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cash_report_enc_id', 'amount', 'remaining_amount', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['type', 'status', 'is_deleted'], 'integer'],
            [['amount', 'remaining_amount'], 'number'],
            [['approved_on', 'created_on', 'updated_on'], 'safe'],
            [['cash_report_enc_id', 'parent_cash_report_enc_id', 'emi_collection_enc_id', 'received_from', 'given_to', 'image', 'image_location', 'remarks', 'reference_number', 'approved_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['cash_report_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['approved_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['approved_by' => 'user_enc_id']],
            [['parent_cash_report_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeesCashReport::className(), 'targetAttribute' => ['parent_cash_report_enc_id' => 'cash_report_enc_id']],
            [['received_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['received_from' => 'user_enc_id']],
            [['given_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['given_to' => 'user_enc_id']],
            [['emi_collection_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmiCollection::className(), 'targetAttribute' => ['emi_collection_enc_id' => 'emi_collection_enc_id']],
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApprovedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'approved_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCashReportEnc()
    {
        return $this->hasOne(EmployeesCashReport::className(), ['cash_report_enc_id' => 'parent_cash_report_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeesCashReports()
    {
        return $this->hasMany(EmployeesCashReport::className(), ['parent_cash_report_enc_id' => 'cash_report_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedFrom()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'received_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGivenTo()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'given_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmiCollectionEnc()
    {
        return $this->hasOne(EmiCollection::className(), ['emi_collection_enc_id' => 'emi_collection_enc_id']);
    }
}
