<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_account_ptps}}".
 *
 * @property int $id
 * @property string $ptp_enc_id
 * @property string $emi_collection_enc_id
 * @property int $proposed_payment_method
 * @property string $proposed_date
 * @property double $proposed_amount
 * @property int $status 1 as Pending, 2 as Pipeline, 3 as Paid, 4 as Failed, 5 as Rejected
 * @property string $collection_manager
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted
 *
 * @property EmiCollection $emiCollectionEnc
 * @property Users $collectionManager
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class LoanAccountPtps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_account_ptps}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ptp_enc_id', 'emi_collection_enc_id', 'proposed_date', 'proposed_amount', 'created_by', 'created_on'], 'required'],
            [['proposed_payment_method', 'status', 'is_deleted'], 'integer'],
            [['proposed_date', 'created_on', 'updated_on'], 'safe'],
            [['proposed_amount'], 'number'],
            [['ptp_enc_id', 'emi_collection_enc_id', 'collection_manager', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['ptp_enc_id'], 'unique'],
            [['emi_collection_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmiCollection::className(), 'targetAttribute' => ['emi_collection_enc_id' => 'emi_collection_enc_id']],
            [['collection_manager'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['collection_manager' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmiCollectionEnc()
    {
        return $this->hasOne(EmiCollection::className(), ['emi_collection_enc_id' => 'emi_collection_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionManager()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'collection_manager']);
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
